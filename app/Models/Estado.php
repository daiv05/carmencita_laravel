<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estados';

    protected $fillable = [
        'nombre'
    ];

    public function justificacionAusencias()
    {
        return $this->hasMany(JustificacionAusencia::class, 'id_estado');
    }

    public function ausencias()
    {
        return $this->hasMany(Ausencia::class, 'id_estado');
    }
}
