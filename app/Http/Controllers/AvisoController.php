<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AvisoController extends  Controller
{

    public function show(Request $request, int $idAviso){
        return Aviso::find($idAviso);
    }

    public function update(Request $request, Aviso $aviso){
       $validator = Validator::make(
        $request->all(),
        [
            "fecha_finalizacion"=>'required|date',
            "estado_de_aviso"=>"required|boolean",
            "titulo_aviso"=>"required|string",
            "cuerpo_aviso"=>"required|string",
        ]
       );

       if($validator->fails()){
            return response()->json(
                [
                    "status"=>false,
                    "listaErrores"=>$validator->errors()->all(),
                ],404
            );
       }
       $datosFormulario = $validator->validated();

       $aviso->fecha_finalizacion = date("Y-m-d",strtotime($datosFormulario["fecha_finalizacion"]));
       $aviso->estado_aviso = $datosFormulario["estado_de_aviso"];
       $aviso->titulo_aviso = $datosFormulario["titulo_aviso"];
       $aviso->cuerpo_aviso = $datosFormulario["cuerpo_aviso"];
       $aviso->save();
       
       return response()->json(
        [
            "message"=>"Se modifico el aviso con exito",
            "aviso"=>$aviso
        ]
       );

    }
}
