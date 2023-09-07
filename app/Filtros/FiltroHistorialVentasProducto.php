<?php
namespace App\Filtros;
use App\Filtros\InterfazFiltroHistorialVentasProducto;
use Countable;
use Illuminate\Support\Facades\DB;

class FiltroHistorialVentasProducto implements InterfazFiltroHistorialVentasProducto{

    private $numberPaginate;

    public function __construct($numberPaginate=7){
        $this->numberPaginate = $numberPaginate;
    }
    
    public function obtenerTodos()
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
        ->paginate($this->numberPaginate);
    }

    public function filtroFechaIncioValorVentasCantidades($fechaInicioVenta,$minTotal,$maxTotal,$minTotalProducto,$maxTotalProducto)
    {
            $condiciones = $this->obtenerCondiciones($minTotal,$maxTotal,$minTotalProducto,$maxTotalProducto);
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
            })
            ->having(function($query) use ($condiciones){
                foreach($condiciones as $condicion){
                    $query->havingRaw($condicion);
                }
            })
            //->havingRaw("total BETWEEN  '$minTotal' AND '$maxTotal'")
            //->havingRaw("total_producto_vendido BETWEEN '$minTotalProducto' AND '$maxTotalProducto'")
            ->paginate($this->numberPaginate);
        
    }
    public function filtroFechaFinValorVentasCantidades($fechaFinVenta,$minTotal,$maxTotal,$minTotalProducto,$maxTotalProducto)
    {
        $condiciones = $this->obtenerCondiciones($minTotal,$maxTotal,$minTotalProducto,$maxTotalProducto);
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
        })
        ->having(function($query) use ($condiciones){
            foreach($condiciones as $condicion){
                $query->havingRaw($condicion);
            }
        })
        //->havingRaw("total BETWEEN  '$minTotal' AND '$maxTotal'")
        //->havingRaw("total_producto_vendido BETWEEN '$minTotalProducto' AND '$maxTotalProducto'")
        ->paginate($this->numberPaginate);
    }
    public function filtroFechasValorVentasCantidades($fechaInicioVenta,$fechaFinVenta,$minTotal,$maxTotal,$minTotalProducto,$maxTotalProducto)
    {
        DB::table('producto as X1')
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
            })
            ->havingRaw("total BETWEEN  '$minTotal' AND '$maxTotal'")
            ->havingRaw("total_producto_vendido BETWEEN '$minTotalProducto' AND '$maxTotalProducto'")
            ->paginate($this->numberPaginate);
    }

    public function filtrarPorValorVentasCantidades($minTotal, $maxTotal, $minTotalProducto, $maxTotalProducto)
    {
        $condiciones = $this->obtenerCondiciones($minTotal,$maxTotal,$minTotalProducto,$maxTotalProducto);
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
        ->having(function($query) use ($condiciones){
            foreach($condiciones as $condicion){
                $query->havingRaw($condicion);
            }
        })
        //->havingRaw("total BETWEEN  '$minTotal' AND '$maxTotal'")
        //->havingRaw("total_producto_vendido BETWEEN '$minTotalProducto' AND '$maxTotalProducto'")
        ->paginate($this->numberPaginate);
    }

    public function filtrarPorFechaInicio($fechaInicioVenta){
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
        })
        ->paginate($this->numberPaginate);
    }

    public function filtrarPorFechaFin($fechaFinVenta){
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
        })
        ->paginate($this->numberPaginate);
    }

    public function filtrarPorFechas($fechaInicioVenta,$fechaFinVenta){
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
        })
        ->paginate($this->numberPaginate);
    }

    public function obtenerCondiciones($minTotal,$maxTotal,$minTotalProducto,$maxTotalProducto) : array{
        $condiciones = [];
        if (!is_null($minTotal) && !is_null($maxTotal) && !is_null($minTotalProducto) && !is_null($maxTotalProducto)) {
            $condiciones[] = "total BETWEEN  '$minTotal' AND '$maxTotal'";
            $condiciones[] = "total_producto_vendido BETWEEN '$minTotalProducto' AND '$maxTotalProducto'";
           // $query->whereRaw("total BETWEEN  '$minTotal' AND '$maxTotal'");
            //$query->whereRaw("total_producto_vendido BETWEEN '$minTotalProducto' AND '$maxTotalProducto'");
        }
        else if(!is_null($minTotal) && !is_null($maxTotal) && !is_null($maxTotalProducto)){
            $condiciones[] = "total BETWEEN  '$minTotal' AND '$maxTotal'";
            $condiciones[] = "total_producto_vendido <= '$maxTotalProducto'";
            //$query->whereRaw("total BETWEEN  '$minTotal' AND '$maxTotal'");
            //$query->whereRaw("total_producto_vendido <= '$maxTotalProducto'");
        }
        else if(!is_null($minTotal) && !is_null($maxTotal) && !is_null($minTotalProducto)){
            $condiciones[] = "total BETWEEN  '$minTotal' AND '$maxTotal'";
            $condiciones[] = "total_producto_vendido >= '$minTotalProducto'";
            //$query->whereRaw("total BETWEEN  '$minTotal' AND '$maxTotal'");
            //$query->whereRaw("total_producto_vendido >= '$minTotalProducto'");
        }
        else if(!is_null($minTotal) && !is_null($minTotalProducto) && !is_null($maxTotalProducto)){
            $condiciones[] = "total >=  '$minTotal'";
            $condiciones[] = "total_producto_vendido BETWEEN '$minTotalProducto' AND '$maxTotalProducto'";
            //$query->whereRaw("total >=  '$minTotal'");
            //$query->whereRaw("total_producto_vendido BETWEEN '$minTotalProducto' AND '$maxTotalProducto'");
        }
        else if(!is_null($maxTotal) && !is_null($minTotalProducto) && !is_null($maxTotalProducto)){
            $condiciones[] = "total <=  '$maxTotal'";
            $condiciones[] = "total_producto_vendido BETWEEN '$minTotalProducto' AND '$maxTotalProducto'";
            //$query->whereRaw("total <=  '$maxTotal'");
            //$query->whereRaw("total_producto_vendido BETWEEN '$minTotalProducto' AND '$maxTotalProducto'");
        }
        else if(!is_null($minTotal) && !is_null($maxTotal)){
            $condiciones[] = "total BETWEEN  '$minTotal' AND '$maxTotal'";
            //$query->whereRaw("total BETWEEN  '$minTotal' AND '$maxTotal'");
        }
        else if(!is_null($minTotal) && !is_null($minTotalProducto)){
            $condiciones[] = "total >= '$minTotal'";
            $condiciones[] = "total_producto_vendido >= '$minTotalProducto'";
            //$query->whereRaw("total >= '$minTotal'");
            //$query->whereRaw("total_producto_vendido >= '$minTotalProducto'");
        }
        else if(!is_null($minTotal) && !is_null($maxTotalProducto)){
            $condiciones[] = "total >= '$minTotal'";
            $condiciones[] = "total_producto_vendido <= '$maxTotalProducto'";
            //$query->whereRaw("total >= '$minTotal'");
            //$query->whereRaw("total_producto_vendido <= '$maxTotalProducto'");
        }
        else if(!is_null($maxTotal) && !is_null($minTotalProducto)){
            $condiciones[] = "total <= '$maxTotal'";
            $condiciones[] = "total_producto_vendido >= '$minTotalProducto'";
            //$query->whereRaw("total <= '$maxTotal'");
            //$query->whereRaw("total_producto_vendido >= '$minTotalProducto'");
        }
        else if(!is_null($maxTotal) && !is_null($maxTotalProducto)){
            $condiciones[] = "total <= '$maxTotal'";
            $condiciones[] = "total_producto_vendido <= '$maxTotalProducto'";
            //$query->whereRaw("total <= '$maxTotal'");
            //$query->whereRaw("total_producto_vendido <= '$maxTotalProducto'");
        }
        else if(!is_null($minTotalProducto) && !is_null($maxTotalProducto)){
            $condiciones[] = "total_producto_vendido BETWEEN '$minTotalProducto' AND '$maxTotalProducto'";
            //$query->whereRaw("total_producto_vendido BETWEEN '$minTotalProducto' AND '$maxTotalProducto'");
        }
        else if(!is_null($minTotal)){
            $condiciones[] = "total >= '$minTotal'";
            //$query->whereRaw("total >= '$minTotal'");
        }
        else if(!is_null($maxTotal)){
            $condiciones[] = "total <= '$maxTotal'";
           // $query->whereRaw("total <= '$maxTotal'");
        }
        else if(!is_null($minTotalProducto)){
            $condiciones[] = "total_producto_vendido >='$minTotalProducto'";
           // $query->whereRaw("total_producto_vendido >='$minTotalProducto'");
        }
        else if(!is_null($maxTotalProducto)){
            $condiciones[] = "total_producto_vendido <='$maxTotalProducto'";
           // $query->whereRaw("total_producto_vendido <='$maxTotalProducto'");
        }
        return $condiciones;
    }
    
    

}

