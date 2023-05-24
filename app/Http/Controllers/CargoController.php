<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarCargoRequest;
use Illuminate\Http\Request;
use App\Models\Cargo;

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
            ]);
        }
        else{
            return response()->json([
                'respuesta' => false
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
