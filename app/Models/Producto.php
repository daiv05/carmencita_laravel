<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';


    protected $primaryKey = 'codigo_barra_producto';


    public $timestamps = false;
    

    protected $fillable = [
        'codigo_barra_producto',
        'nombre_producto',
        'cantidad_producto_disponible',
        'precio_unitario',
        'esta_disponible',
        'foto'
    ];


    public function detalleCredito()
    {
        return $this->hasMany(DetalleCredito::class, 'codigo_barra_producto', 'codigo_barra_producto');
    }

    public function detalleVenta()
    {
        return $this->hasMany(DetalleVenta::class, 'codigo_barra_producto', 'codigo_barra_producto');
    }

    public function precioUnidadDeMedida()
    {
        return $this->hasMany(PrecioUnidadDeMedida::class, 'codigo_barra_producto', 'codigo_barra_producto');
    }

    public function lotes(): HasMany
    {
        return $this->hasMany(Lote::class,'codigo_barra_producto','codigo_barra_producto');
    }
    
    public static function obtenerProductosConTotales($fechaInicioVenta, $fechaFinVenta, $minTotal, $maxTotal, $minTotalProductoVendido, $maxTotalProductoVendido)
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
            })
            ->havingRaw("total BETWEEN  '$minTotal' AND '$maxTotal'")
            ->havingRaw("total_producto_vendido BETWEEN '$minTotalProductoVendido' AND '$maxTotalProductoVendido'")
            ->paginate(10);
     }

     public function promocion(){
        return $this->hasMany(Promocion::class, 'codigo_barra_producto');
     }
    }
