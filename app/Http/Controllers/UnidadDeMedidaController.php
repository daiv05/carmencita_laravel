<?php

namespace App\Http\Controllers;

use App\Models\UnidadDeMedida;
use Illuminate\Http\Request;

class UnidadDeMedidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Se retorna la lista de unidades de medida
        return UnidadDeMedida::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Se definen las reglas de validación
        $rules = [
            'nombre_unidad_de_medida' => 'required|string|max:60'
        ];
        $validador = \Validator::make($request->input(), $rules);
        // Se valida que la variable $validador no haya fallado
        if ($validador->fails()){
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validador->errors()->all()
            ], 400);
        }
        // Se crea la unidad de medida con los datos ingresados
        $unidadDeMedida = UnidadDeMedida::create($request->input());
        // Se valida que la unidad de medida se haya creado correctamente
        if (isset($unidadDeMedida)){
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Unidad de medida creada correctamente',
            ], 201);
        }
        // Si la unidad de medida no se creó correctamente, se retorna un mensaje de error
        else{
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al crear la unidad de medida',
            ], 400);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(UnidadDeMedida $id_unidad_de_medida)
    {
        // Se busca la unidad de medida por su id
        $unidadDeMedida = UnidadDeMedida::find($id_unidad_de_medida);
        // Se valida que la unidad de medida exista
        if (isset($unidadDeMedida)){
            // Se retorna la unidad de medida encontrada
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Unidad de medida encontrada',
                'unidadDeMedida' => $unidadDeMedida
            ], 200);
        }
        // Si la unidad de medida no existe, se retorna un mensaje de error
        else{
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Unidad de medida no encontrada',
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnidadDeMedida $unidadDeMedida)
    {
        // Se definen las reglas de validación, igual que en el método store
        $rules = [
            'nombre_unidad_de_medida' => 'required|string|max:60'
        ];
        // Se crea una variable $validador para almacenar el resultado de la validación
        $validador = \Validator::make($request->input(), $rules);
        // Se valida que la variable $validador no haya fallado
        if ($validador->fails()){
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validador->errors()->all()
            ], 400);
        }
        // Se actualiza la unidad de medida con los datos ingresados
        $unidadDeMedida->update($request->input());
        // Se valida que la unidad de medida se haya actualizado correctamente
        if (isset($unidadDeMedida)){
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Unidad de medida actualizada correctamente',
            ], 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnidadDeMedida $id_unidad_de_medida)
    {
        // Se elimina la unidad de medida
        $id_unidad_de_medida->delete();
        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Unidad de medida eliminada correctamente',
        ], 200);
    }
}
