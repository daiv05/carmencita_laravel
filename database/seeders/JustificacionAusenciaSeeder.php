<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JustificacionAusencia;

class JustificacionAusenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $justificaciones = [
            [
                'id_ausencia' => 1,
                'id_estado' => 1,
                'id_empleado' => 2,
                'fecha_solicitud' => '2024-06-16',
                'justificacion' => 'me dormi1111',
            ],
            [
                'id_ausencia' => 2,
                'id_estado' => 1,
                'id_empleado' => 3,
                'fecha_solicitud' => '2024-06-16',
                'justificacion' => 'me dormi2222',
            ],
            [
                'id_ausencia' => 3,
                'id_estado' => 1,
                'id_empleado' => 4,
                'fecha_solicitud' => '2024-06-16',
                'justificacion' => 'me dormi3333',
            ],
            [
                'id_ausencia' => 4,
                'id_estado' => 1,
                'id_empleado' => 5,
                'fecha_solicitud' => '2024-06-16',
                'justificacion' => 'me dormi4444',
            ],
            [
                'id_ausencia' => 5,
                'id_estado' => 1,
                'id_empleado' => 2,
                'fecha_solicitud' => '2024-06-19',
                'justificacion' => 'me dormi5555',
            ],
            [
                'id_ausencia' => 6,
                'id_estado' => 1,
                'id_empleado' => 3,
                'fecha_solicitud' => '2024-06-19',
                'justificacion' => 'me dormi6666',
            ],
            [
                'id_ausencia' => 7,
                'id_estado' => 1,
                'id_empleado' => 4,
                'fecha_solicitud' => '2024-06-19',
                'justificacion' => 'me dormi7777',
            ],
            [
                'id_ausencia' => 8,
                'id_estado' => 1,
                'id_empleado' => 5,
                'fecha_solicitud' => '2024-06-19',
                'justificacion' => 'me dormi8888',
            ],

        ];

        foreach ($justificaciones as $justificacion) {
            JustificacionAusencia::create($justificacion);
        }
    }
}
