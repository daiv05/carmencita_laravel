<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditoFiscalDomicilio extends Model
{
    use HasFactory;

    protected $table = 'creditofiscaldomicilio';
    protected $primaryKey = 'id_cfd';

    protected $fillable = [
        'id_hr',
        'id_creditofiscal',
        'esta_cancelado',
        'esta_emitido'
    ];

    protected $attributes = [
        'esta_cancelado'=> false,
        'esta_emitido' => false
    ];

    public function creditoFiscal(){
        return $this->belongsTo(CreditoFiscal::class, 'id_creditofiscal','id_creditofiscal');
    }

    public function hojaDeRuta(){
        return $this->belongsTo(HojaDeRuta::class, 'id_hr','id_hr');
    }

}
