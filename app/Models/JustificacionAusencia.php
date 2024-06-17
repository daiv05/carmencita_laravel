<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JustificacionAusencia extends Model
{
    use HasFactory;

    protected $table = 'justificacion_ausencias';

    protected $fillable = [
        'id_ausencia',
        'id_estado',
        'id_empleado',
        'fecha_solicitud',
        'justificacion',
        'comprobante'
    ];

    public function ausencia()
    {
        return $this->belongsTo(Ausencia::class, 'id_ausencia');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }
}
