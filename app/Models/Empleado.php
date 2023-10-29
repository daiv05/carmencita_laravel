<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    protected $table = 'empleado';
    protected $primaryKey = 'id_empleado';

    protected $fillable = [
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

    public function nacionalidad(){
        return $this->belongsTo(Nacionalidad::class,"id_nacionalidad","id_nacionalidad");
    }
    
    public function estadoFamiliar(){
        return $this->belongsTo(EstadoFamiliar::class,"id_estado_familiar","id_estado_familiar");
    }
    public function sexo(){
        return $this->belongsTo(Sexo::class,"id_sexo","id_sexo");
    }
    public function cargo(){
        return $this->belongsTo(Cargo::class,"id_cargo","id_cargo");
    }
    public function user(){
        return $this->belongsTo(User::class,"id_empleado","id_empleado");
    }
    public function asistencia(){
        return $this->hasMany(Asistencia::class,'id_empleado');
    }

    public function getRol(){
        $cargo = $this->cargo()->first();
        if($cargo->nombre_cargo == "Gerente" || $cargo->nombre_cargo == "Sub-Gerente"){
            return $cargo->nombre_cargo;
        } else {
            return "Colaborador";
        }
    }
}
