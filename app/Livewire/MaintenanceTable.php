<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Maintenance;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

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
            Column::make('id', 'id')->hideIf(true),

            Column::make("Cod Equipo", "equipment.code")->sortable()
                ->searchable(),

//            Column::make("Tipo de Equipo", "equipment.equipmentType.name")
//                ->sortable()
//                ->searchable(),

//            Column::make("Marca", "equipment.brand")->sortable()
//                ->searchable(),
//
//            Column::make("Modelo", "equipment.model")->sortable()
//                ->searchable(),

            Column::make("Tip de Mantenimiento", "type")
                ->sortable(),

            // Información del usuario responsable
//            Column::make("Inspector", "user.name")->sortable()
//                ->searchable(),
            LinkColumn::make('Acciones')
                ->title(fn() => 'Ver Mantenimiento')
                ->location(fn($row) => route('maintenances.show', $row->id))
                ->attributes(fn($row) => [
                    'class' => 'bg-yellow-main hover:bg-blue-main cursor-pointer px-4 py-2.5 text-sm font-semibold rounded-md text-white transition-colors duration-300 inline-flex items-center justify-center',
                ]),

        ];
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Maintenance::query()
            ->with([
                'equipment.equipmentType',
                'user',
            ]);
    }
}
