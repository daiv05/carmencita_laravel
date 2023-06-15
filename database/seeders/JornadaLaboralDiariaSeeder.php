<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JornadaLaboralDiariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jornadas = [
            [
                'hora_inicio' =>'08:00:00',
                'hora_fin'=>'18:00:00',
            ],
        ];

        foreach ($jornadas as $jornada) {
            \App\Models\JornadaLaboralDiaria::create($jornada);
        }
    }
}
