<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;

class FechaController extends Controller
{
    protected $anio_base  = 2021;

    public function obtenerFechasParaFiltro(){
        $fecha_actual = Carbon::now();
        $anioActual = intval($fecha_actual->year);
        $lista_fechas_filtro = [];
        array_push($lista_fechas_filtro,$this->anio_base);
        for($i = $this->anio_base; $i < $anioActual; $i++){
            array_push($lista_fechas_filtro,$i+1);
        }
        return response()->json([
            "lista_fechas_filtro"=> $lista_fechas_filtro,
        ]);
    }
}
