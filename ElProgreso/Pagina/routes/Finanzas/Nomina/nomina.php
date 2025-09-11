<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NominaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
|
*/

Route::apiResource('/nominas', NominaController::class, ['names' => 'nominas']);
Route::post('/nominas/validar-primer-paso', [NominaController::class, 'validarPrimerPasoNomina'])->name('nominas.validar-primer-paso');
Route::post('/nominas/validar-segundo-paso', [NominaController::class, 'validarSegundoPasoNomina'])->name('nominas.validar-segundo-paso');
Route::post('/nominas/validar-tercer-paso', [NominaController::class, 'validarTercerPasoNomina'])->name('nominas.validar-tercer-paso');
Route::post('/rutas/{ruta_id}/mes-nominas/{mes}/nominas', [NominaController::class, 'obtenerOCrearMes'])->name('mes-nominas.store');
Route::get('/mes-nominas/{id}/metas', [NominaController::class, 'obtenerMetas'])->name('mes-nomina.metas');
Route::post('/mes-nominas/{id}/meta-minima/{cantidad}', [NominaController::class, 'guardarMetaMaxima'])->name('mes-nomina.meta-maxima');
Route::post('/mes-nominas/{id}/meta-maxima/{cantidad}', [NominaController::class, 'guardarMetaMinima'])->name('mes-nomina.meta-minima');
Route::get('/nominas/{id}/imprimir', [NominaController::class, 'imprimirPdf'])->name('nominas.imprimir');
/*
|--------------------------------------------------------------------------
| View Routes
|--------------------------------------------------------------------------
|
*/
Route::view('/sistema/ruta-nomina', 'nominas.index')->name('rutas.nominas.view');

