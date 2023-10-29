<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lote extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = "id_lote";
    public function producto(): BelongsTo
    {
        //return $this->belongsTo(Post::class, 'foreign_key');
        return $this->belongsTo(Producto::class,"codigo_barra_producto");
    }
}
