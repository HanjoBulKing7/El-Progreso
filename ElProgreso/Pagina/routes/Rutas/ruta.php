<?php

use App\Http\Controllers\RutaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NominaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
|
*/

Route::apiResource('/users', NominaController::class, ['names' => 'users']);
Route::post('/ruta/{id}/nominass', [NominaController::class, 'guardarNomina'])->name('rutas.nominas.store');
Route::get('/ruta/{id}/nominas', [NominaController::class, 'indexNomina'])->name('rutas.nominas.index');
Route::put('/nomina/{id}', [NominaController::class, 'actualizarNomina'])->name('rutas.nominas.update');
Route::delete('/nomina/{id}', [NominaController::class, 'borrarNomina'])->name('rutas.nominas.destroy');
Route::get('/nomina/{id}', [NominaController::class, 'mostrarNomina'])->name('rutas.nominas.show');
Route::get('ruta/{ruta_id}/meses/{mes}', [RutaController::class, 'obtenerVentasMensuales'])->name('users.venta-mensual-total');

/*
|--------------------------------------------------------------------------
| View Routes
|--------------------------------------------------------------------------
|
*/
Route::view('/rutas/{id}/nominas', 'rutas.nominas.index')->name('rutas.nominas.view');
