<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'Producto';
    protected $primaryKey = 'codigo_barra_producto';
    public $timestamps = false;

    protected $fillable = [
        'codigo_barra_producto', // Primary key
        'nombre_producto',
        'cantidad_producto_disponible',
        'precio_unitario',
        'esta_disponible',
    ];
}
