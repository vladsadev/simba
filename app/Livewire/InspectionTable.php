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

        // Configuración de la tabla para mejor presentación
        $this->setDefaultSort('id', 'desc');
        $this->setTableClass('min-w-full divide-y divide-gray-200');
        $this->setTheadClass('bg-gray-50');
        $this->setThClass('px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider');
        $this->setTdClass('px-6 py-4 whitespace-nowrap text-sm text-gray-900');
    }

    public function columns(): array
    {
        return [
            // ID oculto pero disponible para las rutas
            Column::make('id', 'id')->hideIf(true),

            Column::make("Cod Equipo", "equipment.code")
                ->sortable()
                ->searchable()
                ->collapseOnMobile()
                // Ancho específico para esta columna
                ->thClass('w-1/6 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider')
                ->tdClass('w-1/6 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'),

            Column::make("Tipo de Equipo", "equipment.equipmentType.name")
                ->sortable()
                ->searchable()
                ->collapseOnMobile()
                ->thClass('w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider')
                ->tdClass('w-1/4 px-6 py-4 whitespace-nowrap text-sm text-gray-900'),

            Column::make("Marca", "equipment.brand")
                ->sortable()
                ->searchable()
                ->collapseOnMobile()
                ->thClass('w-1/6 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider')
                ->tdClass('w-1/6 px-6 py-4 whitespace-nowrap text-sm text-gray-900'),

            Column::make("Modelo", "equipment.model")
                ->sortable()
                ->searchable()
                ->collapseOnMobile()
                ->thClass('w-1/6 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider')
                ->tdClass('w-1/6 px-6 py-4 whitespace-nowrap text-sm text-gray-900'),

            // Columna de acciones con ancho fijo y centrada
            LinkColumn::make('Acciones')
                ->title(fn() => 'Ver Inspección')
                ->location(fn($row) => route('inspection.show', $row->id))
                ->attributes(fn ($row) => [
                    'class' => 'bg-yellow-main hover:bg-blue-main cursor-pointer px-4 py-2 text-sm font-semibold rounded-md text-white transition-colors duration-300 inline-flex items-center justify-center',
                ])
                // Clases específicas para la columna de acciones
                ->thClass('w-1/6 px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider')
                ->tdClass('w-1/6 px-6 py-4 whitespace-nowrap text-center text-sm font-medium'),
        ];
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Inspection::query()
            ->with([
                'equipment' => function ($query) {
                    $query->with('equipmentType');
                },
            ]);
    }
}
