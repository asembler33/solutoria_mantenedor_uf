<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndicadoresUf;
use App\Http\Controllers\GraficoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mantenedor-uf', function () {
    return view('mantenedor_uf');
});

Route::controller(IndicadoresUf::class)->group(function (){
    Route::get('/obtenerDataIndicadores', 'index');
    Route::post('/grabarIndicador', 'store');
    Route::put('/actualizarIndicador/{id}', 'update');
    Route::delete('/eliminarIndicador/{id}', 'destroy');
});

Route::controller(GraficoController::class)->group(function (){
    Route::get('/graficoIndicadores', 'index');
    Route::post('/verDatos', 'getAllIndicadores');
});