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

        // Configuración para mejor presentación visual
        $this->setDefaultSort('id', 'desc');

        // Estilos globales de la tabla
        $this->setTableClass('min-w-full divide-y divide-gray-200');
        $this->setTheadClass('bg-gray-50');
        $this->setTrClass('hover:bg-gray-50');
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
                // Ancho específico y alineación
                ->thClass('w-1/5 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider')
                ->tdClass('w-1/5 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'),

            Column::make("Tipo de Equipo", "equipment.equipmentType.name")
                ->sortable()
                ->searchable()
                ->collapseOnMobile()
                ->thClass('w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider')
                ->tdClass('w-1/4 px-6 py-4 text-sm text-gray-900'),

            Column::make("Marca", "equipment.brand")
                ->sortable()
                ->searchable()
                ->collapseOnMobile()
                ->thClass('w-1/5 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider')
                ->tdClass('w-1/5 px-6 py-4 text-sm text-gray-900'),

            Column::make("Modelo", "equipment.model")
                ->sortable()
                ->searchable()
                ->collapseOnMobile()
                ->thClass('w-1/5 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider')
                ->tdClass('w-1/5 px-6 py-4 text-sm text-gray-900'),

            // Columna de acciones - centrada y con ancho fijo
            LinkColumn::make('Acciones')
                ->title(fn() => 'Ver Inspección')
                ->location(fn($row) => route('inspection.show', $row->id))
                ->attributes(fn ($row) => [
                    'class' => 'bg-yellow-main hover:bg-blue-main cursor-pointer px-4 py-2 text-sm font-semibold rounded-md text-white transition-colors duration-300 inline-flex items-center justify-center',
                ])
                // Centrado y ancho fijo para acciones
                ->thClass('w-1/6 px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider')
                ->tdClass('w-1/6 px-6 py-4 text-center'),
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
