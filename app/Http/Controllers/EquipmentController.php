<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\EquipmentType;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipment = Equipment::latest()->with('equipmentType')->paginate(6);

        return view('equipment.index', [
            'equipment' => $equipment
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentRequest $request)
    {
        // Crear el equipo con los datos validados
        $equipment = Equipment::create($request->validated());

        // Redireccionar con mensaje de éxito
        return redirect()->route('equipment.index')->with('success', 'Equipo creado exitosamente');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $eTypes = EquipmentType::all();

        //  Retornar la vista, no los datos directamente
        return view('equipment.create', [
            'eTypes' => $eTypes
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
//       dd($equipment);
        return view('equipment.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        $eTypes = EquipmentType::all();

        return view('equipment.edit', [
            'equipment' => $equipment,
            'eTypes' => $eTypes
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        try {
            // Actualizar con datos validados
            $equipment->update($request->validated());

            // Redireccionar con mensaje de éxito
            return redirect()
                ->route('equipment.show', $equipment)
                ->with('success', 'Equipo actualizado exitosamente');

        } catch (\Exception $e) {
            // En caso de error, redirigir de vuelta con el error
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el equipo: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
//        return 'ok, lo hago';
        $equipment->delete();

        return redirect()->route('equipment.index')->with('success', 'Equipo eliminado exitosamente');
    }
}
