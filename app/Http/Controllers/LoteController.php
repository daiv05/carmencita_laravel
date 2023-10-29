<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoteResource;
use App\Http\Resources\PaginacioLoteRecurso;
use Illuminate\Http\Request;
use App\Models\Lote;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PaginacionLoteRecursos;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Producto;
use PDOException;

class LoteController extends Controller
{
    //
    public function index(){
        //$lote = Lote::find(1);
        //return Lote::with("producto")->paginate(15);
        return PaginacioLoteRecurso::collection(Lote::paginate(10));
    }

    public function cambiarPrecioProducto($codigoBarraProducto,$nuevoPrecioUnitario){
        $producto = Producto::findorFail($codigoBarraProducto);
        if($producto->precio_unitario < $nuevoPrecioUnitario){
            $producto->precio_unitario = $nuevoPrecioUnitario;
            $producto->save();
        }
    }

    public function agregarExistenciasProducto($codigoBarraProducto,$cantidadProductoNuevo,$ultimasExistenciasIngresadas = 0){
        $producto = Producto::findorFail($codigoBarraProducto);
        if($ultimasExistenciasIngresadas > 0){
            $producto->cantidad_producto_disponible+= $cantidadProductoNuevo-$ultimasExistenciasIngresadas;
        }
        else{
            $producto->cantidad_producto_disponible+= $cantidadProductoNuevo;
        }
        $producto->save();
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "fecha_vencimiento"=>"date_format:Y-m-d|required",
            "codigo_barra_producto"=>["required",Rule::exists("producto","codigo_barra_producto")],
            "cantidad_total_unidades"=>"required|integer",
            "cantidad"=>"required|integer",
            "precio_unitario"=>"required|numeric|regex:/^\d+(\.\d{1,2})?$/",
            "costo_total"=>"required|numeric|regex:/^\d+(\.\d{1,2})?$/",
            "fecha_ingreso"=>"date_format:Y-m-d|required"
        ]);
        if($validator->fails()){
            return response()->json([
                "status"=>false,
                "errores"=>$validator->errors()->all(),
            ],404);
        }
        try{    
        $lote = new Lote();
        $lote->fecha_vencimiento = date('Y-m-d',strtotime($request->input("fecha_vencimiento")));
        $lote->codigo_barra_producto = $request->input("codigo_barra_producto");
        $lote->cantidad_total_unidades = $request->input("cantidad_total_unidades");
        $lote->cantidad = $request->input("cantidad");
        $lote->precio_unitario = $request->input("precio_unitario");
        $lote->costo_total = $request->input("costo_total");
        $lote->fecha_ingreso = date('Y-m-d',strtotime($request->input("fecha_ingreso")));
        $this->cambiarPrecioProducto($lote->codigo_barra_producto,$lote->precio_unitario);
        $this->agregarExistenciasProducto($lote->codigo_barra_producto,$lote->cantidad_total_unidades);
        $lote->save();
        
        return response()->json([
                "status"=>true,
                "mensaje"=>"Se guardo el lote con éxito",
                "lote"=> Lote::findorFail($lote->id_lote)->load("producto"),
            ]);
        }   
        catch(PDOException $e){
            return response()->json([
                "status"=>false,
                "error"=>$e->getMessage(),
            ],404);
        }
    }

    public function show(){
        
    }

    public function update(Request $request, Lote $tempLote){
        $validator = Validator::make($request->all(),[
            "id_lote"=>Rule::exists("lotes","id_lote"),
            "fecha_vencimiento"=>"date_format:Y-m-d|required",
            "codigo_barra_producto"=>["required",Rule::exists("producto","codigo_barra_producto")],
            "cantidad_total_unidades"=>"required|integer",
            "cantidad"=>"required|integer",
            "precio_unitario"=>"required|numeric|regex:/^\d+(\.\d{1,2})?$/",
            "costo_total"=>"required|numeric|regex:/^\d+(\.\d{1,2})?$/"
        ]);
        if($validator->fails()){
            return response()->json([
                "status"=>false,
                "errores"=>$validator->messages(),
            ],404);
        }
        $lote = Lote::find($request->input("id_lote"));
        $lote->fecha_vencimiento = date('Y-m-d',strtotime($request->input("fecha_vencimiento")));
        $lote->precio_unitario = $request->input("precio_unitario");
        $lote->costo_total = $request->input("costo_total");
        $lote->codigo_barra_producto = $request->input("codigo_barra_producto");
        $lote->cantidad = $request->input("cantidad");
        $lote->precio_unitario = $request->input("precio_unitario");
        $this->agregarExistenciasProducto($lote->codigo_barra_producto,$request->input("cantidad_total_unidades"),$lote->cantidad_total_unidades);
        $lote->cantidad_total_unidades = $request->input("cantidad_total_unidades");
        $lote->fecha_ingreso = $request->input("fecha_ingreso");
        $lote->save();
        return response()->json([
            "status"=>true,
            "mensaje"=>"Se actualizo el lote con éxito",
            "lote"=>$lote,
        ],201);
    }

    public function destroy($id_lote){
        try{
            //$lote->delete();
            $lote = Lote::findorFail($id_lote);
            $lote->delete();
            return response()->json([
            "status"=>true,
            "mensaje"=>"Se elimino el lote con exito",
            ],200);
        }catch(PDOException $e){
          return response()->json([
            "status"=>false,
            "error"=>$e->getMessage(),
          ],400);
        }
    }
    /*agregar metodos para cambiar el precio del producto en funcion del precio unitario que es nuevo en el sistema */
}

