<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PrecioUnidadDeMedida;

class PrecioUnidadDeMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $precio_unidad_de_medida = [
            [
                'precio_unidad_medida_producto' => 3.00,
                'id_unidad_de_medida' => 1,
                'codigo_barra_producto' => "750894641833",
                'cantidad_producto' => 3,
            ],
            [
                'precio_unidad_medida_producto' => 17.00,
                'id_unidad_de_medida' => 2,
                'codigo_barra_producto' => "750894641833",
                'cantidad_producto' => 18,
            ],
            [
                'precio_unidad_medida_producto' => 10.90,
                'id_unidad_de_medida' => 2,
                'codigo_barra_producto' => "7411001800903",
                'cantidad_producto' => 6,
            ],
            [
                'precio_unidad_medida_producto' => 12.80,
                'id_unidad_de_medida' => 2,
                'codigo_barra_producto' => "7411001802341",
                'cantidad_producto' => 12,
            ],
            [
                'precio_unidad_medida_producto' => 39.00,
                'id_unidad_de_medida' => 2,
                'codigo_barra_producto' => "7413100033053",
                'cantidad_producto' => 20,
            ]
        ];

        foreach ($precio_unidad_de_medida as $precio) {
            PrecioUnidadDeMedida::create($precio);
        }

    }
}
