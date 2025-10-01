<?php

namespace App\Exports;

use App\Models\Inspection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InspectionExport implements FromCollection, WithHeadings
{
    protected $inspections;

    public function __construct($inspections)
    {
        $this->inspections = $inspections;
    }

    public function collection()
    {
        return $this->inspections->map(function ($inspection) {
            return [
                $inspection->id,
                $inspection->inspection_date,
                $inspection->status,
                $inspection->created_at,
                $inspection->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha de Inspección',
            'Estado',
            'Creado en',
            'Actualizado en',
        ];
    }
}
