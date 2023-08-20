<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
        'total_seguro',
        'total_afp',
        'total'
    ];

    protected $attributes = [
        'total_seguro' => 0,
        'total_afp'=> 0,
        'total' =>0
    ];

    public function detallesPlanilla(){
        return $this->hasMany(DetallePlanilla::class,'id_planilla');
    } 

}
