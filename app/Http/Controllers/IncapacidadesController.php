<?php

namespace App\Http\Controllers;

use App\Models\Incapacidad;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class IncapacidadesController extends Controller
{
    public function  index(Request $request)//Empleados
    {
        try {
            $incapacidad = null;
            if ($request->has('id_empleado')) {
                $incapacidad = Incapacidad::where('id_empleado', $request->id_empleado)->with('estado')->get();
            }
            $listadoFiltrado = [];
            array_push($listadoFiltrado, $incapacidad);

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

    public function indexGerente(Request $request)//Gerente
    {
        try {
            $incapacidad = Incapacidad::all();
            $listadoFiltrado = [];
            array_push($listadoFiltrado, $incapacidad);

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

    public function show($id)
    {
        $incapacidad = Incapacidad::find($id);

        if($incapacidad == null){
            return response()->json(['No se encontro la incapadidad solicitada.'],404);
        }else{
            return response()->json($incapacidad);
        }
    }

    public function store(Request $request)
    {

        $id_empleado = Auth::user()->id_empleado;
        error_log($request->hasFile('comprobante'));
        error_log($request->incapacida);
        $rules = [
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'detalle' => 'required|string',
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
            $date=Carbon::now();
            $incapacidad = Incapacidad::create([
                'id_empleado' => $id_empleado,
                'fecha_solicitud' => $date,
                'fecha_inicio' =>$request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'id_estado' => 1,
                'comprobante' => $request->comprobante,
                'detalle' => $request->detalle,

            ]);
            if ($request->hasFile('comprobante')) {
                $incapacidad->update([
                    'comprobante' => $request->comprobante->store('incapacidades/comprobantes')
                ]);
                $incapacidad->save();
            }
            return response()->json([
                'data' => $incapacidad,
                'errors' => []
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $id_empleado = Auth::user()->id_empleado;
        $rules = [
            'detalle' => 'required|string'
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
            $incapacidad = Incapacidad::find($id);
            $incapacidad->update([
                'detalle' => $request->detalle,
            ]);
            if ($request->hasFile('comprobante')) {
                // Eliminar el archivo anterior de Storage/app
                if ($incapacidad->comprobante !== null) {
                    Storage::delete($incapacidad->comprobante);
                }
                $incapacidad->update([
                    'comprobante' => $request->comprobante->store('incapacidades/comprobantes')
                ]);
            } else {
                if ($incapacidad->comprobante !== null) {
                    Storage::delete($incapacidad->comprobante);
                }
                $incapacidad->update([
                    'comprobante' => null
                ]);
            }

            return response()->json([
                'data' => $incapacidad,
                'errors' => []
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(String $id)
    {
        try {
           $incapacidad = Incapacidad::find($id);
            if ($incapacidad->comprobante !== null) {
                Storage::delete($incapacidad->comprobante);
            }
           $incapacidad->delete();
            return response()->json([
                'data' =>$incapacidad,
                'errors' => []
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function actualizarEstado(Request $request)//Gerente
    {
        $rules = [
            'id_estado' => 'required|exists:estados,id',
            'id' => 'required|exists:incapacidadesgit ,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'errors' => $validator->errors()
            ], 400);
        }
        try {
            $incapacidad = Incapacidad::find($request->id);
            //Validar
            if($incapacidad->id_estado == 1){

                $incapacidad->update([
                    'id_estado' => $request->id_estado
                ]);
                return response()->json([
                    'data' => $incapacidad,
                    'errors' => []
                ], 201);
            }else{
                return response()->json(['Error, no se puede cambiar el estado'],400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function getArchivoComprobante(Request $request)
    {
        error_log($request->comprobante);
        return response()->download(storage_path('app/' . $request->comprobante));
    }


}
