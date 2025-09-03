<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DrillingGridController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\InspectionIssueController;
use App\Http\Controllers\MaintenanceController;
use App\Models\Equipment;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/reportes', function () {
        return view('dashboard.reportes');
    })->name('reportes');


    //Equipos
    Route::get('/catalogo', [EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('/catalogo/crear', [EquipmentController::class, 'create'])->name('equipment.create');
    Route::get('/catalogo/{equipment}/edit', [EquipmentController::class, 'edit'])->name('equipment.edit');
    Route::get('/catalogo/{equipment}', [EquipmentController::class, 'show'])->name('equipment.show');

    Route::get('/catalogo/{equipment}/delete-confirm', [EquipmentController::class, 'confirmDelete'])->name('equipment.confirm-delete');

    Route::post('/catalogo', [EquipmentController::class, 'store'])->name('equipment.store');
    Route::patch('/catalog/{equipment}', [EquipmentController::class, 'update'])->name('equipment.update');
    Route::delete('/catalog/{equipment}', [EquipmentController::class, 'destroy'])->name('equipment.destroy');

    //Inspecciones
    Route::view('/inspecciones', 'dashboard.reportes');
    Route::get('/inspecciones/{inspection}', [InspectionController::class, 'show'])->name('inspection.show');
    Route::get('/inspecciones/crear/{equipment}', [InspectionController::class, 'create'])->name('inspection.create');

    // Inspecciones - Issues
//    Route::post('/api/inspection-issues/temporary', [InspectionIssueController::class, 'storeTemporary'])
//        ->name('inspection.issues.temporary');
    Route::post('/api/inspection-issues', [InspectionIssueController::class, 'store'])
        ->name('inspection.issues.store');

    // En el grupo de rutas autenticadas, reemplazar las rutas de malla por:

// Malla de Perforaciones
    Route::get('/malla', [DrillingGridController::class, 'index'])->name('malla');

    // PDF como imágenes usando ImageMagick (dentro del middleware group)
    Route::get('/malla/pdf/{id}/image/{page?}', [App\Http\Controllers\ImageMagickPdfController::class, 'viewAsImage'])
        ->name('malla.pdf.image');
    Route::get('/malla/pdf/{id}/pages', [App\Http\Controllers\ImageMagickPdfController::class, 'getPageCount'])
        ->name('malla.pdf.pages');


    //Mantenimiento
    Route::get('maintenances', [MaintenanceController::class, 'index'])->name('maintenances.index');
    Route::get('maintenances/create/{equipment}', [MaintenanceController::class, 'create'])->name('maintenances.create');
    Route::post('maintenances', [MaintenanceController::class, 'store'])->name('maintenances.store');
    Route::get('maintenances/{maintenance}', [MaintenanceController::class, 'show'])->name('maintenances.show');
    Route::get('maintenances/{maintenance}/edit', [MaintenanceController::class, 'edit'])->name('maintenances.edit');
    Route::patch('maintenances/{maintenance}', [MaintenanceController::class, 'update'])->name('maintenances.update');
    Route::delete('maintenances/{maintenance}', [MaintenanceController::class, 'destroy'])->name('maintenances.destroy');

// Rutas adicionales para cambios de estado
    Route::patch('maintenances/{maintenance}/start', [MaintenanceController::class, 'start'])->name('maintenances.start');
    Route::patch('maintenances/{maintenance}/complete', [MaintenanceController::class, 'complete'])->name('maintenances.complete');
    Route::patch('maintenances/{maintenance}/cancel', [MaintenanceController::class, 'cancel'])->name('maintenances.cancel');
});
