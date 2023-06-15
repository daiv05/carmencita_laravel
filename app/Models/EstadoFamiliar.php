<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoFamiliar extends Model
{
    use HasFactory;

    protected $table = 'EstadoFamiliar';
    protected $primaryKey = 'id_estado_familiar';

    protected $fillable = [
        'nombre_estado_familiar'
    ];

}
