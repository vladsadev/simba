<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener estadísticas generales
        $stats = $this->getDashboardStats();

        // Obtener detalles por tipo de máquina
        $equipmentTypeDetails = $this->getEquipmentTypeDetails();

        return view('dashboard.index', compact('stats', 'equipmentTypeDetails'));
    }

    /**
     * Obtiene las estadísticas principales del dashboard
     */
    private function getDashboardStats(): array
    {
        $totalEquipment = Equipment::count();

        return [
            'total_fleet' => $totalEquipment,
            'operational' => Equipment::where('status', 'active')->count(),
            'in_maintenance' => Equipment::where('status', 'maintenance')->count(),
            'out_of_service' => Equipment::whereIn('status', ['inactive', 'retired'])->count(),
        ];
    }

    /**
     * Obtiene los detalles agrupados por tipo de equipo
     */
    private function getEquipmentTypeDetails(): array
    {
        $equipmentTypes = EquipmentType::with(['equipment' => function ($query) {
            $query->with(['inspections' => function ($inspectionQuery) {
                $inspectionQuery->latest('inspection_date');
            }]);
        }])->get();

        $details = [];

        foreach ($equipmentTypes as $type) {
            $equipment = $type->equipment;
            $totalEquipment = $equipment->count();

            if ($totalEquipment > 0) {
                // Contadores por estado
                $operational = $equipment->where('status', 'active')->count();
                $maintenance = $equipment->where('status', 'maintenance')->count();
                $outOfService = $equipment->whereIn('status', ['inactive', 'retired'])->count();

                // Calcular última inspección más reciente del tipo
                $latestInspection = null;
                $oldestInspectionHours = null;

                foreach ($equipment as $eq) {
                    $lastInspection = $eq->inspections->first();
                    if ($lastInspection) {
                        if (!$latestInspection || $lastInspection->inspection_date > $latestInspection) {
                            $latestInspection = $lastInspection->inspection_date;
                        }
                    }
                }

                // Calcular horas desde la última inspección
                if ($latestInspection) {
                    $oldestInspectionHours = Carbon::parse($latestInspection)->diffInHours(now());
                }

                $details[] = [
                    'type_name' => $type->name,
                    'type_id' => $type->id,
                    'total_equipment' => $totalEquipment,
                    'operational' => $operational,
                    'maintenance' => $maintenance,
                    'out_of_service' => $outOfService,
                    'last_inspection_hours_ago' => $oldestInspectionHours,
                    'icon_class' => $this->getEquipmentTypeIcon($type->name),
                    'gradient_class' => $this->getEquipmentTypeGradient($type->name),
                ];
            }
        }

        return $details;
    }

    /**
     * Asigna íconos basados en el tipo de equipo
     */
    private function getEquipmentTypeIcon(string $typeName): string
    {
        $iconMap = [
            'Perforadoras' => 'fa-drill',
            'De Acarreo' => 'fa-truck-moving',
            'Excavadoras' => 'fa-excavator',
            'Cargadoras' => 'fa-truck-loading',
            'Compactadoras' => 'fa-road',
            'Grúas' => 'fa-crane',
        ];

        // Buscar coincidencia parcial en el nombre del tipo
        foreach ($iconMap as $keyword => $icon) {
            if (stripos($typeName, $keyword) !== false) {
                return $icon;
            }
        }

        // Ícono por defecto
        return 'fa-cog';
    }

    /**
     * API endpoint para obtener estadísticas en tiempo real (opcional)
     */
    public function getStats(Request $request)
    {
        return response()->json([
            'stats' => $this->getDashboardStats(),
            'equipment_types' => $this->getEquipmentTypeDetails(),
            'updated_at' => now()->toISOString(),
        ]);
    }

    /**
     * Obtener equipos que requieren mantenimiento próximo
     */
    public function getUpcomingMaintenance()
    {
        $upcomingMaintenance = Equipment::with('equipmentType')
            ->whereNotNull('next_maintenance')
            ->where('next_maintenance', '<=', now()->addDays(30))
            ->orderBy('next_maintenance', 'asc')
            ->get();

        return response()->json($upcomingMaintenance);
    }

    /**
     * Obtener equipos sin inspección reciente
     */
    public function getEquipmentNeedingInspection()
    {
        $equipmentNeedingInspection = Equipment::with(['equipmentType', 'inspections' => function ($query) {
            $query->latest('inspection_date')->limit(1);
        }])
            ->get()
            ->filter(function ($equipment) {
                $lastInspection = $equipment->inspections->first();

                if (!$lastInspection) {
                    return true; // Sin inspecciones
                }

                // Más de 7 días sin inspección
                return Carbon::parse($lastInspection->inspection_date)->addDays(7) < now();
            })
            ->values();

        return response()->json($equipmentNeedingInspection);
    }
}
