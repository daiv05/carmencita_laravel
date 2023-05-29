<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;


    protected $table = 'Cliente';


    protected $primaryKey = 'id_cliente';


    public $timestamps = false;


    protected $fillable = [
        'nombre_cliente',
        'apellido_cliente',
        'departamento_cliente',
        'direccion_cliente',
        'dui_cliente',
        'nit_cliente',
        'nrc_cliente',
    ];

    public function creditoFiscal()
    {
        return $this->hasMany(CreditoFiscal::class, 'id_cliente', 'id_cliente');
    }
}
