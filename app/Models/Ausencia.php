<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ausencia extends Model
{
    use HasFactory;

    protected $table = 'ausencias';

    protected $fillable = [
        'id_empleado',
        'fecha_ausencia'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function justificacionAusencia()
    {
        return $this->hasOne(JustificacionAusencia::class, 'id_ausencia');
    }
}
