<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDomicilio extends Model
{
    use HasFactory;

    protected $table = 'ventadomicilio';

    protected $primaryKey = 'id_vd';

    protected $fillable = [
        'id_hr',
        'id_venta',
        'esta_cancelada',
        'esta_emitida'
    ];
    protected $attributes = [
        'esta_cancelada'=> false,
        'esta_emitida' => false
    ];

    public function hojaDeRuta(){
        return $this->belongsTo(HojaDeRuta::class,'id_hr', 'id_hr');
    }

    public function venta(){
        return $this->belongsTo(Venta::class,'id_venta', 'id_venta');
    }
}
