<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ausencia;

class AusenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ausencias = [
            [
                'id_empleado' => 2,
                'fecha_ausencia' => '2024-06-15',
            ],
            [
                'id_empleado' => 3,
                'fecha_ausencia' => '2024-06-15',
            ],
            [
                'id_empleado' => 4,
                'fecha_ausencia' => '2024-06-15',
            ],
            [
                'id_empleado' => 5,
                'fecha_ausencia' => '2024-06-15',
            ],
            [
                'id_empleado' => 2,
                'fecha_ausencia' => '2024-06-18',
            ],
            [
                'id_empleado' => 3,
                'fecha_ausencia' => '2024-06-18',
            ],
            [
                'id_empleado' => 4,
                'fecha_ausencia' => '2024-06-18',
            ],
            [
                'id_empleado' => 5,
                'fecha_ausencia' => '2024-06-18',
            ],
        ];

        foreach ($ausencias as $ausencia){
            Ausencia::create($ausencia);
        }
    }
}
