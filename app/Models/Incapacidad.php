<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incapacidad extends Model
{
    use HasFactory;

    protected $table = 'incapacidades';

    protected $fillable = [
        'id_empleado',
        'fecha_solicitud',
        'fecha_inicio',
        'fecha_fin',
        'id_estado',
        'comprobante',
        'detalle'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }
}
