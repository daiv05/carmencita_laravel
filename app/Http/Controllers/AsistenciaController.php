<?php

namespace App\Http\Controllers;

use App\Models\HojaAsistencia;
use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Empleado;
use Nette\Utils\DateTime;
use Illuminate\Support\Facades\DB;

class AsistenciaController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        try {
            
            if(!isset($request->id_empleado) or !(Empleado::where('id_empleado',$request->id_empleado)->exists())){
                return response()->json([
                    'status' => false,
                    'mensaje' => 'No se ha encontrado al empleado'
                ],400);
            }

            $fechaActual = date('Y-m-d');
            $existeAsistencia = Asistencia::where('id_empleado', $request->id_empleado)->where('fecha', $fechaActual)->first(); //comprobar que no este registrada la asistencia
            if (!isset($existeAsistencia)) {
                $asistencia = Asistencia::create([
                    //'hoja_asistencia_id' => $hojaAsistencia->id,
                    'id_empleado' => $request->id_empleado,
                    'fecha' => $fechaActual,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'mensaje' => 'Ya se ha marcado la asistencia para este dia'
                ], 200);
            }

            if (isset($asistencia)) {
                return response()->json([
                    'status' => true,
                    'asistencia' => $asistencia,
                    'mensaje' => 'Asistencia guardada correctamente'
                ], 200);
            }
            return response()->json([
                'status' => false,
                'mensaje' => 'Error al registrar la asistencia'
            ], 400);

        } catch (\Exception $e) {
            \Log::error('Error: ' . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error'], 500);
        }

    }

    public function getAsistenciasEmpleado(Request $request)
    {
        //Obtiene las asistencias del mes actual
        //$fechaActual = date('Y-m-d');
        $fechaActual = new DateTime();
        $diasMes = cal_days_in_month(CAL_GREGORIAN, $fechaActual->format('m'), $fechaActual->format('Y'));
        $fechaInicio = new DateTime($fechaActual->format('Y') . '-' . $fechaActual->format('m') . '-01');
        $fechaFin = new DateTime($fechaActual->format('Y') . '-' . $fechaActual->format('m') . '-' . $diasMes);

        $empleado = Empleado::where('id_empleado', $request->id_empleado)->first();

        if (isset($empleado)) {
            $asistencias = Asistencia::where('id_empleado', $empleado->id_empleado)->where('fecha', '>=', $fechaInicio)->where('fecha', '<=', $fechaFin)->get();
        }

        if (isset($empleado) and isset($asistencias)) {
            return response()->json([
                'status' => true,
                'empleado' => $empleado,
                'asistencias' => $asistencias,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin
            ], 200);
        }
        return response()->json([
            'status' => false,
            'mensaje' => 'Ha ocurrido un error',
            'empleado' => $empleado
        ], 400);

    }

    public function update()
    {

    }
}