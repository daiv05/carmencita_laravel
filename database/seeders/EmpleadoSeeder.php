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
                'id_nacionalidad' => '1',
                'id_estado_familiar'=> '1',
                'id_sexo' => '1',
                'id_cargo'=> '1',
                'dui_empleado' => '059195851',
                'fecha_nacimiento' => '1998-09-22',
                'telefono' => '77787840',
                'esta_activo' => '1',
                'domicilio' => 'San Salvador',
                'residencia' => 'San Salvador',
                'profesion_oficio'=> 'Contador'
            ],
            [
                'primer_nombre' => 'Carlos',
                'segundo_nombre' => 'Francisco',
                'primer_apellido' => 'Miranda',
                'id_nacionalidad' => '1',
                'id_estado_familiar'=> '1',
                'id_sexo' => '1',
                'id_cargo'=> '1',
                'dui_empleado' => '059195855',
                'fecha_nacimiento' => '1998-09-22',
                'telefono' => '77787841',
                'esta_activo' => '1',
                'domicilio' => 'San Salvador',
                'residencia' => 'San Salvador',
                'profesion_oficio'=> 'Contador'
            ],
            [
                'primer_nombre' => 'Claudia',
                'segundo_nombre' => '',
                'primer_apellido' => 'Guillen',
                'id_nacionalidad' => '1',
                'id_estado_familiar'=> '1',
                'id_sexo' => '1',
                'id_cargo'=> '3',
                'dui_empleado' => '059195866',
                'fecha_nacimiento' => '1998-09-22',
                'telefono' => '77787849',
                'esta_activo' => '1',
                'domicilio' => 'San Salvador',
                'residencia' => 'San Salvador',
                'profesion_oficio'=> 'Empleado'
            ]
        ];
        $usuarios =[
            [
                'email' => 'usuario1@',
                'password'=> 'clave0001',
            ],
            [
                
                'email' => 'usuario2@',
                'password'=> 'clave0001',   
            ],
            [
                
                'email' => 'usuario3@',
                'password'=> 'clave0001',   
            ]
        ];
        $i =0;
        foreach($empleados as $empleado){
            $miEmpleado = Empleado::create($empleado);
            
            $user = User::create([
                'id_empleado' => $miEmpleado->id_empleado,
                'name' => $miEmpleado->primer_nombre,
                'email' => $usuarios[$i]['email'],
                'password' => Hash::make($usuarios[$i]['password'])
            ]);
            $i++;
        }
    }
}
