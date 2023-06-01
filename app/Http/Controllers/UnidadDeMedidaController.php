<?php

namespace App\Http\Controllers;

use App\Models\UnidadDeMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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
        $validador = Validator::make($request->all(), $rules);
        // Se valida que la variable $validador no haya fallado
        if ($validador->fails()){
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validador->errors()->all()
            ], 400);
        }
        // Se valida que los datos ingresados sean correctos, según las reglas definidas
        if ($request->validate($rules)){
            // Se crea la unidad de medida con los datos ingresados
            $unidadDeMedida = UnidadDeMedida::create($request->all());
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

    }

    /**
     * Display the specified resource.
     */
    //public function show(UnidadDeMedida $unidadDeMedida)
    public function show($id)
    {
        // Buscar la unidad de medida por el ID en la base de datos
        $unidadDeMedida = UnidadDeMedida::find($id);

        // Verificar si se encontró la unidad de medida
        if ($unidadDeMedida) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Unidad de medida encontrada',
                'unidadDeMedida' => $unidadDeMedida
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Unidad de medida no encontrada',
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    //public function update(Request $request, UnidadDeMedida $unidadDeMedida)
    public function update(Request $request, $id)
    {
        // Buscar la unidad de medida por el ID en la base de datos
        $unidadDeMedida = UnidadDeMedida::find($id);

        // Verificar si se encontró la unidad de medida
        if ($unidadDeMedida) {
            // Se definen las reglas de validación, igual que en el método store
            $rules = [
                'nombre_unidad_de_medida' => 'required|string|max:60'
            ];
            // Se crea una variable $validador para almacenar el resultado de la validación
            $validador = Validator::make($request->all(), $rules);
            // Se valida que la variable $validador no haya fallado
            if ($validador->fails()){
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => $validador->errors()->all()
                ], 400);
            }
            // Se valida que los datos ingresados sean correctos, según las reglas definidas
            if ($request->validate($rules)){
                // Se actualiza la unidad de medida con los datos ingresados
                $unidadDeMedida->update($request->all());

                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Unidad de medida actualizada correctamente',
                ], 200);
            }
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Unidad de medida no encontrada',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    //public function destroy(UnidadDeMedida $unidadDeMedida)
    public function destroy($id)
    {
        // Buscar la unidad de medida por el ID en la base de datos
        $unidadDeMedida = UnidadDeMedida::find($id);
        // Verificar si se encontró la unidad de medida
        if ($unidadDeMedida) {
            // Eliminar la unidad de medida
            $unidadDeMedida->delete();
            // Retornar un mensaje de éxito
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Unidad de medida eliminada correctamente',
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al eliminar la unidad de medida',
            ], 400);
        }
    }
}
