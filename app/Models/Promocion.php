<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    use HasFactory;

    protected $table = 'promocions';

    protected $fillable = ['codigo_barra_producto','fecha_inicio_oferta','fecha_fin_oferta','precio_oferta','nombre_oferta'];
    
    public function producto(){
        return $this->belongsTo(Producto::class, 'codigo_barra_producto');
    }
}
