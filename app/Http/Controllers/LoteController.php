<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaginacioLoteRecurso;
use Illuminate\Http\Request;
use App\Models\Lote;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PaginacionLoteRecursos;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class LoteController extends Controller
{
    //
    public function index(){
        //$lote = Lote::find(1);
        //return Lote::with("producto")->paginate(15);
        return PaginacioLoteRecurso::collection(Lote::paginate(10));
    }

    public function store(Request $request){
        /*$validator = Validator::make($request->all(),[

        ]);*/
        return response()->json([
            "mensaje"=>"Funciono la prueba para las cabeceras CORS",
        ]);
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
            "precio_unitario"=>"required|decimal:2",
            "costo_total"=>"required|decimal:2"
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
        $lote->cantidad_total_unidades = $request->input("cantidad_total_unidades");
        $lote->fecha_ingreso = $request->input("fecha_ingreso");
        $lote->save();
        return response()->json([
            "status"=>true,
            "mensaje"=>"Se actualizo el lote con éxito",
            "lote"=>$lote,
        ],201);
    }
}

