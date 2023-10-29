<?php
namespace App\Filtros;
use App\Filtros\InterfazFiltroProductosMasVendidos;
use Illuminate\Support\Facades\DB;

class FiltroProductosMasVendidos implements InterfazFiltroProductosMasVendidos {

    private $numberPaginate;

    public function __construct($numberPaginate)
    {
        $this->numberPaginate = $numberPaginate;
    }

    public function filtrarPorFechaInicio($fechaInicio, $tipoOrden, $cantidadAMostrar){

        return DB::table('producto as X1')
            ->select(
                'X1.codigo_barra_producto',
                'X1.nombre_producto',
                DB::raw('COALESCE(X2.total_venta, 0) AS total_venta'),
                DB::raw('COALESCE(X3.total_credito, 0) AS total_credito'),
                DB::raw('COALESCE(X2.total_venta, 0) + COALESCE(X3.total_credito, 0) AS total'),
                DB::raw('COALESCE(X2.cantidad_producto, 0) AS total_producto_venta'),
                DB::raw('COALESCE(X3.cantidad_producto_credito, 0) AS cantidad_producto_credito'),
                DB::raw('(COALESCE(X2.cantidad_producto, 0) + COALESCE(X3.cantidad_producto_credito, 0)) AS total_producto_vendido')
            )
            ->leftJoin(DB::raw("(
                SELECT SUM(Y2.subtotal_detalle_venta) AS total_venta,
                       SUM(Y2.cantidad_producto) AS cantidad_producto,
                       Y1.codigo_barra_producto
                FROM producto AS Y1
                INNER JOIN detalleventa AS Y2 ON Y1.codigo_barra_producto = Y2.codigo_barra_producto
                INNER JOIN venta as Y3 ON Y2.id_venta = Y3.id_venta
                WHERE Y3.fecha_venta >= '$fechaInicio'
                GROUP BY Y1.codigo_barra_producto
            ) AS X2"), 'X1.codigo_barra_producto', '=', 'X2.codigo_barra_producto')
            ->leftJoin(DB::raw("(
                SELECT SUM(Z2.subtotal_detalle_credito) AS total_credito,
                       SUM(Z2.cantidad_producto_credito) AS cantidad_producto_credito,
                       Z1.codigo_barra_producto
                FROM producto AS Z1
                INNER JOIN detallecredito AS Z2 ON Z1.codigo_barra_producto = Z2.codigo_barra_producto
                INNER JOIN creditofiscal AS Z3 ON Z3.id_creditofiscal = Z2.id_creditofiscal
                WHERE Z3.fecha_credito >= '$fechaInicio'
                GROUP BY Z1.codigo_barra_producto
            ) AS X3"), 'X1.codigo_barra_producto', '=', 'X3.codigo_barra_producto')
            ->where(function ($query) {
                $query->where(DB::raw('COALESCE(X2.total_venta, 0)'), '>', 0)
                    ->orWhere(DB::raw('COALESCE(X3.total_credito, 0)'), '>', 0);
            })            
            ->orderBy('total_producto_vendido', $tipoOrden)
            ->limit($cantidadAMostrar)->get()
            ->paginate($this->numberPaginate);

    }

    public function filtrarPorFechaFin($fechaFin, $tipoOrden, $cantidadAMostrar){

        return DB::table('producto as X1')
            ->select(
                'X1.codigo_barra_producto',
                'X1.nombre_producto',
                DB::raw('COALESCE(X2.total_venta, 0) AS total_venta'),
                DB::raw('COALESCE(X3.total_credito, 0) AS total_credito'),
                DB::raw('COALESCE(X2.total_venta, 0) + COALESCE(X3.total_credito, 0) AS total'),
                DB::raw('COALESCE(X2.cantidad_producto, 0) AS total_producto_venta'),
                DB::raw('COALESCE(X3.cantidad_producto_credito, 0) AS cantidad_producto_credito'),
                DB::raw('(COALESCE(X2.cantidad_producto, 0) + COALESCE(X3.cantidad_producto_credito, 0)) AS total_producto_vendido')
            )
            ->leftJoin(DB::raw("(
                SELECT SUM(Y2.subtotal_detalle_venta) AS total_venta,
                       SUM(Y2.cantidad_producto) AS cantidad_producto,
                       Y1.codigo_barra_producto
                FROM producto AS Y1
                INNER JOIN detalleventa AS Y2 ON Y1.codigo_barra_producto = Y2.codigo_barra_producto
                INNER JOIN venta as Y3 ON Y2.id_venta = Y3.id_venta
                WHERE Y3.fecha_venta <= '$fechaFin'
                GROUP BY Y1.codigo_barra_producto
            ) AS X2"), 'X1.codigo_barra_producto', '=', 'X2.codigo_barra_producto')
            ->leftJoin(DB::raw("(
                SELECT SUM(Z2.subtotal_detalle_credito) AS total_credito,
                       SUM(Z2.cantidad_producto_credito) AS cantidad_producto_credito,
                       Z1.codigo_barra_producto
                FROM producto AS Z1
                INNER JOIN detallecredito AS Z2 ON Z1.codigo_barra_producto = Z2.codigo_barra_producto
                INNER JOIN creditofiscal AS Z3 ON Z3.id_creditofiscal = Z2.id_creditofiscal
                WHERE Z3.fecha_credito <= '$fechaFin'
                GROUP BY Z1.codigo_barra_producto
            ) AS X3"), 'X1.codigo_barra_producto', '=', 'X3.codigo_barra_producto')
            ->where(function ($query) {
                $query->where(DB::raw('COALESCE(X2.total_venta, 0)'), '>', 0)
                    ->orWhere(DB::raw('COALESCE(X3.total_credito, 0)'), '>', 0);
            })            
            ->orderBy('total_producto_vendido', $tipoOrden)
            ->limit($cantidadAMostrar)->get()
            ->paginate($this->numberPaginate);

    }

    public function filtrarPorCantidad($cantidad, $tipoOrden){
    
    }

    public function filtrarPorFechaIncioYFechaFinYCantidad($fechaInicio, $fechaFin, $cantidad, $tipoOrden){

    }

    public function filtrarPorFechaInicioYCantidad($fechaInicio,$cantidad, $tipoOrden){

    }

    public function filtrarPorFechaFinYCantidad($fechaFin,$cantidad, $tipoOrden){

    }

    public function obtenerProductosPorOrden($tipoOrden, $cantidadAMostrar){

        return DB::table('producto as X1')
            ->select(
                'X1.codigo_barra_producto',
                'X1.nombre_producto',
                DB::raw('COALESCE(X2.total_venta, 0) AS total_venta'),
                DB::raw('COALESCE(X3.total_credito, 0) AS total_credito'),
                DB::raw('COALESCE(X2.total_venta, 0) + COALESCE(X3.total_credito, 0) AS total'),
                DB::raw('COALESCE(X2.cantidad_producto, 0) AS total_producto_venta'),
                DB::raw('COALESCE(X3.cantidad_producto_credito, 0) AS cantidad_producto_credito'),
                DB::raw('(COALESCE(X2.cantidad_producto, 0) + COALESCE(X3.cantidad_producto_credito, 0)) AS total_producto_vendido')
            )
            ->leftJoin(DB::raw("(
                SELECT SUM(Y2.subtotal_detalle_venta) AS total_venta,
                       SUM(Y2.cantidad_producto) AS cantidad_producto,
                       Y1.codigo_barra_producto
                FROM producto AS Y1
                INNER JOIN detalleventa AS Y2 ON Y1.codigo_barra_producto = Y2.codigo_barra_producto
                INNER JOIN venta as Y3 ON Y2.id_venta = Y3.id_venta
                GROUP BY Y1.codigo_barra_producto
            ) AS X2"), 'X1.codigo_barra_producto', '=', 'X2.codigo_barra_producto')
            ->leftJoin(DB::raw("(
                SELECT SUM(Z2.subtotal_detalle_credito) AS total_credito,
                       SUM(Z2.cantidad_producto_credito) AS cantidad_producto_credito,
                       Z1.codigo_barra_producto
                FROM producto AS Z1
                INNER JOIN detallecredito AS Z2 ON Z1.codigo_barra_producto = Z2.codigo_barra_producto
                INNER JOIN creditofiscal AS Z3 ON Z3.id_creditofiscal = Z2.id_creditofiscal
                GROUP BY Z1.codigo_barra_producto
                ) AS X3"), 'X1.codigo_barra_producto', '=', 'X3.codigo_barra_producto')
            ->where(function ($query) {
                $query->where(DB::raw('COALESCE(X2.total_venta, 0)'), '>', 0)
                    ->orWhere(DB::raw('COALESCE(X3.total_credito, 0)'), '>', 0);
            })
            ->orderBy('total_producto_vendido', $tipoOrden)
            ->limit($cantidadAMostrar)->get()
            ->paginate($this->numberPaginate);

    }

    public function filtrarPorFechaInicioYFechaFin($fechaInicio, $fechaFin, $tipoOrden, $cantidadAMostrar){
        return DB::table('producto as X1')
            ->select(
                'X1.codigo_barra_producto',
                'X1.nombre_producto',
                DB::raw('COALESCE(X2.total_venta, 0) AS total_venta'),
                DB::raw('COALESCE(X3.total_credito, 0) AS total_credito'),
                DB::raw('COALESCE(X2.total_venta, 0) + COALESCE(X3.total_credito, 0) AS total'),
                DB::raw('COALESCE(X2.cantidad_producto, 0) AS total_producto_venta'),
                DB::raw('COALESCE(X3.cantidad_producto_credito, 0) AS cantidad_producto_credito'),
                DB::raw('(COALESCE(X2.cantidad_producto, 0) + COALESCE(X3.cantidad_producto_credito, 0)) AS total_producto_vendido')
            )
            ->leftJoin(DB::raw("(
                SELECT SUM(Y2.subtotal_detalle_venta) AS total_venta,
                       SUM(Y2.cantidad_producto) AS cantidad_producto,
                       Y1.codigo_barra_producto
                FROM producto AS Y1
                INNER JOIN detalleventa AS Y2 ON Y1.codigo_barra_producto = Y2.codigo_barra_producto
                INNER JOIN venta as Y3 ON Y2.id_venta = Y3.id_venta
                WHERE Y3.fecha_venta BETWEEN '$fechaInicio' AND '$fechaFin'
                GROUP BY Y1.codigo_barra_producto
            ) AS X2"), 'X1.codigo_barra_producto', '=', 'X2.codigo_barra_producto')
            ->leftJoin(DB::raw("(
                SELECT SUM(Z2.subtotal_detalle_credito) AS total_credito,
                       SUM(Z2.cantidad_producto_credito) AS cantidad_producto_credito,
                       Z1.codigo_barra_producto
                FROM producto AS Z1
                INNER JOIN detallecredito AS Z2 ON Z1.codigo_barra_producto = Z2.codigo_barra_producto
                INNER JOIN creditofiscal AS Z3 ON Z3.id_creditofiscal = Z2.id_creditofiscal
                WHERE Z3.fecha_credito BETWEEN '$fechaInicio' AND '$fechaFin'
                GROUP BY Z1.codigo_barra_producto
            ) AS X3"), 'X1.codigo_barra_producto', '=', 'X3.codigo_barra_producto')
            ->where(function ($query) {
                $query->where(DB::raw('COALESCE(X2.total_venta, 0)'), '>', 0)
                    ->orWhere(DB::raw('COALESCE(X3.total_credito, 0)'), '>', 0);
            })            
            ->orderBy('total_producto_vendido', $tipoOrden)
            ->limit($cantidadAMostrar)->get()
            ->paginate($this->numberPaginate);
    }
}