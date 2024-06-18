<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ausencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AusenciaController extends Controller
{
    public function index()
    {
        $listado = Ausencia::all();
        return response()->json([
            'data' => $listado,
            'errors' => []
        ], 200);
    }

    public function ausenciasPorEmpleado(Request $request)
    {
        $id_empleado = Auth::user()->id_empleado;
        if ($request->query('fechaInicio') && $request->query('fechaFin')) {
            $ausencias = Ausencia::where('id_empleado', $id_empleado)
                ->whereBetween('fecha_ausencia', [$request->query('fechaInicio'), $request->query('fechaFin')])
                ->with('justificacionAusencia', 'justificacionAusencia.estado')
                ->get();
            return response()->json([
                'data' => $ausencias,
                'errors' => []
            ], 200);
        } else {
            $ausencias = Ausencia::where('id_empleado', $id_empleado)
                ->get();
            return response()->json([
                'data' => $ausencias,
                'errors' => []
            ], 400);
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'id_empleado' => 'required|integer',
            'fecha_ausencia' => 'required|date'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'errors' => $validator->errors()
            ], 400);
        }
        $cargo = Ausencia::create($request->all());
        return response()->json([
            'data' => $cargo,
            'errors' => []
        ], 201);
    }

    public function show(string $id)
    {
        $ausencia = Ausencia::find($id);
        if (isset($ausencia)) {
            return response()->json([
                'data' => $ausencia,
                'errors' => []
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'errors' => 'Ausencia no encontrada'
            ], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        $rules = [
            'id_empleado' => 'required|integer',
            'fecha_ausencia' => 'required|date'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'errors' => $validator->errors()
            ], 400);
        }
        $ausencia = Ausencia::find($id);
        if (isset($ausencia)) {
            $ausencia->update($request->all());
            return response()->json([
                'data' => $ausencia,
                'errors' => []
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'errors' => 'Ausencia no encontrada'
            ], 404);
        }
    }

    public function destroy(string $id)
    {
        //
    }
}
