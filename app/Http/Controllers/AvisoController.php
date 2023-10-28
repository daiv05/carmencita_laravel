<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;


class AvisoController extends  Controller
{

    public function modificarEstadoAviso(Request $request, Aviso $aviso)
    {
        $mensaje = "";
        if ($aviso->estado_aviso) {
            $aviso->estado_aviso = false;
            $aviso->save();
            $mensaje = "Se desactivo el aviso con éxito";
        } else {
            $aviso->estado_aviso = true;
            $aviso->save();
            $mensaje = "Se activo el aviso con éxito";
        }
        return response()->json(
            [
                "mensaje" => $mensaje,
                "valor_estado" => $aviso->estado_aviso,
                "status" => true
            ],
            200
        );
    }

    public function index(Request $request)
    {
        if ($request->input("estado_aviso", " ") != " ") {
            if ($request->input("estado_aviso") == false || $request->input("estado_aviso") == true) {

                return Aviso::where("estado_aviso", "=", $request->input("estado_aviso"))->paginate(5);
            }
        }

        return Aviso::paginate(5);
    }

    public function show(Request $request, int $idAviso)
    {
        return Aviso::find($idAviso);
    }

    public function update(Request $request, Aviso $aviso)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "fecha_finalizacion" => 'required|date',
                "estado_de_aviso" => "required|boolean",
                "titulo_aviso" => "required|string",
                "cuerpo_aviso" => "required|string",
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => false,
                    "listaErrores" => $validator->errors()->all(),
                ],
                404
            );
        }
        $datosFormulario = $validator->validated();
        //$fecha_finalizacion = Carbon::createFromFormat("D-M",$datosFormulario["fecha_finalizacion"])->format("d-m-y");
        $aviso->fecha_finalizacion = $datosFormulario["fecha_finalizacion"];
        $aviso->estado_aviso = $datosFormulario["estado_de_aviso"];
        $aviso->titulo_aviso = $datosFormulario["titulo_aviso"];
        $aviso->cuerpo_aviso = $datosFormulario["cuerpo_aviso"];
        $aviso->save();

        return response()->json(
            [
                "message" => "Se modifico el aviso con exito",
                "aviso" => $aviso,
            ]
        );
    }

    public function destroy(Request $request, Aviso $aviso)
    {
        try {
            $resultado = $aviso->delete();
            return response()->json([
                "mensaje" => "Se elimino el aviso de manera exitosa",
                "respuesta" => $resultado,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "errores" => "El registro que desea eliminar no existe",
                "mensaje" => "El registro no esta en la base de datos, o se encuentra desconectada",
                "respuesta" => $resultado,
            ], 404);
        }
    }

    public function avisosBlog()
    {
        $fechaActual = Carbon::now()->toDateString();

        $avisos = Aviso::where('estado_aviso', 1)
            ->where('fecha_finalizacion', '>', $fechaActual)
            ->get();

        return response()->json($avisos);
    }


    //crear un nuevo aviso
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            
            'fecha_creacion' => 'required',
            'fecha_finalizacion' => 'required|after:fecha_creacion',
            "estado_aviso" => "required|boolean",
            "titulo_aviso" => "required|string",
            "cuerpo_aviso" => "required|string",

        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> false,
                'message'=> $validator->errors()->all(),
                'Hola' => 'hola',
            ]);
        }

        $aviso = new Aviso();
            $aviso->fecha_creacion = $request->fecha_finalizacion;//,
            if($request->fecha_finalizacion)
            {      
                $aviso->fecha_finalizacion = $request->fecha_finalizacion;
            }
            if($request->fecha_finalizacion)
            {
                $aviso->fecha_finalizacion= $request->fecha_finalizacion; 
            }

            $aviso->fecha_creacion= $request->fecha_creacion;
            $aviso->fecha_finalizacion= $request->fecha_finalizacion;
            $aviso->estado_aviso = $request->estado_aviso;
            $aviso->titulo_aviso= $request->titulo_aviso;
            $aviso->cuerpo_aviso= $request->cuerpo_aviso;
            $aviso->save();


        return response()->json([
            'status'=>true,
            'message'=>$validator->errors()->all(),
            'aviso'=>$aviso
        ]);
    }
}
