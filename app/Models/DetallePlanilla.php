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
        'dias_laborados',
        'monto_vacaciones',
        'monto_aguinaldo',
        'monto_bonos',
        'monto_isss_patronal',
        'monto_afp_patronal',
        'monto_gravable_cotizable',
        'monto_pago_empleado',
        'monto_planilla_unica',
        'date_emision_boleta',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id_empleado');
    }

    public function planilla()
    {
        return $this->belongsTo(Planilla::class, 'id_planilla', 'id');
    }

}
