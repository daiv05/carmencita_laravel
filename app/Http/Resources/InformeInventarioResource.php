<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InformeInventarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return[
            "codigo_barra_producto"=>$this->codigo_barra_producto,
            "nombre_producto"=>$this->nombre_producto,
            "cantidad_producto"=>$this->cantidad_producto_disponible,
            "valor_en_dolares"=>round($this->precio_unitario*$this->cantidad_producto_disponible,2),
        ];
    }
}
