<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Maintenance;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMaintenanceRequest;
use App\Http\Requests\UpdateMaintenanceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    public function index(Request $request): View
    {
        $query = Maintenance::with(['equipment.equipmentType', 'user']);

        // Filtros
        if ($request->filled('equipment_id')) {
            $query->where('equipment_id', $request->equipment_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->where('scheduled_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('scheduled_date', '<=', $request->date_to);
        }

        $maintenances = $query->orderBy('scheduled_date', 'desc')->paginate(15);

        // Datos para filtros
        $equipment = Equipment::with('equipmentType')
            ->orderBy('code')
            ->get();

        return view('maintenances.index', compact('maintenances', 'equipment'));
    }

    public function show(Maintenance $maintenance): View
    {
        $maintenance->load(['equipment.equipmentType', 'user']);

        return view('maintenances.show', compact('maintenance'));
    }

    public function create(Equipment $equipment)
    {
        return view('maintenances.create', [
            'equipment' => $equipment,
            'user' => Auth::user()
        ]);
    }

    public function store(StoreMaintenanceRequest $request): RedirectResponse
    {
        // Procesar parts_used si viene como texto
        $validated = $request->validated();
        if (isset($validated['parts_used_text']) && !empty($validated['parts_used_text'])) {
            $parts = array_filter(array_map('trim', explode("\n", $validated['parts_used_text'])));
            $validated['parts_used'] = $parts;
        }
        unset($validated['parts_used_text']); // Remover el campo de texto

        $maintenance = Maintenance::create([
            ...$validated,
            'user_id' => auth()->id()
        ]);

        // ✅ ACTUALIZAR EL STATUS DEL EQUIPMENT A "maintenance"
        $maintenance->equipment->update(['status' => 'maintenance']);

        // Actualizar cache del equipment
        $maintenance->equipment->updateMaintenanceCache();

        return redirect()
            ->route('maintenances.show', $maintenance)
            ->with('success', 'Mantenimiento programado exitosamente. El equipo ha sido marcado como "En Mantenimiento".');
    }

    public function edit(Maintenance $maintenance): View
    {
        $equipment = Equipment::with('equipmentType')
            ->active()
            ->orderBy('code')
            ->get();

        return view('maintenances.edit', compact('maintenance', 'equipment'));
    }

    public function update(UpdateMaintenanceRequest $request, Maintenance $maintenance): RedirectResponse
    {
        $maintenance->update($request->validated());

        // Actualizar cache del equipment
        $maintenance->equipment->updateMaintenanceCache();

        return redirect()
            ->route('maintenances.show', $maintenance)
            ->with('success', 'Mantenimiento actualizado exitosamente.');
    }

    public function destroy(Maintenance $maintenance): RedirectResponse
    {
        $equipment = $maintenance->equipment;

        // Al eliminar un mantenimiento, revisar si debe cambiar el estado del equipo
        $hasOtherPendingMaintenance = $equipment->maintenances()
            ->where('id', '!=', $maintenance->id)
            ->whereNull('completed_date')  // ✅ CORREGIDO: usar fechas en lugar de status
            ->exists();

        $maintenance->delete();

        // Si no tiene otros mantenimientos pendientes, cambiar estado a activo
        if (!$hasOtherPendingMaintenance) {
            $equipment->update(['status' => 'active']);
        }

        // Actualizar cache del equipment
        $equipment->updateMaintenanceCache();

        return redirect()
            ->route('maintenances.index')
            ->with('success', 'Mantenimiento eliminado exitosamente.');
    }

    public function start(Maintenance $maintenance): RedirectResponse
    {
        // ✅ CORREGIDO: usar fechas para verificar el estado
        if ($maintenance->started_date || $maintenance->completed_date) {
            return back()->with('error', 'Este mantenimiento ya fue iniciado o completado.');
        }

        $maintenance->update([
            'started_date' => now()
        ]);

        // Asegurar que el equipo esté marcado como en mantenimiento
        $maintenance->equipment->update(['status' => 'maintenance']);

        return back()->with('success', 'Mantenimiento iniciado.');
    }

    public function complete(Request $request, Maintenance $maintenance): RedirectResponse
    {
        $request->validate([
            'work_performed' => 'required|string',
            'observations' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'parts_used' => 'nullable|array',
            'next_maintenance_suggested' => 'nullable|date|after:today'
        ]);

        $maintenance->update([
            'completed_date' => now(),  // ✅ CORREGIDO: solo usar fechas
            'work_performed' => $request->work_performed,
            'observations' => $request->observations,
            'cost' => $request->cost,
            'parts_used' => $request->parts_used,
            'next_maintenance_suggested' => $request->next_maintenance_suggested
        ]);

        // Verificar si hay otros mantenimientos pendientes para este equipo
        $hasPendingMaintenance = $maintenance->equipment->maintenances()
            ->where('id', '!=', $maintenance->id)
            ->whereNull('completed_date')  // ✅ CORREGIDO: usar fechas
            ->exists();

        // Si no hay otros mantenimientos pendientes, cambiar equipo a activo
        if (!$hasPendingMaintenance) {
            $maintenance->equipment->update(['status' => 'active']);
        }

        // Actualizar cache del equipment
        $maintenance->equipment->updateMaintenanceCache();

        return back()->with('success', 'Mantenimiento completado exitosamente.');
    }

    public function cancel(Maintenance $maintenance): RedirectResponse
    {
        // ✅ CORREGIDO: verificar usando fechas
        if ($maintenance->completed_date) {
            return back()->with('error', 'No se puede cancelar un mantenimiento completado.');
        }

        // Marcar como cancelado usando una fecha especial o eliminarlo
        // Opción 1: Eliminarlo directamente
        $equipment = $maintenance->equipment;
        $maintenance->delete();

        // Verificar si hay otros mantenimientos pendientes para este equipo
        $hasPendingMaintenance = $equipment->maintenances()
            ->whereNull('completed_date')  // ✅ CORREGIDO: usar fechas
            ->exists();

        // Si no hay otros mantenimientos pendientes, cambiar equipo a activo
        if (!$hasPendingMaintenance) {
            $equipment->update(['status' => 'active']);
        }

        return back()->with('success', 'Mantenimiento cancelado.');
    }

    // Dashboard de mantenimientos
    public function dashboard(): View
    {
        $stats = [
            'overdue' => Maintenance::overdue()->count(),
            'due_this_week' => Maintenance::pending()
                ->whereBetween('scheduled_date', [now(), now()->addWeek()])
                ->count(),
            'in_progress' => Maintenance::where('status', 'en_proceso')->count(),
            'completed_this_month' => Maintenance::completed()
                ->whereMonth('completed_date', now()->month)
                ->count()
        ];

        $upcomingMaintenances = Maintenance::with(['equipment.equipmentType'])
            ->pending()
            ->orderBy('scheduled_date')
            ->limit(5)
            ->get();

        $overdueMaintenances = Maintenance::with(['equipment.equipmentType'])
            ->overdue()
            ->orderBy('scheduled_date')
            ->limit(5)
            ->get();

        return view('maintenances.dashboard', compact('stats', 'upcomingMaintenances', 'overdueMaintenances'));
    }
}
