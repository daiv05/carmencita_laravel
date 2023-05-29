<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        //
        $clientes = [
            [
                'nombre_cliente' => 'Juan',
                'apellido_cliente' => 'Perez',
                'departamento_cliente' => 'San Salvador',
                'direccion_cliente' => 'Av Universitaria',
                'dui_cliente' => '12345678-9',
                'nit_cliente' => '1234-567890-123-4',
                'nrc_cliente' => '123456-7',
            ],
            [
                'nombre_cliente' => 'Maria',
                'apellido_cliente' => 'Lopez',
                'departamento_cliente' => 'San Salvador',
                'direccion_cliente' => 'Blvd Constitucion',
                'dui_cliente' => '12345678-9',
                'nit_cliente' => '1234-567890-123-4',
                'nrc_cliente' => '123456-7',
            ],
            [
                'nombre_cliente' => 'Jose',
                'apellido_cliente' => 'Martinez',
                'departamento_cliente' => 'Chalatenango',
                'direccion_cliente' => 'Chalatenango',
                'dui_cliente' => '12345678-9',
                'nit_cliente' => '1234-567890-123-4',
                'nrc_cliente' => '123456-7',
            ],
            [
                'nombre_cliente' => 'Pedro',
                'apellido_cliente' => 'Garcia',
                'departamento_cliente' => 'San Salvador',
                'direccion_cliente' => 'Ciudad Merliot',
                'dui_cliente' => '12345678-9',
                'nit_cliente' => '1234-567890-123-4',
                'nrc_cliente' => '123456-7',
            ],
            [
                'nombre_cliente' => 'Ana',
                'apellido_cliente' => 'Hernandez',
                'departamento_cliente' => 'La Libertad',
                'direccion_cliente' => 'Santa Tecla',
                'dui_cliente' => '12345678-9',
                'nit_cliente' => '1234-567890-123-4',
                'nrc_cliente' => '123456-7',
            ],
        ];
        
        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}

