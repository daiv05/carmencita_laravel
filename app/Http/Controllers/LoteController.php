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
        $validator = Validator::make($request->all(),[

        ]);
    }

    public function show(){
        
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            "id_lote"=>Rule::exists("lotes","id_lote"),
            "fecha_vencimiento"=>"date_format:Y-m-d|required",
            "codigo_barra_producto"=>["required",Rule::exists("producto","codigo_barra_producto")],
            "cantidad_total_unidades"=>"required|decimal:2",
            "cantidad"=>"required|integer",
            "precio_unitario"=>"required|decimal:2|integer",
            "costo_total"=>"required|decimal:2"
        ]);
        if($validator->fails()){
            return response()->json([
                "status"=>false,
                "errores"=>$validator->messages(),
            ],404);
        }
        $lote = Lote::where("id_lote",$request->input("id_lote"))->first();
        $lote->fecha_vencimiento = $request->input("fecha_vencimiento");
        $lote->precio_unitario = $request->input("precio_unitario");
        $lote->costo_total = $request->input("costo_total");
        $loye->codigo_barra_producto = $request->input("");

    }
}

