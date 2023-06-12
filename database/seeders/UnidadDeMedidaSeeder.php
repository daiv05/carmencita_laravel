<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\UnidadDeMedida;

class UnidadDeMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
