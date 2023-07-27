<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;


    protected $table = 'cargo';


    protected $primaryKey = 'id_cargo';


    public $timestamps = false;

    
    protected $fillable = [
        "id_jornada_laboral_diaria", 
        "nombre_cargo",
        "salario_cargo",
        "descripcion_cargo"
    ];
}
