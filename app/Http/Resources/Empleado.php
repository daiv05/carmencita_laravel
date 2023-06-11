<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\PostResource;
class Empleado extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "data" => $this->collection->map(function($empleado){
                return[
                    "id_empleado" => $empleado->id_empleado,
                    "estado_empleado" => $empleado->esta_activo,
                    "primer_nombre" => $empleado->primer_nombre,
                    "segundo_nombre" => $empleado->segundo_nombre,
                    "primer_apellido" => $empleado->primer_apellido,
                    "segundo_apellido" => $empleado->segundo_apellido,
                    "username" => $empleado->User->name,
                    "cargo" => $empleado->Cargo->nombre_cargo,
                ];
            }),
        ];
    }
}
