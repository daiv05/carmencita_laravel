<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePlanilla extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_empleado',
        'id_planilla',
        'base',
        'monto_isss',
        'monto_afp',
        'monto_pago',
        'dias_laborados'
    ];

    public function empleado(){
        return $this->belongsTo(Empleado::class,'id_empleado','id_empleado');
    }

    public function planilla(){
        return $this->belongsTo(Planilla::class, 'id_planilla', 'id');
    }

}
