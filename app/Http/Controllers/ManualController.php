<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManualRequest;
use App\Models\Manual;
use Illuminate\Http\Request;

class ManualController extends Controller
{
    //
    public function index()
    {
        return view('manuals.index');
    }

    public function create()
    {
        $equipments = [
            [
                'type' => 'De acarreo',
                'models' => ['ST7', 'ST2G', 'MT2010 ', 'MT2200'],
                'description' => ['partes', 'diagrama', 'seguridad', 'operación', 'mantenimiento']
            ],
            [
                'type' => 'Perforación',
                'models' => ['SIMBA S7 D', 'BOOMER S1 D', 'BOOMER T1 D'],
                'description' => ['partes', 'diagrama', 'seguridad', 'operación', 'mantenimiento']
            ],
        ];


        return view('manuals.create', compact('equipments'));
    }

    public function store(StoreManualRequest $request)
    {

        dd($request->all());

    }
}
