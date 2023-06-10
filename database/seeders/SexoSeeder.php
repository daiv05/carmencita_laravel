<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SexoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sexos = [
            [
                'nombre_sexo' => "Masculino"
            ],
            [
                'nombre_sexo' => "Femenino"
            ]
        ];

        foreach ($sexos as $sexo) {
            \App\Models\Sexo::create($sexo);
        }
    }
}
