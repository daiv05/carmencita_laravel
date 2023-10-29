<?php

use App\Http\Controllers\CargoController;
use App\Http\Controllers\HojaAsistenciaController;
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
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\CreditoFiscalDomicilioController;
use App\Models\Producto;
use App\Http\Controllers\DetalleCreditoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\ImpresionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\VentasCFController;
use App\Http\Controllers\PlanillaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\FechaController;
use App\Http\Controllers\InformeVentasController;
use App\Http\Controllers\InformeInventarioController;
use App\Http\Controllers\InformeProductosPorVencerController;
use App\Http\Controllers\CreditoController;
use App\Http\Controllers\PromocionesController;
use App\Http\Controllers\VentaDomicilioController;
use Illuminate\Console\View\Components\Info;
use App\Http\Controllers\AbonoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AvisoController;

use App\Http\Controllers\ProveedorController;


/* ----------------------------------------------*/
/* ----------------------------------------------*/
/* ------------------GERENCIA--------------------*/
/* Rutas a las que solo pueda acceder el gerente */
/* ----------------------------------------------*/
/* ----------------------------------------------*/

Route::middleware(['auth:sanctum', 'permission:adm-rh'])->group(function () {
    Route::get("empleados", [EmpleadoController::class, 'listaEmpleados']);
    Route::get('pacientes', [JornadaLaboralDiariaController::class, 'index']);
    Route::get('sexos', [SexoController::class, 'index']);
    Route::get('estado_familiar', [EstadoFamiliarController::class, 'index']);
    Route::get('nacionalidades', [NacionalidadController::class, 'index']);
    Route::post('empleado', [EmpleadoController::class, 'store']);
    Route::get('empleado/{empleado}', [EmpleadoController::class, 'show']);
    Route::put('empleado_update/{empleado}', [EmpleadoController::class, 'update']);
    Route::put('empleado_activo/{empleado}', [EmpleadoController::class, 'updateEstado']);
    //Rutas para Usuarios
    Route::resource('usuarios', UserController::class);
    Route::post('usuarios/{user}', [UserController::class, 'update']);
    //Rutas para cargos
    Route::resource('cargos', CargoController::class);
    Route::get('empleado/{empleado}', [EmpleadoController::class, 'show']);
    Route::get('asistencia/{id_empleado}', [AsistenciaController::class, 'getAsistenciasEmpleado']);
    Route::controller(PlanillaController::class)->group(function () {
        Route::post('planilla', 'store');
        Route::get('planillas','index');
        Route::get('filtroPlanillas','obtenerPlanillasOrdenadasPorFecha');
        Route::get('listaFechaPlanilla',"obtenerListaFechasPlanillas");
        Route::get('planilla/{id_planilla}','show');
        Route::get("obtener_detalles_planilla/{id:int}","obtenerDetallesPlanilla");
    });
    //Rutas para Municipio
    Route::resource('municipios', MunicipioController::class);
    //Rutas para Departamento
    Route::resource('departamentos', DepartamentoController::class);
    //Ruta para obtener el departamento segun el nombre
    Route::get('departamentos/buscar/{nombre_departamento}', [DepartamentoController::class, 'getDepartamentoPorNombre']);
    Route::get('pacientes', [JornadaLaboralDiariaController::class, 'index']);
    Route::get('get_municipios', [MunicipioController::class, 'municipios_segun_departamento']);
});

