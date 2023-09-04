<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\InformeInventarioResource;
use App\Models\Producto;


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
    string $fechaFinVenta = '2050-12-31', float $minTotal = 0.00, float $maxTotal = 5000000.00, 
    int $minTotalProducto = 0, int $maxTotalProducto = 1000000)
    {
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
}
