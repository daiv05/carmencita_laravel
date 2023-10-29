<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;


    protected $table = 'venta';


    protected $primaryKey = 'id_venta';


    public $timestamps = false;


    protected $fillable = [
        'fecha_venta',
        'total_venta',
        'total_iva',
        'nombre_cliente_venta',
        'estado_venta',
        'domicilio'
    ];

    protected $attributes = [
        'estado_venta' => true,
        'domicilio' => false,
    ];

    public function detalleVenta()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta', 'id_venta');
    }

    public function ventaDomicilio(){
        return $this->hasOne(VentaDomicilio::class, 'id_venta', 'id_venta');
    }
    


}
