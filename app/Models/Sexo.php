<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    use HasFactory;

    protected $table = 'sexo';
    protected $primaryKey = 'id_sexo';
    public $timestamps = false;

    protected $fillable = [
        'id_sexo',
        'nombre_sexo'
    ];

}
