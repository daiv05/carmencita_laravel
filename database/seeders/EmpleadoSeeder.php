<?php

namespace Database\Seeders;

use App\Models\Empleado;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empleados = [
            [
                'primer_nombre' => 'Luis',
                'segundo_nombre' => 'Francisco',
                'primer_apellido' => 'Rivas',
                'segundo_apellido' => 'Moz',
                'id_nacionalidad' => '1',
                'id_estado_familiar' => '1',
                'id_sexo' => '1',
                'id_cargo' => '1',
                'dui_empleado' => '059195851',
                'fecha_nacimiento' => '1998-09-22',
                'telefono' => '77787840',
                'esta_activo' => '1',
                'domicilio' => 'San Salvador',
                'residencia' => 'San Salvador',
                'profesion_oficio' => 'Contador'
            ],
            [
                'primer_nombre' => 'Teobaldo',
                'segundo_nombre' => 'Antonio',
                'primer_apellido' => 'Azahar',
                'segundo_apellido' => 'Roldán',
                'id_nacionalidad' => '1',
                'id_estado_familiar' => '1',
                'id_sexo' => '1',
                'id_cargo' => '2',
                'dui_empleado' => '059135866',
                'fecha_nacimiento' => '1998-09-22',
                'telefono' => '77787849',
                'esta_activo' => '1',
                'domicilio' => 'San Salvador',
                'residencia' => 'San Salvador',
                'profesion_oficio' => 'Empleado'
            ],
            [
                'primer_nombre' => 'Leonardo',
                'segundo_nombre' => 'Efigenio',
                'primer_apellido' => 'Landaverde',
                'id_nacionalidad' => '1',
                'id_estado_familiar' => '1',
                'id_sexo' => '1',
                'id_cargo' => '3',
                'dui_empleado' => '059195546',
                'fecha_nacimiento' => '1998-09-22',
                'telefono' => '77787849',
                'esta_activo' => '1',
                'domicilio' => 'San Salvador',
                'residencia' => 'San Salvador',
                'profesion_oficio' => 'Empleado'
            ],
            [
                'primer_nombre' => 'Gabriela',
                'segundo_nombre' => 'Stefani',
                'primer_apellido' => 'Miranda',
                'segundo_apellido' => 'Mejía',
                'id_nacionalidad' => '1',
                'id_estado_familiar' => '1',
                'id_sexo' => '1',
                'id_cargo' => '4',
                'dui_empleado' => '059198766',
                'fecha_nacimiento' => '1998-09-22',
                'telefono' => '77787849',
                'esta_activo' => '1',
                'domicilio' => 'San Salvador',
                'residencia' => 'San Salvador',
                'profesion_oficio' => 'Empleado'
            ],
            [
                'primer_nombre' => 'David',
                'segundo_nombre' => 'Alejandro',
                'primer_apellido' => 'Deras',
                'segundo_apellido' => 'Cerros',
                'id_nacionalidad' => '1',
                'id_estado_familiar' => '1',
                'id_sexo' => '1',
                'id_cargo' => '4',
                'dui_empleado' => '003595855',
                'fecha_nacimiento' => '1998-09-22',
                'telefono' => '77787841',
                'esta_activo' => '1',
                'domicilio' => 'San Salvador',
                'residencia' => 'San Salvador',
                'profesion_oficio' => 'Contador'
            ]
        ];
        foreach ($empleados as $empleado) {
           Empleado::create($empleado);
        }
    }
}