<?php
namespace App\Filtros;
use App\Filtros\InterfazFiltroHistorialVentasProducto;
use Illuminate\Support\Facades\DB;

class FiltroHistorialVentasProducto implements InterfazFiltroHistorialVentasProducto{

    private $numberPaginate;

    public function __construct($numberPaginate=7){
        $this->numberPaginate = $numberPaginate;
    }
    
    public function filtrarPorFechaInicio($fechaInicioVenta)
    {
        $respuesta =  DB::table('producto as X1')->select(
            'X1.codigo_barra_producto',
            'X1.nombre_producto',
            DB::raw('COALESCE(X2.total_venta, 0) AS total_venta'),
            DB::raw('COALESCE(X3.total_credito, 0) AS total_credito'),
            DB::raw('(COALESCE(X2.total_venta, 0) + COALESCE(X3.total_credito, 0)) AS total'),
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
            INNER JOIN venta AS Y3 ON Y2.id_venta = Y3.id_venta
            WHERE Y3.fecha_venta >= '$fechaInicioVenta'
            GROUP BY Y1.codigo_barra_producto
        ) AS X2"), 'X1.codigo_barra_producto', '=', 'X2.codigo_barra_producto')
        ->leftJoin(DB::raw("(
            SELECT SUM(Z2.subtotal_detalle_credito) AS total_credito,
                   SUM(Z2.cantidad_producto_credito) AS cantidad_producto_credito,
                   Z1.codigo_barra_producto
            FROM producto AS Z1
            INNER JOIN detallecredito AS Z2 ON Z1.codigo_barra_producto = Z2.codigo_barra_producto
            INNER JOIN creditofiscal AS Z3 ON Z3.id_creditofiscal = Z2.id_creditofiscal
            WHERE Z3.fecha_credito >= '$fechaInicioVenta'
            GROUP BY Z1.codigo_barra_producto
        ) AS X3"), 'X1.codigo_barra_producto', '=', 'X3.codigo_barra_producto')
        ->where(function ($query) {
            $query->where(DB::raw('COALESCE(X2.total_venta, 0)'), '>', 0)
                ->orWhere(DB::raw('COALESCE(X3.total_credito, 0)'), '>', 0);
        });
        return $respuesta->paginate($this->numberPaginate);
    }


    public function filtrarPorFechaFin($fechaFinVenta)
    {
        $respuesta = DB::table('producto as X1')
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
            WHERE Y3.fecha_venta <= '$fechaFinVenta'
            GROUP BY Y1.codigo_barra_producto
        ) AS X2"), 'X1.codigo_barra_producto', '=', 'X2.codigo_barra_producto')
        ->leftJoin(DB::raw("(
            SELECT SUM(Z2.subtotal_detalle_credito) AS total_credito,
                   SUM(Z2.cantidad_producto_credito) AS cantidad_producto_credito,
                   Z1.codigo_barra_producto
            FROM producto AS Z1
            INNER JOIN detallecredito AS Z2 ON Z1.codigo_barra_producto = Z2.codigo_barra_producto
            INNER JOIN creditofiscal AS Z3 ON Z3.id_creditofiscal = Z2.id_creditofiscal
            WHERE Z3.fecha_credito <= '$fechaFinVenta'
            GROUP BY Z1.codigo_barra_producto
        ) AS X3"), 'X1.codigo_barra_producto', '=', 'X3.codigo_barra_producto')
        ->where(function ($query) {
            $query->where(DB::raw('COALESCE(X2.total_venta, 0)'), '>', 0)
                ->orWhere(DB::raw('COALESCE(X3.total_credito, 0)'), '>', 0);
        });

        return $respuesta->paginate($this->numberPaginate);
    }

    public function filtrarPorFechaIncioYFechaFin($fechaInicioVenta, $fechaFinVenta)
    {
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
            WHERE Y3.fecha_venta BETWEEN '$fechaInicioVenta' AND '$fechaFinVenta'
            GROUP BY Y1.codigo_barra_producto
        ) AS X2"), 'X1.codigo_barra_producto', '=', 'X2.codigo_barra_producto')
        ->leftJoin(DB::raw("(
            SELECT SUM(Z2.subtotal_detalle_credito) AS total_credito,
                   SUM(Z2.cantidad_producto_credito) AS cantidad_producto_credito,
                   Z1.codigo_barra_producto
            FROM producto AS Z1
            INNER JOIN detallecredito AS Z2 ON Z1.codigo_barra_producto = Z2.codigo_barra_producto
            INNER JOIN creditofiscal AS Z3 ON Z3.id_creditofiscal = Z2.id_creditofiscal
            WHERE Z3.fecha_credito BETWEEN '$fechaInicioVenta' AND '$fechaFinVenta'
            GROUP BY Z1.codigo_barra_producto
        ) AS X3"), 'X1.codigo_barra_producto', '=', 'X3.codigo_barra_producto')
        ->where(function ($query) {
            $query->where(DB::raw('COALESCE(X2.total_venta, 0)'), '>', 0)
                ->orWhere(DB::raw('COALESCE(X3.total_credito, 0)'), '>', 0);
        })->paginate($this->numberPaginate);
    }

    public function filtrarPorMinimoIngresoProducto($minTotal){
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
        ->havingRaw("total >= '$minTotal'")
        ->paginate($this->numberPaginate);
    }

    public function filtrarPorMaximoIngresoProducto($maxTotal){
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
        ->havingRaw("total <= '$maxTotal'")
        ->paginate($this->numberPaginate);
    }

    public function filtrarPorMinimoYMaximoIngresoProducto($minIngreso, $maxIngreso)
    {
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
        ->havingRaw("total BETWEEN '$minIngreso' AND '$maxIngreso'")
        ->paginate($this->numberPaginate);
    }

    public function filtrarPorMinimoCantidadProducto($minTotalProductoVendido)
    {
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
            ->havingRaw("total_producto_vendido >= '$minTotalProductoVendido'")
            ->paginate($this->numberPaginate);
    }
    public function filtrarPorMaximoCantidadProducto($maxCantidadProducto)
    {
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
        ->havingRaw("total_producto_vendido <= '$maxCantidadProducto'")
        ->paginate($this->numberPaginate);
    }

    public function filtrarPorMinimioYMaximoCantidadProducto($minCantidadProducto,$maxCantidadProducto)
    {
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
        ->havingRaw("total_producto_vendido BETWEEN '$minCantidadProducto' AND '$maxCantidadProducto'")
        ->paginate($this->numberPaginate);
    }

}

