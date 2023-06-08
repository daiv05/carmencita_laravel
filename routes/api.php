<?php

use App\Http\Controllers\CargoController;
use App\Http\Controllers\SexoController;
use App\Http\Controllers\EstadoFamiliarController;
use App\Http\Controllers\NacionalidadController;
use App\Http\Controllers\JornadaLaboralDiariaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UnidadDeMedidaController;
use App\Http\Controllers\PrecioUnidadDeMedidaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CreditoFiscalController;
use App\Http\Controllers\DetalleCreditoController;
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
Route::post('cargos',[CargoController::class,'store']);
Route::get('empleado/{empleado}',[EmpleadoController::class,'show']);
Route::put('empleado_update/{empleado}', [EmpleadoController::class, 'update']);
Route::put('empleado_activo/{empleado}',[EmpleadoController::class,'updateEstado']);

//Rutas para cargos
Route::resource('cargos',CargoController::class);

//Rutas para productos
Route::resource('productos',ProductoController::class);

//Rutas para unidades de medida
Route::resource('unidades_de_medida',UnidadDeMedidaController::class);

//Rutas para precios de unidades de medida
Route::resource('precios_unidades_de_medida',PrecioUnidadDeMedidaController::class);

//Rutas para jornadas laborales diarias
Route::resource('jornadas_laborales_diarias',JornadaLaboralDiariaController::class);

//Rutas para cargos
Route::resource('cargos',CargoController::class);


// ------------------------ RUTAS DAVID ------------------------
//Rutas para Cliente
Route::resource('clientes',ClienteController::class);

//Rutas para DetalleVenta
Route::resource('detalle_ventas',DetalleVentaController::class);

//Rutas para Venta
Route::resource('ventas',VentaController::class);

//Rutas para CreditoFiscal
Route::resource('credito_fiscals',CreditoFiscalController::class);

//Rutas para DetalleCreditoFiscal
Route::resource('detalle_creditos',DetalleCreditoController::class);

//Ruta para buscar Producto por Nombre
Route::get('productos/buscar/{nombre_producto}',[ProductoController::class,'getProductoPorNombre']);

//Ruta para obtener todos los nombres de los productos
Route::get('productos/nombres/lista',[ProductoController::class,'getNombresProductos']);


