<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInspectionRequest;
use App\Models\Equipment;
use App\Models\Inspection;
use App\Http\Requests\UpdateInspectionRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('inspection.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Equipment $equipment)
    {

        return view('inspection.create', [
            'equipment' => $equipment,
            'user' => Auth::user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInspectionRequest $request)
    {

        dump($request);
        try {
            if ($request->expectsJson()) {

                // Procesar los datos
                $inspection = Inspection::create([
                    'equipment_id' => $request->equipment_id,
                    'user_id' => Auth::id(),
                    'inspection_date' => Carbon::now(),
                    'status' => 'completada',
                    'observations' => $request->observations ?? null,
                ]);

                // Procesar issues reportados si existen
                if ($request->has('reported_issues')) {
                    $issues = json_decode($request->reported_issues, true);
                    foreach ($issues as $issue) {
                         $inspection->issues()->create($issue);
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Inspección guardada exitosamente',
                    'redirect' => route('equipment.show', $request->equipment_id)
                ]);
            }


        } catch (\Exception $e) {
            \Log::error('Error en inspección: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al guardar la inspección: ' . $e->getMessage()
                ], 422);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear la inspección: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Inspection $inspection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inspection $inspection)
    {
        //
    }
}
