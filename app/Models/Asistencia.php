<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'hoja_asistencia_id',
        'id_empleado',
        'fecha'
    ];

    public function hojaAsistencia(){
        return $this->BelongsTo(HojaAsistencia::class,'hoja_asistencia_id','id');
    }

    public function empleado(){
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id_empleado');
    }
}
