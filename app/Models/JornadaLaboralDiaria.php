<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JornadaLaboralDiaria extends Model
{
    use HasFactory;


    protected $table = 'jornadalaboraldiaria';


    protected $primaryKey = 'id_jornada_laboral_diaria';


    public $timestamps = false;
    
    
    protected $fillable = [
        'hora_inicio',
        'hora_fin',
    ];
}
