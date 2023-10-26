<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    use HasFactory;

    protected $table = 'abonos';

    protected $fillable = [
        'monto',
        'fecha',
        'id_credito'
    ];

    public $timestamps = false;

    public function credito(){
        return $this->hasOne(Credito::class,'id_credito');
    }

}
