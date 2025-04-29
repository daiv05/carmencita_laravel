<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Incapacidad;

class IncapacidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $incapacidades = [
            [
                'id_empleado' => 2,
                'fecha_inicio' => '2024-06-22',
                'fecha_fin' => '2024-06-25',
                'id_estado' => 1,
                'fecha_solicitud' => '2024-06-15',
                'detalle' => 'Dolor de cabeza1111',
            ],
            [
                'id_empleado' => 3,
                'fecha_inicio' => '2024-06-22',
                'fecha_fin' => '2024-06-25',
                'id_estado' => 1,
                'fecha_solicitud' => '2024-06-15',
                'detalle' => 'Dolor de cabeza22222',
            ],
            [
                'id_empleado' => 4,
                'fecha_inicio' => '2024-06-22',
                'fecha_fin' => '2024-06-25',
                'id_estado' => 1,
                'fecha_solicitud' => '2024-06-15',
                'detalle' => 'Dolor de cabeza33333',
            ],
            [
                'id_empleado' => 5,
                'fecha_inicio' => '2024-06-22',
                'fecha_fin' => '2024-06-25',
                'id_estado' => 1,
                'fecha_solicitud' => '2024-06-15',
                'detalle' => 'Dolor de cabeza44444',
            ],
            [
                'id_empleado' => 2,
                'fecha_inicio' => '2024-06-10',
                'fecha_fin' => '2024-06-11',
                'id_estado' => 1,
                'fecha_solicitud' => '2024-06-09',
                'detalle' => 'Dolor de cabeza55555',
            ],
            [
                'id_empleado' => 3,
                'fecha_inicio' => '2024-06-10',
                'fecha_fin' => '2024-06-11',
                'id_estado' => 1,
                'fecha_solicitud' => '2024-06-09',
                'detalle' => 'Dolor de cabeza66666',
            ],
            [
                'id_empleado' => 4,
                'fecha_inicio' => '2024-06-10',
                'fecha_fin' => '2024-06-11',
                'id_estado' => 1,
                'fecha_solicitud' => '2024-06-09',
                'detalle' => 'Dolor de cabeza77777',
            ],
            [
                'id_empleado' => 5,
                'fecha_inicio' => '2024-06-10',
                'fecha_fin' => '2024-06-11',
                'id_estado' => 1,
                'fecha_solicitud' => '2024-06-09',
                'detalle' => 'Dolor de cabeza88888',
            ],
        ];

        foreach ($incapacidades as $incapacidad) {
            Incapacidad::create($incapacidad);
        }
    }
}
