<?php

namespace App\Http\Controllers;

use App\Models\JustificacionAusencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JustificacionAusenciaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $justificacionesAusencias = null;
            if ($request->has('id_empleado')) {
                $justificacionesAusencias = JustificacionAusencia::where('id_empleado', $request->id_empleado)->with('ausencia')->with('estado')->get();
            } else {
                $justificacionesAusencias = JustificacionAusencia::with('ausencia')->with('ausencia.empleado')->with('estado')->get();
            }
            $listadoFiltrado = [];
            if ($request->fechaAusencia !== null) {
                foreach ($justificacionesAusencias as $justificacionAusencia) {
                    if ($justificacionAusencia->ausencia->fecha_ausencia == $request->fechaAusencia) {
                        array_push($listadoFiltrado, $justificacionAusencia);
                    }
                }
            } else {
                foreach ($justificacionesAusencias as $justificacionAusencia) {
                    array_push($listadoFiltrado, $justificacionAusencia);
                }
            }
            // Paginar array
            $currentPage = $request->page;
            $perPage = 10;
            $offset = ($currentPage - 1) * $perPage;
            $listadoPaginado = array_slice($listadoFiltrado, $offset, $perPage);
            return response()->json([
                'data' => $listadoPaginado,
                'totalPages' => ceil(count($listadoFiltrado) / $perPage),
                'errors' => []
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $id_empleado = Auth::user()->id_empleado;
        error_log($request->hasFile('comprobante'));
        error_log($request->justificacion);
        $rules = [
            'id_ausencia' => 'required|exists:ausencias,id',
            'fecha_solicitud' => 'required|date',
            'justificacion' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            if (isset($id_empleado) && $id_empleado == null) {
                return response()->json([
                    'data' => [],
                    'errors' => 'No se encontró el empleado'
                ], 404);
            }
            if ($request->hasFile('comprobante')) {
                $rules = [
                    'comprobante' => 'file|mimes:pdf|max:10048'
                ];
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'data' => [],
                        'errors' => $validator->errors()
                    ], 400);
                }
            }
            $justificacionAusencia = JustificacionAusencia::create([
                'id_ausencia' => $request->id_ausencia,
                'id_estado' => 1,
                'id_empleado' => $id_empleado,
                'fecha_solicitud' => $request->fecha_solicitud,
                'justificacion' => $request->justificacion,
            ]);
            if ($request->hasFile('comprobante')) {
                $justificacionAusencia->update([
                    'comprobante' => $request->comprobante->store('ausencias/comprobantes')
                ]);
                $justificacionAusencia->save();
            }
            return response()->json([
                'data' => $justificacionAusencia,
                'errors' => []
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function getArchivosComprobantes(Request $request)
    {
        error_log($request->comprobante);
        return response()->download(storage_path('app/' . $request->comprobante));
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $id_empleado = Auth::user()->id_empleado;
        $rules = [
            'justificacion' => 'required|string'
        ];
        if ($request->hasFile('comprobante')) {
            $rules['comprobante'] = 'nullable|file|mimes:pdf|max:10048';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'errors' => $validator->errors()
            ], 400);
        }
        try {
            if (isset($id_empleado) && $id_empleado == null) {
                return response()->json([
                    'data' => [],
                    'errors' => 'No se encontró el empleado'
                ], 404);
            }
            $justificacionAusencia = JustificacionAusencia::find($id);
            $justificacionAusencia->update([
                'justificacion' => $request->justificacion,
            ]);
            if ($request->hasFile('comprobante')) {
                // Eliminar el archivo anterior de Storage/app
                if ($justificacionAusencia->comprobante !== null) {
                    Storage::delete($justificacionAusencia->comprobante);
                }
                $justificacionAusencia->update([
                    'comprobante' => $request->comprobante->store('ausencias/comprobantes')
                ]);
            } else {
                if ($justificacionAusencia->comprobante !== null) {
                    Storage::delete($justificacionAusencia->comprobante);
                }
                $justificacionAusencia->update([
                    'comprobante' => null
                ]);
            }

            return response()->json([
                'data' => $justificacionAusencia,
                'errors' => []
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function actualizarEstado(Request $request)
    {
        $rules = [
            'id_estado' => 'required|exists:estados,id',
            'id' => 'required|exists:justificaciones_ausencias,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'errors' => $validator->errors()
            ], 400);
        }
        try {
            $justificacionAusencia = JustificacionAusencia::find($request->id);
            $justificacionAusencia->update([
                'id_estado' => $request->id_estado
            ]);
            return response()->json([
                'data' => $justificacionAusencia,
                'errors' => []
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $justificacionAusencia = JustificacionAusencia::find($id);
            if ($justificacionAusencia->comprobante !== null) {
                Storage::delete($justificacionAusencia->comprobante);
            }
            $justificacionAusencia->delete();
            return response()->json([
                'data' => $justificacionAusencia,
                'errors' => []
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
