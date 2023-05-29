<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadDeMedida extends Model
{
    use HasFactory;

    protected $table = 'UnidadDeMedida';


    protected $primaryKey = 'id_unidad_de_medida';


    public $timestamps = false;
    

    protected $fillable = [
        'id_unidad_de_medida',
        'nombre_unidad_de_medida',
    ];

    public function precioUnidadDeMedida()
    {
        return $this->hasMany(PrecioUnidadDeMedida::class, 'id_unidad_de_medida', 'id_unidad_de_medida');
    }
}
