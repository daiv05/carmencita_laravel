<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginacioLoteRecurso extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            "id_lote"=>$this->id_lote,
            "cantidad"=>$this->cantidad,
            "cantidad_total_unidades"=>$this->cantidad_total_unidades,
            "fecha_ingreso"=>$this->fecha_ingreso,
            "fecha_vencimiento"=>$this->fecha_vencimiento,
            "precio_unitario"=>$this->precio_unitario,
            "producto" => $this->producto,
            "costo_total"=>$this->costo_total,
        ];
    }
}
