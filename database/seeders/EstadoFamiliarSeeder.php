<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoFamiliarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            [
                'nombre_estado_familiar' => 'soltero(a)',
            ],
            [
                'nombre_estado_familiar' => 'casado(a)'
            ]
            ];

        foreach ($estados as $estado) {
            \App\Models\EstadoFamiliar::create($estado);
        }
    }
}
