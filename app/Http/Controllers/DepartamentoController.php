<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retornar listado de departamentos
        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Lista de departamentos',
            'datos' => Departamento::all(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $departamento = Departamento::create($request->all());
        if (isset($departamento)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Departamento creado correctamente',
            ], 201);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al crear el departamento',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Departamento $departamento)
    {
        if(isset($departamento)){
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Departamento encontrado',
                'datos' => $departamento->load('municipios'),
            ], 200);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Departamento no encontrado',
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departamento $departamento)
    {
        //

        $departamento->update($request->all());
        if (isset($departamento)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Departamento actualizado correctamente',
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al actualizar el departamento',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departamento $departamento)
    {
        //

        $departamento->delete();
        if (isset($departamento)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Departamento eliminado correctamente',
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al eliminar el departamento',
            ], 400);
        }
    }

    //Obtener departamento segun nombre
    public function getDepartamentoPorNombre($nombre){
        $departamento = Departamento::where('nombre_departamento', $nombre)->first();
        if(isset($departamento)){
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Departamento encontrado',
                'datos' => $departamento->load('municipios'),
            ], 200);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Departamento no encontrado',
            ], 400);
        }
    }
}
