<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        // Retornar listado de municipios
        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Lista de municipios',
            'datos' => Municipio::all(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $municipio = Municipio::create($request->all());
        if (isset($municipio)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Municipio creado correctamente',
            ], 201);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al crear el municipio',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Municipio $municipio)
    {
        //
        if (isset($municipio)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Municipio encontrado',
                'datos' => $municipio->load('departamento'),
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Municipio no encontrado',
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Municipio $municipio)
    {
        //

        $municipio->update($request->all());
        if (isset($municipio)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Municipio actualizado correctamente',
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al actualizar el municipio',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Municipio $municipio)
    {
        //

        $municipio->delete();
        if (isset($municipio)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Municipio eliminado correctamente',
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al eliminar el municipio',
            ], 400);
        }
    }

    public function municipios_segun_departamento(Request $request){
        error_log('departamento');
        $department = $request->query('departamento', null);
        error_log($department);
        if (isset($department)) {
            $municipios = Municipio::where('id_departamento', $department)->get();
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Municipios encontrados',
                'datos' => $municipios,
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Municipios no encontrados',
            ], 400);
        }
    }
}
