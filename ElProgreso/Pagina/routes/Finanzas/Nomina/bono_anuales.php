<?php

use App\Http\Controllers\BonoAnualController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
|
*/

Route::post('/bono-anuales/{year}', [BonoAnualController::class, 'guardarBonoAnual'])->name('bono-anuales.store');
Route::get('/bono-anuales/{year}', [BonoAnualController::class, 'obtenerBonoAnual'])->name('bono-anuales.show');
