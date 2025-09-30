<?php

namespace App\Exports;

use App\Models\Inspection;
use Maatwebsite\Excel\Concerns\FromCollection;

class InspectionExport implements FromCollection
{

    public $inspections;

    public function __construct($inspections)
    {
        $this->inspections = $inspections;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
//        return Inspection::all();
        return $this->inspections;
    }
}
