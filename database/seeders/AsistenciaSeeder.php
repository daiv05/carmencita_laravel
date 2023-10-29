<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asistencias = [];
        
        for ($i = 1; $i <= 31; $i++) {
            array_push($asistencias,['id_empleado'=>1,'fecha'=>'2023-08-'.$i]);
            array_push($asistencias,['id_empleado'=>2,'fecha'=>'2023-08-'.$i]);
            array_push($asistencias,['id_empleado'=>3,'fecha'=>'2023-08-'.$i]);
            array_push($asistencias,['id_empleado'=>4,'fecha'=>'2023-08-'.$i]);
        }

        for ($i = 1; $i <= 30; $i++) {
            array_push($asistencias,['id_empleado'=>1,'fecha'=>'2023-09-'.$i]);
            array_push($asistencias,['id_empleado'=>2,'fecha'=>'2023-09-'.$i]);
            array_push($asistencias,['id_empleado'=>3,'fecha'=>'2023-09-'.$i]);
            array_push($asistencias,['id_empleado'=>4,'fecha'=>'2023-09-'.$i]);
        }

        foreach ($asistencias as $asistencia) {
            \App\Models\Asistencia::create($asistencia);
        }
    }
}
