<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HojaDeRuta extends Model
{
    use HasFactory;
    protected $table = 'hojaderuta';
    protected $primaryKey = 'id_hr';

    protected $fillable = [
        'fecha_entrega',
        'id_empleado',
        'total'
    ];

    public function creditoFiscalDomicilio(){
        return $this->hasMany(CreditoFiscalDomicilio::class, 'id_hr', 'id_hr');
    }

    public function ventaDomicilio(){
        return $this->hasMany(VentaDomicilio::class,'id_hr', 'id_hr');
    }

    public function empleado(){
        return $this->belongsTo(Empleado::class,'id_empleado', 'id_empleado');
    }


}
