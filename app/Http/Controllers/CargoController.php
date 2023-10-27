<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarCargoRequest;
use App\Http\Requests\GuardarCargoRequest;
use Illuminate\Http\Request;
use App\Models\Cargo;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Cargo::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuardarCargoRequest $request)
    {
        //
        if($request->validated()){
            $cargo = Cargo::create($request->all());
            if(isset($cargo)){
                return  response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Cargo creado correctamente',
                    'cargo'=>$cargo,
                ]);
            }
            else{
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al guardar el cargo',
                ]);
            }
        }
        else{
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error en los datos ingresados',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_cargo)
    {
        $cargo = Cargo::find($id_cargo);
        if(isset($cargo)){
            return response()->json([
                'respuesta' => true,
                'cargo' => $cargo
            ],200);
        }
        else{
            return response()->json([
                'respuesta' => false
            ],400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cargo $cargo)
    {
        $rules = [
            "nombre_cargo"=>[
                "required",
                "string",
                Rule::unique('cargo')->ignore($cargo)
            ],
            "descripcion_cargo"=>"required|string",
            "salario_cargo"=>"required|numeric",
            "id_jornada_laboral_diaria"=>"required",
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json([
                "respuesta"=>false,
                "mensaje"=>$validator->errors()->all()
            ]);
        }else{
            if(isset($cargo)){
                $cargo->update($request->all());
                return response()->json([
                    "respuesta"=>true,
                    "mensaje"=>"Cargo Actualizado correctamente"
                ]);
            }
            else{
                return response()->json(
                    [
                        "respuesta"=>false,
                        "mensaje" => "El cargo que quiere actualizar no existe"
                    ]
                );
            }
        }
        /*
        $cargo = Cargo::find($id);
        if(isset($cargo)){
            if($request->validated()){
                $cargo->update($request->all());
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Cargo actualizado correctamente',
                ],200);
            }
            else{
                $request->fails();
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => $request->errors()->all()
                ]);
            }
        }
        else{
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'El cargo que desea actualizar no existe',
            ]);
        }*/
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cargo $cargo)
    {
        $cargo->delete();
        return response()->json(
            [
                "respuesta"=> true,
                "mensaje"=> "Cargo eliminado correctamente",
            ], 200
        );
    }
}
