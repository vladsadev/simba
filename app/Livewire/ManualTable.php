<?php

namespace App\Livewire;

use Carbon\Carbon;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Manual;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class ManualTable extends DataTableComponent
{
    protected $model = Manual::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setPerPageAccepted([10, 15, -1]);
        $this->resetPage();
        $this->setPerPage(10);
        $this->setBulkActions([
            'deleteSelected' => 'Borrar',
        ]);


    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->hideIf(true)
                ->sortable()
                ->searchable(),

            Column::make("Agregado", "published_date")
                ->format(fn($value) => Carbon::parse($value)->format('d-m-Y'))
                ->sortable()
                ->searchable(), // Agregar searchable aquí también
            Column::make("Equipo", "equipment_type")
                ->sortable()
                ->searchable(),
            Column::make("Modelo", "model")
                ->sortable()
                ->searchable(),
            Column::make("Manual de", "manual_type")
                ->sortable()
                ->searchable(),
            Column::make("Version", "version")
                ->sortable()
                ->searchable(),

            Column::make("Nombre Del archivo", "original_filename")
                ->sortable()
                ->searchable(),


            ButtonGroupColumn::make('Acciones')
                ->buttons([
                    LinkColumn::make('Acciones')
                        ->title(fn() => 'Ver Manual')
                        ->location(fn($row) => route('manual.show', $row->id))
                        ->attributes(fn($row) => [
                            'class' => 'bg-yellow-main hover:bg-blue-main cursor-pointer px-4 py-2 text-sm font-semibold rounded-md text-white transition-colors duration-300 inline-flex items-center justify-center',
                        ]),
                // Aqui otro botón para llamar al método destroy del controlador


                ])->unclickable(),
        ];
    }

    public function deleteSelected()
    {
        // Solo pedimos confirmación
        $this->dispatch('confirmDelete', count($this->getSelected()));
    }

    public function deleteConfirmed()
    {
        if (\Gate::allows('admin-access')) {
            if ($this->getSelected()) {

            }
        }

        $this->clearSelected();
        session()->flash('fail', 'No tienes los permisos necesarios');
        $this->dispatch('$refresh');
    }


}
