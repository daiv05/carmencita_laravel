<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecioUnidadDeMedida extends Model
{
    use HasFactory;

    protected $table = 'PrecioUnidadDeMedida';
    protected $primaryKey = 'id_precio_unidad_de_medida';
    //protected $primaryKey = ['codigo_barra_producto', 'id_unidad_de_medida'];
    public $timestamps = false;

    protected $fillable = [
        'codigo_barra_producto', // Foreign key
        'id_unidad_de_medida', // Foreign key
        'cantidad_producto',
        'precio_unidad_medida_producto',
    ];
}
