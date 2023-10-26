<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Empleado;
use Nette\Utils\DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AsistenciaController extends Controller
{
    public function index()
    {
        //Reotornar todas las asistencias, si no hay asistencias, retornar un mensaje o un codigo de error
        try {
            $asistencias = Asistencia::all();
            if (isset($asistencias)) {
                return response()->json([
                    'status' => true,
                    'asistencias' => $asistencias
                ], 200);
            }
            return response()->json([
                'status' => false,
                'mensaje' => 'No se han encontrado asistencias'
            ], 400);

        } catch (\Exception $e) {
            \Log::error('Error: ' . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $usuario = Auth::user();
            if(!isset($usuario)){
                return response()->json([
                    'status' => false,
                    'mensaje' => 'No se ha encontrado al empleado'
                ],400);
            }

            $fechaActual = date('Y-m-d');
            $existeAsistencia = Asistencia::where('id_empleado', $usuario->id_empleado)->where('fecha', $fechaActual)->first(); //comprobar que no este registrada la asistencia
            if (!isset($existeAsistencia)) {
                $asistencia = Asistencia::create([
                    //'hoja_asistencia_id' => $hojaAsistencia->id,
                    'id_empleado' => $usuario->id_empleado,
                    'fecha' => $fechaActual,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'mensaje' => 'Ya has marcado la asistencia para este dia'
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

    public function getAsistenciasEmpleado(Request $request, Empleado $id_empleado = null)
    {
        //Obtiene las asistencias del mes actual
        //$fechaActual = date('Y-m-d');
        
        if ($id_empleado == null){
            $fechaActual = new DateTime();
            $diasMes = cal_days_in_month(CAL_GREGORIAN, $fechaActual->format('m'), $fechaActual->format('Y'));
            $fechaInicio = new DateTime($fechaActual->format('Y') . '-' . $fechaActual->format('m') . '-01');
            $fechaFin = new DateTime($fechaActual->format('Y') . '-' . $fechaActual->format('m') . '-' . $diasMes);
            
            $usuario = Auth::user()->id_empleado;//check();
            $empleado = Empleado::where('id_empleado', $usuario)->first();
            $empleado::with('cargo')->where('id_empleado',$empleado->id_empleado)->first();
            $empleado_compacto = [
                'nombre'=> $empleado->primer_nombre,
                'apellido' => $empleado->primer_apellido,
                'cargo' => $empleado->cargo->nombre_cargo
            ];

            if (isset($empleado)) {
                $asistencias = Asistencia::where('id_empleado', $empleado->id_empleado)->where('fecha', '>=', $fechaInicio)->where('fecha', '<=', $fechaFin)->get();
            }
        }
        else
        {
            $empleado = Empleado::where('id_empleado', $id_empleado->id_empleado)->first();
            $empleado::with('cargo')->where('id_empleado',$empleado->id_empleado)->first();
            $empleado_compacto = [
                'nombre'=> $empleado->primer_nombre,
                'apellido' => $empleado->primer_apellido,
                'cargo' => $empleado->cargo->nombre_cargo
            ];

            if (isset($empleado)) {
                $asistencias = Asistencia::where('id_empleado', $empleado->id_empleado)->get();
            }
        }

        if (isset($empleado) and isset($asistencias)) {
            return response()->json([
                'status' => true,
                'empleado' => $empleado_compacto,
                'asistencias' => $asistencias,
                /*'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,
                'usuario' => $usuario*/
            ], 200);
        }
        return response()->json([
            'status' => false,
            'mensaje' => 'Ha ocurrido un error',
            'empleado' => $usuario
        ], 400);

    }

    public function update()
    {

    }
}