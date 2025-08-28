<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Maintenance;

class MaintenanceTable extends DataTableComponent
{
    protected $model = Maintenance::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            // En lugar de mostrar solo el ID, mostrar información del equipo
            Column::make("Cod Equipo", "equipment.code")->sortable()
                ->searchable(),

            Column::make("Tipo de Equipo", "equipment.equipmentType.name")
                ->sortable()
                ->searchable(),

//            Column::make("Marca", "equipment.brand")->sortable()
//                ->searchable(),
//
//            Column::make("Modelo", "equipment.model")->sortable()
//                ->searchable(),

            Column::make("Mantenimiento", "type")
                ->sortable(),

            // Información del usuario responsable
//            Column::make("Inspector", "user.name")->sortable()
//                ->searchable(),


            // Mostrar el status calculado
//            Column::make("Status", "status")
//                ->sortable(),

            Column::make("Título", "title")
                ->sortable()
                ->searchable(),

//            Column::make("Descripción", "description")
//                ->sortable()
//                ->searchable(),

//            Column::make("Observaciones", "observations")
//                ->sortable()
//                ->searchable(),

            // Agregar fechas importantes
//            Column::make("Fecha Programada", "scheduled_date")
//                ->sortable(),
        ];
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Maintenance::query()
            ->with([
                'equipment' => function ($query) {
                    $query->with('equipmentType'); // ✅ Correcto: carga el tipo de equipo
                    // ❌ REMOVIDO: $query->with('equipment'); - Esta línea causaba el error
                },
                'user' // ✅ Agregar relación con usuario
            ]);
    }
}
