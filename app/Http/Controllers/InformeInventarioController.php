<?php

namespace App\Http\Controllers;

use App\ClasesPersonalizadas\FiltroHistorialVentasProducto as ClasesPersonalizadasFiltroHistorialVentasProducto;
use Illuminate\Http\Request;
use App\Http\Resources\InformeInventarioResource;
use App\Models\Producto;
use App\Filtros\FiltroHistorialVentasProducto;
use Illuminate\Support\Facades\DB;
use App\Filtros\FiltroProductosMasVendidos;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;


class InformeInventarioController extends Controller
{
    public function index(){
        return InformeInventarioResource::collection(Producto::paginate(5));
    }
    
    public function obtenerDatosFiltradosProductoPorPrecios(Request $request,int $valorMinimo = 0,int $valorMaximo = 650){
        //$valorMinimo = $request->query("valorMinimo",0);
        //$valorMaximo = $request->query("valorMaximo",650);

        $resultados = Producto::whereRaw('cantidad_producto_disponible * precio_unitario > ?',[$valorMinimo])
        ->whereRaw('cantidad_producto_disponible * precio_unitario < ?',[$valorMaximo])
        ->paginate(5);

        return InformeInventarioResource::collection($resultados);
        
    }

    public function obtenerDatosGraficoInventarioValorado(){
        $data = array();
        $categories = array();
        $productos = Producto::selectRaw('nombre_producto, (cantidad_producto_disponible * precio_unitario) as valor_monetario')
        ->orderByDesc('valor_monetario')
        ->limit(10)
        ->get();

        foreach($productos as $producto){
             $data[] = $producto["valor_monetario"];
             $categories[] = $producto["nombre_producto"];
        }
        
        return response()->json([
            "data"=>$data,
            "categories"=>$categories,
        ]);
    }

    public function obtenerVentasPorProductos(Request $request, string $fechaInicioVenta = '1990-01-01', 
    string $fechaFinVenta = '2050-12-31', float $minTotal = 0.00, float $maxTotal = 999999999.99, 
    int $minTotalProducto = 0, int $maxTotalProducto = 9999999999)
    {

        $managerFiltros = new FiltroHistorialVentasProducto(10);
        if($fechaInicioVenta!='1990-01-01'&&$fechaFinVenta!='2050-12-31' && floatval($minTotal)!=0.00 && floatval($maxTotal) != 999999999.99 && intval($minTotalProducto)!=0 && intval($maxTotalProducto)!=9999999999){

        }
        else if(intval($minTotalProducto)!=0 && intval($maxTotalProducto)!=9999999999){
            return $managerFiltros->filtrarPorMinimioYMaximoCantidadProducto($minTotalProducto,$maxTotalProducto);
        }
        else if(intval($minTotalProducto)!=0){
            return $managerFiltros->filtrarPorMinimoCantidadProducto($minTotalProducto);
        }
        else if(intval($maxTotalProducto) != 9999999999){
            return $managerFiltros->filtrarPorMaximoCantidadProducto($maxTotalProducto);
        }
        else if(floatval($maxTotal) != 999999999.99 && floatval($minTotal) != 0.00){
            return $managerFiltros->filtrarPorMinimoYMaximoIngresoProducto($minTotal,$maxTotal);
        }
        else if(floatval($maxTotal) != 999999999.99){
            return $managerFiltros->filtrarPorMaximoIngresoProducto($maxTotal);
        }
        else if(floatval($minTotal)!=0.00){
          return  $managerFiltros->filtrarPorMinimoIngresoProducto($minTotal);
        }
        else if($fechaInicioVenta!='1990-01-01' && $fechaFinVenta!='2050-12-31'){
            return $managerFiltros->filtrarPorFechaIncioYFechaFin($fechaInicioVenta,$fechaFinVenta);
        }
        else if($fechaFinVenta!='2050-12-31'){
            return $managerFiltros->filtrarPorFechaFin($fechaFinVenta);
        }
        else if($fechaInicioVenta!= '1990-01-01'){
            return $managerFiltros->filtrarPorFechaInicio($fechaInicioVenta);
        }

        return Producto::obtenerProductosConTotales($fechaInicioVenta,$fechaFinVenta
                                                    ,$minTotal,$maxTotal,$minTotalProducto,$maxTotalProducto);
    }

    public function destroy(){
        return "";
    }   
    public function store(){
        return "";
    }
    public function update(){
        return "";
    }

    public function obtenerProductosMasVendidosConIngresos(Request $request)
    {
        $parametros = request()->all();
        
        $managerFiltros = new FiltroProductosMasVendidos(10);
        
        try {

            if (isset($parametros['fechaInicio']) && isset($parametros['fechaFin'])){
                return $managerFiltros->filtrarPorFechaInicioYFechaFin($parametros['fechaInicio'], $parametros['fechaFin'], $parametros['tipoOrden']);
            }
            else if (isset($parametros['fechaInicio']))
            {
                return $managerFiltros->filtrarPorFechaInicio($parametros['fechaInicio'], $parametros['tipoOrden']);
            }
            else if (isset($parametros['fechaFin']))
            {
                return $managerFiltros->filtrarPorFechaFin($parametros['fechaFin'], $parametros['tipoOrden']);
            }
            else
            {
                return $managerFiltros->obtenerProductosPorOrden($parametros['tipoOrden']);
            }
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "mensaje" => $e->getMessage(),
            ], 500);
        } catch (QueryException $e) {
            return response()->json([
                "status" => false,
                "mensaje" => $e->getMessage()
            ], 500);
        }


    }
}