/* --------------------------------------------------*/
/* --------------------------------------------------*/
/* ------------------VENTAS E INVENTARIO---------------------*/
/* Rutas par las funciones de ventas e inventario*/
/* --------------------------------------------------*/
/* --------------------------------------------------*/
Route::middleware(["auth:sanctum","permission:adm-ventas"])->group(function(){
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
 //Rutas para Cliente
 Route::resource('clientes', ClienteController::class);
 Route::post('abono_registrar',[AbonoController::class,'store']);
 Route::get('credito_proveedor/{credito}',[CreditoController::class,'show']);
 Route::post('lista_creditos_proveedores',[CreditoController::class,'getCreditos']);
 //Route::post('usuarios/{user}', [UserController::class, 'destroy']);
 Route::post('clientes/cambiar_estado/{id}', [ClienteController::class, 'desactivar_cliente']);
   /*Endpoint para gestion de existencias.*/
   Route::resource("gestion_existencias", LoteController::class);
   /*Control de filtro de fechas para reportes de inventario */
   Route::get("/fechas_filtro", [FechaController::class, "obtenerFechasParaFiltro"]);
   //Para creditos proveedores
    Route::apiResource('creditosProveedores', CreditoController::class);
    //para obtene los proveedores
    Route::get('proveedores', [CreditoController::class, 'getProveedores']);
    Route::apiResource('proveedor', ProveedorController::class);
    Route::put('proveedor/cambiar_estado/{proveedor}', [ProveedorController::class, 'cambiar_estado_proveedor']);
});
/* --------------------------------------------------*/
/* --------------------------------------------------*/
/* ------------------FACTURACION---------------------*/
/* Rutas a las que puede acceder Cajero y superiores */
/* --------------------------------------------------*/
/* --------------------------------------------------*/

Route::middleware(["auth:sanctum", "permission:cajero"])->group(function () {
    Route::get('ventasCF', [VentasCFController::class, 'index']);
    //Rutas para productos
    Route::resource('productos', ProductoController::class);
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
    Route::put('creditos/updateEstado/{CFSales}', [VentasCFController::class, 'updateEstadoCredito']);
    //Hojas de ruta y pedidos a domicilio
    Route::controller(HojaDeRutaController::class)->group(function () {
        Route::get('/hoja_de_ruta', 'index');
        Route::get('/hoja_de_ruta/{id}', 'show');
        Route::post('/hoja_de_ruta', 'store');
        Route::post('/hoja_de_ruta/marcar_entregada/{id}', 'marcarEntregada');
        Route::put('hoja_de_ruta/{hojaDeRuta}','update');
    });
    Route::get('/hoja_de_ruta_paginadas', [HojaDeRutaController::class, 'obtenerHojasDeRutasPaginadasFiltro']);
    Route::post('/facturas_domicilio', [VentaController::class, 'getVentasDomicilio']);
    Route::post('/creditos_fiscales_domicilio', [CreditoFiscalController::class, 'getCreditosFiscalesDomicilio']);
    Route::post('/pedidos_domicilio', [VentaController::class, 'getPedidos']);
    Route::put('creditos/updateEstado/{CFSales}', [VentasCFController::class, 'updateEstadoCredito']);
    //Eliminar una hoja de ruta
    Route::delete('hojaruta_delete/{id_hr}', [HojaDeRutaController::class, 'deleteHojaRuta']);
    Route::put('modificar_pedido_factura/{venta}', [VentaController::class, 'update']);
    Route::put('modificar_pedido_credito/{creditoFiscal}', [CreditoFiscalController::class, 'update']);
    Route::post('delete_pedido/credito_fiscal/{creditoFiscal}', [CreditoFiscalController::class, 'destroy']);
    Route::post('delete_pedido/factura/{venta}', [VentaController::class, 'destroy']);
    Route::put('creditos/updateEstado/{CFSales}', [VentasCFController::class, 'updateEstadoCredito']);
    Route::controller(VentaDomicilioController::class)->group(function () {
        Route::get('/venta_domicilio', 'index');
        Route::get('/venta_domicilio/{id}', 'show');
        Route::get('/ventas/desvincular_hr/', 'desvincularHojaRuta');
        Route::post('/ventas/confirmar_pago/{venta_domicilio}', 'confirmar_pago_venta');
    });
    Route::controller(CreditoFiscalDomicilioController::class)->group(function () {
        Route::get('/credito_fiscal_domicilio', 'index');
        Route::get('/credito_fiscal_domicilio/{id}', 'show');
        Route::get('/creditos/desvincular_hr/', 'desvincularHojaRuta');
        Route::post('/creditos/confirmar_pago/{credito_domicilio}', 'confirmar_pago_credito');
    });
    //Impresion de facturas - creditos fiscales - hojas de ruta
    Route::get('/impresion_consumidor_final/{id}', [ImpresionController::class, 'generate_pdf_consumidor_final']);
    Route::get('/impresion_credito_fiscal/{id}', [ImpresionController::class, 'generate_pdf_credito_fiscal']);
    Route::get('/impresion_hoja_de_ruta/{id}', [ImpresionController::class, 'generate_pdf_hoja_de_ruta']);
});


