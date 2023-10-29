<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditoFiscal extends Model
{
    use HasFactory;


    protected $table = 'creditofiscal';


    protected $primaryKey = 'id_creditofiscal';


    public $timestamps = false;


    protected $fillable = [
        'id_cliente',
        'fecha_credito',
        'total_credito',
        'total_iva_credito',
        'estado_credito',
        'domicilio'
    ];

    protected $atrbutes = [
        'estado_credito' => true,
        'domicilio' => false,
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function detalleCredito()
    {
        return $this->hasMany(DetalleCredito::class, 'id_creditofiscal', 'id_creditofiscal');
    }

    public function creditoFiscalDomicilio(){
        return $this->hasOne(CreditoFiscalDomicilio::class,'id_creditofiscal', 'id_creditofiscal');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }
    
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}
