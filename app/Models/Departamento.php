<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;


    protected $table = 'departamento';


    protected $primaryKey = 'id_departamento';


    public $timestamps = false;


    protected $fillable = [
        'nombre_departamento'
    ];

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'id_departamento', 'id_departamento');
    }
}
