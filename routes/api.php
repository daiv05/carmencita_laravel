<?php

use App\Http\Controllers\CargoController;
use App\Http\Controllers\JornadaLaboralDiariaController;
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
Route::get('jornadas_laborales',[JornadaLaboralDiariaController::class,'index']);
Route::get('jornadas_laborales/{id_jornada_laboral}',[JornadaLaboralDiariaController::class,'show']);
Route::get('cargos',[CargoController::class,'index']);
Route::get('cargos/{id_cargo}',[CargoController::class,'show']);
Route::post('cargos',[CargoController::class,'store']);
Route::put('cargos/{id_cargo}',[CargoController::class,'update']);
Route::delete('cargos/{cargo}',[CargoController::class,'destroy']);
