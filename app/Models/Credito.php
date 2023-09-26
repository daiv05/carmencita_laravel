<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    use HasFactory;

    protected $table = "creditos";

    protected $fillable = ['fecha_credito', 'fecha_limite_pago', 'monto_credito', 'detalle_credito', 'id_proveedor', 'pendiente'];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }
    public function isPagado()
    {
        return $this->pendiente == 0 ? true : false;
    }
    public function abonos()
    {
        return $this->hasMany(Abono::class, 'id_credito');
    }

    public function updateMontoPendiente($monto)
    {
        if ($monto > $this->pendiente) {
            return false;
        } else {
            $this->pendiente -= $monto;
            $this->save();
            return true;
        }

    }
}