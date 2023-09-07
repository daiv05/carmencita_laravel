<?php

namespace App\Http\Controllers;

use App\ClasesPersonalizadas\FiltroHistorialVentasProducto as ClasesPersonalizadasFiltroHistorialVentasProducto;
use Illuminate\Http\Request;
use App\Http\Resources\InformeInventarioResource;
use App\Models\Producto;
use App\Filtros\FiltroHistorialVentasProducto;
use Illuminate\Database\Eloquent\Casts\Json;

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
    

    public function existenMasParametrosDeConsulta($parametrosFiltro){
        if((isset($parametrosFiltro["minTotal"])) ||(isset($parametrosFiltro["maxTotal"])) || (isset($parametrosFiltro["minTotalProducto"])) || (isset($parametrosFiltro["maxTotalProducto"]))){
            return true;
        }
        return false;
    }

    public function obtenerVentasPorProductos(Request $request)
    {
        $parametrosFiltro = $request->all();
        $managerFiltros = new FiltroHistorialVentasProducto(10);
       if(isset($parametrosFiltro["fechaInicioVenta"]) && isset($parametrosFiltro["fechaFinVenta"])){
            //$parametrosFiltro["fechaInicioVenta"] = date("Y-m-d",strtotime($parametrosFiltro["fechaInicioVenta"]));
            return $managerFiltros->filtrarPorFechas($parametrosFiltro["fechaInicioVenta"],$parametrosFiltro["fechaFinVenta"]);
        }
        else if(isset($parametrosFiltro["fechaInicioVenta"])){
            //$parametrosFiltro["fechaFinVenta"] = date("Y-m-d",strtotime($parametrosFiltro["fechaFinVenta"]));
            return $managerFiltros->filtrarPorFechaInicio(
                $parametrosFiltro["fechaInicioVenta"]
            );
        }
        else if(isset($parametrosFiltro["fechaFinVenta"])){
            return $managerFiltros->filtrarPorFechaFin(
                $parametrosFiltro["fechaFinVenta"]
            );
        }
        else if((!isset($parametrosFiltro["fechaInicioVenta"]) && !isset($parametrosFiltro["fechaFinVenta"])) && $this->existenMasParametrosDeConsulta($parametrosFiltro) ){
            return $managerFiltros->filtrarPorValorVentasCantidades(
                isset($parametrosFiltro["minTotal"]) ? $parametrosFiltro["minTotal"] : null,
                isset($parametrosFiltro["maxTotal"]) ? $parametrosFiltro["maxTotal"] : null,
                isset($parametrosFiltro["minTotalProducto"]) ? $parametrosFiltro["minTotalProducto"] : null,
                isset($parametrosFiltro["maxTotalProducto"]) ? $parametrosFiltro["maxTotalProducto"] : null
            );
        }
        else if(isset($parametrosFiltro["fechaInicioVenta"]) && isset($parametrosFiltro["fechaFinVenta"])){
            $resultado = $managerFiltros->filtroFechasValorVentasCantidades(
                $parametrosFiltro["fechaInicioVenta"],
                $parametrosFiltro["fechaFinVenta"],
                isset($parametrosFiltro["minTotal"]) ? $parametrosFiltro["minTotal"] : null,
                isset($parametrosFiltro["maxTotal"]) ? $parametrosFiltro["maxTotal"] : null,
                isset($parametrosFiltro["minTotalProducto"]) ? $parametrosFiltro["minTotalProducto"] : null,
                isset($parametrosFiltro["maxTotalProducto"]) ? $parametrosFiltro["maxTotalProducto"] : null
            );
            return $resultado;
        }
        else if(isset($parametrosFiltro["fechaInicioVenta"])){
           $resultado = $managerFiltros->filtroFechaIncioValorVentasCantidades(
                $parametrosFiltro["fechaInicioVenta"],
                isset($parametrosFiltro["minTotal"]) ? $parametrosFiltro["minTotal"] : null,
                isset($parametrosFiltro["maxTotal"]) ? $parametrosFiltro["maxTotal"] : null,
                isset($parametrosFiltro["minTotalProducto"]) ? $parametrosFiltro["minTotalProducto"] : null,
                isset($parametrosFiltro["maxTotalProducto"]) ? $parametrosFiltro["maxTotalProducto"] : null
            );
            return $resultado;
        }
        else if(isset($parametrosFiltro["fechaFinVenta"])){
            $resultado = $managerFiltros->filtroFechaFinValorVentasCantidades(
                $parametrosFiltro["fechaFinVenta"],
                isset($parametrosFiltro["minTotal"]) ? $parametrosFiltro["minTotal"] : null,
                isset($parametrosFiltro["maxTotal"]) ? $parametrosFiltro["maxTotal"] : null,
                isset($parametrosFiltro["minTotalProducto"]) ? $parametrosFiltro["minTotalProducto"] : null,
                isset($parametrosFiltro["maxTotalProducto"]) ? $parametrosFiltro["maxTotalProducto"] : null
            );
            return $resultado;
        }

        return $managerFiltros->obtenerTodos();
        
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
}
