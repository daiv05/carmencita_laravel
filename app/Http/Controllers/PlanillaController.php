<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nette\Utils\DateTime;
use App\Models\Planilla;
use App\Models\Empleado;
use App\Models\DetallePlanilla;

class PlanillaController extends Controller
{

    public function index()
    {
        return Planilla::all()->paginate(5);
    }

    public function store(Request $request)
    {

        //Comprobar si hay empleados activos
        $empleados = Empleado::where('esta_activo', '1')->get();
        if (!isset($empleados)) {
            return response()->json([
                'status' => true,
                'mensaje' => 'No se encontraron empleados activos.'
            ], 200);
        }

        $total_seguro = 0;
        $total_afp = 0;
        $total = 0; // total de planilla

        $fecha = $request->fecha;//fecha para la cual estamos generando la planilla
        $fecha = new DateTime($fecha);
        $diasMes = cal_days_in_month(CAL_GREGORIAN, $fecha->format('m'), $fecha->format('Y'));

        if ($fecha->format('d') <= 15) {
            $fechaInicio = date($fecha->format('Y') . '-' . $fecha->format('m') . '-1');
            $fechaFin = date($fecha->format('Y') . '-' . $fecha->format('m') . '-15');
        } else {
            $fechaInicio = date($fecha->format('Y') . '-' . $fecha->format('m') . '-16');
            $fechaFin = date($fecha->format('Y') . '-' . $fecha->format('m') . '-' . $diasMes);
        }

        if (Planilla::where('fecha_inicio', $fechaInicio)->exists()) {
            return response()->json([
                'status' => false,
                'mensaje' => 'La planilla del ' . date('d/m/Y', strtotime($fechaInicio)) . ' al ' . date('d/m/Y', strtotime($fechaFin)) . ' Ya existe.'
            ], 200);
        } else {
            $planilla = Planilla::create([
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin
            ]);
        }

        if (!isset($planilla)) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Ocurrio un erros al crear la planilla'
            ], 200);
        }

        foreach ($empleados as $empleado) {
            //Creamos el detallePlanilla para cada empleado
            $diasLaborados = $empleado->asistencia()->where('fecha', '>=', $fechaInicio)->where('fecha', '<=', $fechaFin)->count();
            $salarioMensual = $empleado->cargo->salario_cargo;
            $sueldoDiario = $salarioMensual / 30.00;
            $sueldoBase = $sueldoDiario * $diasLaborados;

            $afp = $sueldoBase * 0.03;
            $isss = $sueldoBase * 0.0725;
            $totalAPagar = $sueldoBase - $afp - $isss;

            $detallePlanilla = DetallePlanilla::create([
                'id_empleado' => $empleado->id_empleado,
                'id_planilla' => $planilla->id,
                'base' => $sueldoBase,
                'monto_isss' => $isss,
                'monto_afp' => $afp,
                'monto_pago' => $totalAPagar,
                'dias_laborados' => $diasLaborados,
            ]);

            $total_seguro += $isss;
            $total_afp += $afp;
            $total += $totalAPagar;
        }

        $planilla->total_seguro = $total_seguro;
        $planilla->total_afp = $total_afp;
        $planilla->total = $total;
        $planilla->update();
        $detalles = $planilla->detallesPlanilla()->get();

        return response()->json([
            'status' => true,
            'mensaje' => 'La planilla del ' . date('d/m/Y', strtotime($fechaInicio)) . ' al ' . date('d/m/Y', strtotime($fechaFin)) . ' se ha guardado correctamente',
            'planilla' => $planilla,
            'detalles' => $detalles,
        ], 200);

    }
}