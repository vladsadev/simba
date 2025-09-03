<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Inspection;

//use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class InspectionTable extends DataTableComponent
{
    protected $model = Inspection::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        // Configuración para mejor presentación visual
        $this->setDefaultSort('inspection_date', 'desc');

    }

    public function columns(): array
    {
        return [
            // ID oculto pero disponible para las rutas
            Column::make('id', 'id')->hideIf(true),

            Column::make("Cod Equipo", "equipment.code")
                ->sortable()
                ->searchable(),

            Column::make("Tipo de Equipo", "equipment.equipmentType.name")
                ->sortable()
                ->searchable(),

            Column::make("Marca", "equipment.brand")
                ->sortable()
                ->searchable(),

            Column::make("Modelo", "equipment.model")
                ->sortable()
                ->searchable(),
            Column::make('Fecha', "inspection_date")
                ->sortable(),

            // Columna de acciones con botón estilizado
            LinkColumn::make('Acciones')
                ->title(fn() => 'Ver Inspección')
                ->location(fn($row) => route('inspection.show', $row->id))
                ->attributes(fn($row) => [
                    'class' => 'bg-yellow-main hover:bg-blue-main cursor-pointer px-4 py-2 text-sm font-semibold rounded-md text-white transition-colors duration-300 inline-flex items-center justify-center',
                ]),
        ];
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Inspection::query()
            ->with([
                'equipment.equipmentType',
                'user',
            ]);
    }
}
