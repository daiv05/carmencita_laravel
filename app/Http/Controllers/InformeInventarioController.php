<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\InformeInventarioResource;
use App\Models\Producto;
use PhpParser\Node\Expr\Cast\Array_;

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
