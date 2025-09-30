<?php

namespace App\Livewire;

use App\Exports\InspectionExport;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Exceptions\DataTableConfigurationException;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Inspection;

use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class InspectionTable extends DataTableComponent
{

    protected $model = Inspection::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        // Configuración para mejor presentación visual
        $this->setDefaultSort('inspection_date', 'desc');

        $this->setPerPageAccepted([5, 10, 15, -1]);
        $this->resetPage();
        $this->setPerPage(5);

        $this->setBulkActions([
            'deleteSelected' => 'Borrar',
            'exportSelected' => 'Exportar'
        ]);
    }

    public function columns(): array
    {
        return [
            // ID oculto pero disponible para las rutas
            Column::make('id', 'id')->hideIf(true),

            Column::make("Cod Equipo", "equipment.code")
                ->sortable()
                ->searchable(),

            Column::make("Fecha y Hora", "inspection_date")
                ->format(fn($value) => \Carbon\Carbon::parse($value)->format('d-m-Y H:i'))
                ->sortable(),

            Column::make("Tipo de Equipo", "equipment.equipmentType.name")
                ->sortable()
                ->searchable(),

            Column::make("Marca", "equipment.brand")
                ->sortable()
                ->searchable(),

            Column::make("Modelo", "equipment.model")
                ->sortable()
                ->searchable(),

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

    public function deleteSelected()
    {


        if (\Gate::allows('admin-access')) {
            if ($this->getSelected()) {

                $this->emit('error','Estas seguro?');

                $inspections = Inspection::whereIn('id', $this->getSelected())->delete();
                $this->clearSelected();
                return redirect()
                    ->route('reportes')
                    ->with('success', 'Registros borrados correctamente.');
            }
        }

        $this->clearSelected();
        return redirect()
            ->route('reportes')
            ->with('fail', 'No tienes los permisos necesarios');
    }

    public function exportSelected()
    {
        if ($this->getSelected()) {

            $inspections = Inspection::whereIn('id', $this->getSelected())->get();
            return Excel::download(new InspectionExport($inspections), 'inspections.xlsx');

        }


    }

}
