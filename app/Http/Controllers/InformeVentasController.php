<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Venta;

class InformeVentasController extends Controller
{
    //
    /*
        SELECT X1.id_venta as idVenta,SUM(X2.subtotal_detalle_venta) as total_venta,
        X1.fecha_venta AS fecha_venta
        FROM venta AS X1
        INNER JOIN detalleventa AS X2 ON X1.id_venta = X2.id_venta
        WHERE Month(X1.fecha_venta) = 1
        GROUP BY(X1.id_venta);

        ===============================
        SELECT X1.id_venta as idVenta,SUM(X2.subtotal_detalle_venta) as total_venta,
        X1.fecha_venta AS fecha_venta
        FROM venta AS X1
        INNER JOIN detalleventa AS X2 ON X1.id_venta = X2.id_venta
        WHERE Month(X1.fecha_venta)IN (1,2,3,4,5) AND YEAR(X1.fecha_venta) = 2021
        GROUP BY(X1.id_venta);
        ===================================
        SELECT SUM(X2.subtotal_detalle_venta) as total_venta,
        Month(X1.fecha_venta) AS mes_venta
        FROM venta AS X1
        INNER JOIN detalleventa AS X2 ON X1.id_venta = X2.id_venta
        WHERE Month(X1.fecha_venta)IN (1,2,3,4,5) AND YEAR(X1.fecha_venta) = 2021
        GROUP BY(Month(X1.fecha_venta));
    */
    public function obtenerVentasTotalesPorFecha($parametros)
    {
        $filtro_meses = $parametros["filtro_meses"];   
        $anio_filtro = $parametros["anio_filtro"];
        
        $ventas = Venta::selectRaw('SUM(detalleventa.subtotal_detalle_venta) as total_venta, MONTH(venta.fecha_venta) AS mes_venta')
            ->join('detalleventa', 'venta.id_venta', '=', 'detalleventa.id_venta')
            ->whereIn(DB::raw('MONTH(venta.fecha_venta)'), $filtro_meses)
            ->whereYear('venta.fecha_venta', $anio_filtro)
            ->groupBy(DB::raw('MONTH(venta.fecha_venta)'))
            ->get();

        return response()->json([
            "ventas" => $ventas
        ]);
    }
}
