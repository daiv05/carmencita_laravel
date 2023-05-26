<?php

use App\Http\Controllers\CargoController;
use App\Http\Controllers\JornadaLaboralDiariaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UnidadDeMedidaController;
use App\Http\Controllers\PrecioUnidadDeMedidaController;
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
Route::post('cargos',[CargoController::class,'store']);

//Rutas para productos
Route::get('productos',[ProductoController::class,'index']);
Route::get('productos/{codigo_barra_producto}',[ProductoController::class,'show']);
Route::post('productos',[ProductoController::class,'store']);
Route::put('productos/{codigo_barra_producto}',[ProductoController::class,'update']);
Route::delete('productos/{codigo_barra_producto}',[ProductoController::class,'destroy']);

//Rutas para unidades de medida
Route::get('unidades_de_medida',[UnidadDeMedidaController::class,'index']);
Route::get('unidades_de_medida/{id_unidad_de_medida}',[UnidadDeMedidaController::class,'show']);
Route::post('unidades_de_medida',[UnidadDeMedidaController::class,'store']);
Route::put('unidades_de_medida/{id_unidad_de_medida}',[UnidadDeMedidaController::class,'update']);
Route::delete('unidades_de_medida/{id_unidad_de_medida}',[UnidadDeMedidaController::class,'destroy']);

//Rutas para precios de unidades de medida
Route::get('precios_unidades_de_medida',[PrecioUnidadDeMedidaController::class,'index']);
Route::get('precios_unidades_de_medida/{id_precio_unidad_de_medida}',[PrecioUnidadDeMedidaController::class,'show']);
Route::post('precios_unidades_de_medida',[PrecioUnidadDeMedidaController::class,'store']);
Route::put('precios_unidades_de_medida/{id_precio_unidad_de_medida}',[PrecioUnidadDeMedidaController::class,'update']);
Route::delete('precios_unidades_de_medida/{id_precio_unidad_de_medida}',[PrecioUnidadDeMedidaController::class,'destroy']);

