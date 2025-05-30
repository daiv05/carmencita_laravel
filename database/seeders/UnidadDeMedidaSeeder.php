<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\UnidadDeMedida;

class UnidadDeMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $unidad_de_medida = [
            // Para venta al detalle
            [
                'nombre_unidad_de_medida' => 'Unidad'
            ],
            [
                'nombre_unidad_de_medida' => 'Par'
            ],

            // Para venta al por mayor
            [
                'nombre_unidad_de_medida' => 'Docena'
            ],
            [
                'nombre_unidad_de_medida' => 'Media Docena'
            ],
            [
                'nombre_unidad_de_medida' => 'Paquete'
            ],
            [
                'nombre_unidad_de_medida' => 'Caja'
            ],
            [
                'nombre_unidad_de_medida' => 'Bulto'
            ],
            [
                'nombre_unidad_de_medida' => 'Saco'
            ],
        ];


        foreach ($unidad_de_medida as $unidad) {
            UnidadDeMedida::create($unidad);
        }
    }
}
