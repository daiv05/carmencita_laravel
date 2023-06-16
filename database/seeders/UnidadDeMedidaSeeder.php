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

        // Crear registros de unidades de medida
        UnidadDeMedida::create([
            'nombre_unidad_medida' => 'Tira'
        ]);

        UnidadDeMedida::create([
            'nombre_unidad_medida' => 'Caja'
        ]);

        UnidadDeMedida::create([
            'nombre_unidad_medida' => 'Bolsa'
        ]);

        //

        $unidadDeMedida = [
            [
                'nombre_unidad_de_medida' => 'Tira',
            ],
            [
                'nombre_unidad_de_medida' => 'Caja',
            ]
        ];

        foreach ($unidadDeMedida as $unidad) {
            UnidadDeMedida::create($unidad);
        }

    }
}
