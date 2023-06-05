<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    protected $table = 'Empleado';
    protected $primaryKey = 'id_empleado';

    protected $fillable = [
        'id_empleado',
        'primer_nombre', 
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'id_sexo',
        'fecha_nacimiento',
        'id_estado_familiar',
        'profesion_oficio',
        'domicilio',
        'residencia',
        'id_nacionalidad',
        'dui_empleado',
        'id_cargo',
        'telefono',
        'esta_activo'
    ];

    

}
