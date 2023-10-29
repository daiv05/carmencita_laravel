<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;


    protected $table = 'cliente';


    protected $primaryKey = 'id_cliente';


    public $timestamps = false;


    protected $fillable = [
        'distintivo_cliente',
        'nombre_cliente',
        'direccion_cliente',
        'dui_cliente',
        'nit_cliente',
        'nrc_cliente',
        'id_municipio',
        'distintivo_cliente',
        'estado_cliente'
    ];

    public function creditoFiscal()
    {
        return $this->hasMany(CreditoFiscal::class, 'id_cliente', 'id_cliente');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio', 'id_municipio');
    }
}
