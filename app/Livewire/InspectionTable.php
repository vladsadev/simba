<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Inspection;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

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


            LinkColumn::make('Acciones')
                ->title(fn() => 'Ver Inspección')
                ->location(fn($row) => route('inspection.show', $row)),

        ];
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        // Incluir todas las relaciones necesarias para evitar N+1 queries
        return Inspection::query()
            ->with([
                'equipment' => function ($query) {
                    $query->with('equipment'); // Para mostrar el tipo de equipo
                    $query->with('equipmentType'); // Para mostrar el tipo de equipo
                },
            ]);
    }


}
