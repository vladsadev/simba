<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Inspection;

class InspectionTable extends DataTableComponent
{
    protected $model = Inspection::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Cod Equipo", "equipment.code")->sortable()
                ->searchable(),

            Column::make("Tipo de Equipo", "equipment.equipmentType.name")
                ->sortable()
                ->searchable(),

            Column::make("Marca", "equipment.brand")->sortable()
                ->searchable(),
            Column::make("Modelo", "equipment.model")->sortable()
                ->searchable(),

//            Column::make("Inspection date", "inspection_date")->sortable(),

            Column::make("Status", "status")
                ->sortable(),

//            Column::make("Cuchara", "cuchara_checked")
//                ->sortable()
//                ->format(fn($value) => $value ? '✅' : '❌'),

//            BooleanColumn::make("Cuchara 2", "cuchara_checked")
//                ->sortable(),
        ];
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        // Incluir todas las relaciones necesarias para evitar N+1 queries
        return Inspection::query()
            ->with([
                'equipment' => function ($query) {
                    $query->with('equipmentType'); // Para mostrar el tipo de equipo
                    $query->with('equipment'); // Para mostrar el tipo de equipo
                },
//                'user' // Para mostrar el nombre del inspector
            ]);
    }


}
