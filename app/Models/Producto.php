<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Nette\Utils\DateTime;                 

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
        'cantidad_producto_fisico',
        'precio_unitario',
        'esta_disponible',
        'foto'
    ];

    protected $appends = [
        'ofertas_vigentes'
    ];

    public function getOfertasVigentesAttribute()
    {
        $fechaActual = new DateTime();
        $ofertas = $this->promocions()->where('fecha_inicio_oferta', '<=', $fechaActual)->where('fecha_fin_oferta', '>=', $fechaActual)->get();
        return $ofertas;
    }


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
    public function updateExistencias(int $cantidad, bool $salida){

        $loteActivo = $this->getLoteActivo();
        if($loteActivo){
            if($salida){
                $this->decrementQuietly('cantidad_producto_disponible', $cantidad);
                if(($loteActivo->cantidad - $cantidad) < 0 ){
                    $diferencia = $cantidad - $loteActivo->cantidad;
                    $loteActivo->cantidad = 0;
                    $loteActivo->update();
                    $loteActivo = $this->getLoteActivo();
                    $loteActivo->decrementQuietly('cantidad',$diferencia);
                }else{
                    $loteActivo->decrementQuietly('cantidad', $cantidad);
                }
            }else{
                $this->incrementQuietly('cantidad_producto_disponible', $cantidad);
                $loteActivo->incrementQuietly('cantidad', $cantidad);
            }
        }else{
            return false;
        }
    }

    public function getLoteActivo(){
        $fechaActual = new DateTime();
        $loteActivo = $this->lotes()->where('fecha_vencimiento','>',$fechaActual)->where('cantidad','>',0)->first();
        if(isset($loteActivo)){
            foreach($this->lotes()->get() as $lote){
                if($lote->fecha_ingreso < $loteActivo->fecha_ingreso and $lote->cantidad > 0 and $fechaActual<$lote->fecha_vencimiento){
                    $loteActivo = $lote;
                }
            }
        }else{
            $loteActivo = false;
        }

        return $loteActivo;
    }

    public function getExistencias(){
        $fechaActual = new DateTime();
        $lotes = $this->lotes()->where('fecha_vencimiento','>',$fechaActual)->where('cantidad','>',0)->get();
        $exitenciasLotes = 0;
        foreach($lotes as $lote){
            $exitenciasLotes += $lote->cantidad;
        }

        if($this->cantidad_producto_disponible != $exitenciasLotes){
            $this->cantidad_producto_disponible = $exitenciasLotes;
            $this->update();
        }

        return $exitenciasLotes;

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

     public function promocions(){
        return $this->hasMany(Promocion::class, 'codigo_barra_producto');
     }
    }
