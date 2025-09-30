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
        // Configuración para mejor presentación visual
//        $this->setDefaultSort('inspection_date', 'desc');

        $this->setPerPageAccepted([5, 10, 15, -1]);
        $this->resetPage();
        $this->setPerPage(5);

    }

    public function columns(): array
    {
        return [
            Column::make('id', 'id')->hideIf(true),

            Column::make("Cod Equipo", "equipment.code")->sortable()
                ->searchable(),

            Column::make("Fecha", "scheduled_date")
                ->format(fn($value) => \Carbon\Carbon::parse($value)->format('d-m-Y'))
                ->sortable(),
            Column::make("Título", "title")
                ->sortable(),
            Column::make("Tip de Mantenimiento", "type")
                ->sortable(),

            Column::make("Detalle", "description")->sortable()
                ->searchable(),
            Column::make("T. Requerido", "duration_hours")->sortable()
                ->searchable(),
            // Información del usuario responsable
            Column::make("Inspector", "user.name")->sortable()
                ->searchable(),
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
