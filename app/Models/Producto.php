<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


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
}
