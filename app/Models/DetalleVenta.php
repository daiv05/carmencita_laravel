<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;


    protected $table = 'detalleventa';


    protected $primaryKey = 'id_detalle_venta';


    public $timestamps = false;


    protected $fillable = [
        'id_venta',
        'codigo_barra_producto',
        'cantidad_producto',
        'subtotal_detalle_venta',
        'descuentos',
    ];

    protected $attributes = [
        'precio_unitario_venta' => 0,
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_barra_producto', 'codigo_barra_producto');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta', 'id_venta');
    }

    public function detalleVenta(){
        return $this->hasMany(DetalleVenta::class);
    }
}