/* ---------------------------------------------------------------*/
/* ---------------------------------------------------------------*/
/* --------------------------EMPLEADOS----------------------------*/
/* Todos los empleados tienen acceso, mientras estén autenticados */
/* ---------------------------------------------------------------*/
/* ---------------------------------------------------------------*/
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::post('asistencia', [AsistenciaController::class, 'store']);
    Route::get('asistencia', [AsistenciaController::class, 'getAsistenciasEmpleado']);
});


/* ---------------------------------------------------------*/
/* ---------------------------------------------------------*/
/* ------------------GERENCIA (INFORMES)--------------------*/
/* -----Rutas a las que solo pueda acceder el gerente------ */
/* ---------------------------------------------------------*/
/* ---------------------------------------------------------*/
Route::middleware(["auth:sanctum", "permission:adm-gerencia"])->group(function () {
    
    Route::resource("informe_inventario_valorado", InformeInventarioController::class);
    Route::get("datos_inventario_valorado", [InformeInventarioController::class, "obtenerDatosGraficoInventarioValorado"]);
    Route::get("filtro_datos_producto_valorado/{valorMinimo?}/{valorMaximo?}", [InformeInventarioController::class, "obtenerDatosFiltradosProductoPorPrecios"]);
    Route::get("ventas_por_producto", [InformeInventarioController::class, "obtenerVentasPorProductos"]);
    Route::get("productos_mas_vendidos/", [InformeInventarioController::class, "obtenerProductosMasVendidosConIngresos"]);
    Route::get("filtro_ventas_totales/", [InformeVentasController::class, "obtenerVentasTotalesPorFecha"]);
    Route::get("/filtro_ventas_totales/{parametros}", [InformeVentasController::class, "obtenerVentasTotalesPorFecha"]);
    Route::put("modificar_estado_aviso/{aviso}",[AvisoController::class,"modificarEstadoAviso"]);
    //Para obtener los productos que vencen en los proximos 15 dias
    Route::get('productosXVenecer', [InformeProductosPorVencerController::class, 'index']);
});


//Asistencia y Planillas
Route::controller(AsistenciaController::class)->group(function () {
    Route::post('hoja_asistencia', 'store');
});

/* ----------------------------------------------*/
/* ----------------------------------------------*/
/* ------------------NO AUTH---------------------*/
/* ----------------------------------------------*/
/* ----------------------------------------------*/
 Route::post("login", [LoginController::class, "authorization"]);
 //Ruta para descargar imagen
 Route::get("productos/{producto}/foto", function (Producto $producto) {
    return response()->download(public_path(Storage::url($producto->foto)), $producto->nombre_producto);
});
//Avisos para el blog
Route::get("avisos_blog", [AvisoController::class, "avisosBlog"]);
//Ofetas para el blog vigentes
Route::get("ofertas_blog", [PromocionesController::class, "promocionesVigentes"]);

/* ----------------------------------------------*/
/* ----------------------------------------------*/
/* ------------------Rutas a las que se puede acceder con el permiso de marketing---------------------*/
/* ----------------------------------------------*/
/* ----------------------------------------------*/
Route::middleware(["auth:sanctum", "permission:adm-marketing"])->group( function(){
    //Todas las ofertas
    Route::get("ofertasList", [PromocionesController::class, "ofertasList"]);
    //Eliminar una oferta
    Route::delete("ofertaDelete/{promocion}", [PromocionesController::class, "destroy"]);
    //Actualizar una oferta
    Route::put("ofertaUpdate/{promocion}", [PromocionesController::class, "update"]);
    //Para obetner una oferta especifica
    Route::get("oferta/{promocion}", [PromocionesController::class, "show"]);
    //Para obtene los productos para la promocion
    Route::get('productoProm', [PromocionesController::class, 'getProductos']);
    //para crear una promocion
    Route::apiResource('promociones', PromocionesController::class);
    //para la gestion de avisos
    Route::resource("avisos",AvisoController::class);
    });