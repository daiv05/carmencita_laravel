<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecioUnidadDeMedida extends Model
{
    use HasFactory;

    protected $table = 'preciounidaddemedida';


    protected $primaryKey = 'id_precio_unidad_de_medida';


    public $timestamps = false;


    protected $fillable = [
        'codigo_barra_producto',
        'id_unidad_de_medida',
        'cantidad_producto',
        'precio_unidad_medida_producto',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_barra_producto', 'codigo_barra_producto');
    }

    public function unidadDeMedida()
    {
        return $this->belongsTo(UnidadDeMedida::class, 'id_unidad_de_medida', 'id_unidad_de_medida');
    }
}
