<?php

use App\Http\Controllers\CargoController;
use App\Http\Controllers\HojaDeRutaController;
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
use App\Models\Producto;
use App\Http\Controllers\DetalleCreditoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\ImpresionController;
use App\Models\CreditoFiscal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\VentasCFController;
use App\Http\Controllers\LoginController;

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



/*Aquí solo registrar rutas a las que pueda acceder el gerente*/
Route::middleware(['auth:sanctum', 'permission:all'])->group(function () {
    Route::get("empleados", [EmpleadoController::class, 'listaEmpleados']);
    Route::get('pacientes', [JornadaLaboralDiariaController::class, 'index']);
    //Route::get('cargos',[CargoController::class,'index']);
    //Route::get('cargos/{id_cargo}',[CargoController::class,'show']);
    Route::get('sexos', [SexoController::class, 'index']);
    Route::get('estado_familiar', [EstadoFamiliarController::class, 'index']);
    Route::get('nacionalidades', [NacionalidadController::class, 'index']);
    Route::post('empleado', [EmpleadoController::class, 'store']);

    Route::get('empleado/{empleado}', [EmpleadoController::class, 'show']);

    Route::put('empleado_update/{empleado}', [EmpleadoController::class, 'update']);

    Route::put('empleado_activo/{empleado}', [EmpleadoController::class, 'updateEstado']);



    //Rutas para cargos
    Route::resource('cargos', CargoController::class);

    //Ruta para paginacion
    Route::get('productos/paginacion/{cantidad_productos}', [ProductoController::class, 'getPaginacionProductos']);

    //Ruta para actualizar estado de producto
    Route::put('productos/updateEstado/{producto}', [ProductoController::class, 'updateEstado']);

    //Rutas para unidades de medida
    Route::resource('unidades_de_medida', UnidadDeMedidaController::class);

    //Rutas para precios de unidades de medida
    Route::resource('precios_unidades_de_medida', PrecioUnidadDeMedidaController::class);
    Route::post('precios_lista_unidades_de_medida', [PrecioUnidadDeMedidaController::class, "storeList"]);
    Route::get('precios_lista_unidades_de_medida');
    Route::get('precio_lista_unidades/{codigo_de_barra}', [PrecioUnidadDeMedidaController::class, "obtenerListaPreciosPorCodigoDeBarra"]);
    Route::put('precio_lista_unidades/{codigo_de_barra}', [PrecioUnidadDeMedidaController::class, "updateList"]);
    //Rutas para jornadas laborales diarias
    Route::resource('jornadas_laborales_diarias', JornadaLaboralDiariaController::class);

    //Rutas para cargos
    Route::resource('cargos', CargoController::class);


    //Rutas para Cliente
    Route::resource('clientes', ClienteController::class);
});

Route::get('impresion_prueba', [ImpresionController::class, 'generatePDF']);

Route::get('pacientes',[JornadaLaboralDiariaController::class,'index']);

/*Aqui poner las rutas para el cajero */ 
Route::middleware(["auth:sanctum","permission:all|Ventas"])->group(function(){
    Route::get('ventasCF', [VentasCFController::class, 'index']);
    //Rutas para productos
    Route::resource('productos', ProductoController::class);
    //Route::put("productos/{producto}",[ProductoController::class,'update']);
    //Ruta para descargar imagen
    Route::get("productos/{producto}/foto", function (Producto $producto) {
        return response()->download(public_path(Storage::url($producto->foto)), $producto->nombre_producto);
    });
});

/*aqui poner las rutas para el sub gerente o del modulo perteneciente a recursos humanos */
Route::middleware(["auth:sanctum","permission:all|Inventario|Ventas"])->group(function(){

});

/*poner todas las rutas de recursos humanos*/
Route::middleware(["auth:sanctum","permission:all|Recursos Humanos"])->group(function(){

});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);
});

Route::post("login", [LoginController::class, "authorization"]);

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


//Route::post('cargos',[CargoController::class,'store']);


