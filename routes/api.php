<?php

use App\Http\Controllers\CargoController;
use App\Http\Controllers\SexoController;
use App\Http\Controllers\EstadoFamiliarController;
use App\Http\Controllers\NacionalidadController;
use App\Http\Controllers\JornadaLaboralDiariaController;
use App\Http\Controllers\EmpleadoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('pacientes',[JornadaLaboralDiariaController::class,'index']);
Route::get('cargos',[CargoController::class,'index']);
Route::get('cargos/{id_cargo}',[CargoController::class,'show']);
Route::get('sexos',[SexoController::class,'index']);
Route::get('estado_familiar',[EstadoFamiliarController::class,'index']);
Route::get('nacionalidades',[NacionalidadController::class,'index']);
Route::post('empleado',[EmpleadoController::class,'store']);
