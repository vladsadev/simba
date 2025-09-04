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


        return view();
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

        $maintenance = Maintenance::create([
            ...$validated,
            'user_id' => auth()->id()
        ]);

        // ✅ ACTUALIZAR EL STATUS DEL EQUIPMENT A "maintenance"
        $maintenance->equipment->update(['status' => 'mantenimiento']);

        return redirect()
            ->route('maintenances.show', $maintenance)
            ->with('success', 'Mantenimiento programado exitosamente. El equipo ha sido marcado como "En Mantenimiento".');
    }

    public function edit(Maintenance $maintenance): View
    {
    }

    public function update(UpdateMaintenanceRequest $request, Maintenance $maintenance)
    {

    }

    public function destroy(Maintenance $maintenance): RedirectResponse
    {

        return redirect()
            ->route('maintenances.index')
            ->with('success', 'Mantenimiento eliminado exitosamente.');
    }


}