//Rutas para DetalleVenta
Route::resource('detalle_ventas', DetalleVentaController::class);

//Rutas para Venta
Route::resource('ventas', VentaController::class);

//Rutas para CreditoFiscal
Route::resource('credito_fiscals', CreditoFiscalController::class);

//Rutas para DetalleCreditoFiscal
Route::resource('detalle_creditos', DetalleCreditoController::class);

//Ruta para buscar Producto por Nombre
Route::get('productos/buscar/{nombre_producto}', [ProductoController::class, 'getProductoPorNombre']);

//Ruta para obtener todos los nombres de los productos

Route::get('productos/nombres/lista', [ProductoController::class, 'getNombresProductos']);

Route::get('productos/nombres/lista', [ProductoController::class, 'getNombresProductos']);

//Ruta para obtener las ventas y listarlas
Route::get('ventasCF', [VentasCFController::class, 'index']);
//Ruta para buscar una venta especifica
Route::post('ventasCF/buscar', [VentasCFController::class, 'buscarVentaCF']);
//Ruta para eliminar una venta especifica
Route::delete('ventasCF/{id_venta}', [VentasCFController::class, 'eliminarVentaCF']);
//Ruta para obtener una venta especifica y sus detalles
Route::get('ventasCF_detalle/{id_venta}', [VentasCFController::class, 'obtenerVentaAndDetalle']);
//Ruta para obtener un producto con sus precio de unidad de medida
Route::get('productos/precios/{nombre_producto}', [ProductoController::class, 'getProductoConUnidadMedida']);

//Ruta para obtener todos los identificadores de los clientes
Route::get('clientes/identificador/lista', [ClienteController::class, 'getListaClientesIdentificadores']);

//Rutas para Municipio
Route::resource('municipios', MunicipioController::class);

//Rutas para Departamento
Route::resource('departamentos', DepartamentoController::class);

//Ruta para obtener el departamento segun el nombre
Route::get('departamentos/buscar/{nombre_departamento}', [DepartamentoController::class, 'getDepartamentoPorNombre']);

Route::get('departamentos/buscar/{nombre_departamento}', [DepartamentoController::class, 'getDepartamentoPorNombre']);


//Ruta para registrar una Venta con DetalleVenta junto
Route::post('ventas/registrar', [VentaController::class, 'register_venta_detalle']);

//Ruta para registrar un Credito con DetalleCredito junto
Route::post('creditos/registrar', [CreditoFiscalController::class, 'register_credito_detalle']);

//Para obtener los creditos fiscales
Route::get('creditos', [VentasCFController::class, 'indexCF']);

//Para buscar un credito fiscal especifico	
Route::post('creditos/buscar', [VentasCFController::class, 'buscarCreditoF']);

//Ruta para obtene un credito fiscal especifico y sus detalles
Route::get('creditos_detalle/{id_credito}', [VentasCFController::class, 'obtenerCreditoAndDetalle']);

//Ruta para actualizar estado de una venta
Route::put('ventaCF/updateEstado/{ventaCF}', [VentasCFController::class, 'updateEstado']);

//Ruta para actualizar estado de credito fiscal
Route::put('creditos/updateEstado/{CFSales}',[VentasCFController::class,'updateEstadoCredito']);

//Hojas de ruta y pedidos a domicilio
Route::controller(HojaDeRutaController::class)->group(function () {
    Route::get('/hoja_de_ruta', 'index');
    Route::get('/hoja_de_ruta/{id}', 'show');
    Route::post('/hoja_de_ruta', 'store');
});

Route::post('/facturas_domicilio',[VentaController::class,'getVentasDomicilio']);
Route::post('/creditos_fiscales_domicilio',[CreditoFiscalController::class,'getCreditosFiscalesDomicilio']);
Route::post('/pedidos_domicilio',[VentaController::class,'getPedidos']);
Route::put('creditos/updateEstado/{CFSales}', [VentasCFController::class, 'updateEstadoCredito']);
