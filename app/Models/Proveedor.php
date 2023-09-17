<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = "proveedors";

    protected $fillable = ['nombre_proveedor'];

    public function ceditos(){
        return $this->hasMany(Credito::class, 'id_proveedor');
    }
}
