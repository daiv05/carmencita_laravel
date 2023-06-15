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
                'nombre_cliente' => 'Juan Perez',
                'direccion_cliente' => 'Av Universitaria',
                'dui_cliente' => '12345678-9',
                'nit_cliente' => '1234-567890-123-4',
                'nrc_cliente' => '123456-7',
                'id_municipio' => 1,
                'distintivo_cliente' => 'Hotel la Ola',
            ],
            [
                'nombre_cliente' => 'Maria Belle',
                'direccion_cliente' => 'Blvd Constitucion',
                'dui_cliente' => '12345678-9',
                'nit_cliente' => '1234-567890-123-4',
                'nrc_cliente' => '123456-7',
                'id_municipio' => 2,
                'distintivo_cliente' => 'La Costeña',
            ],
        ];
        
        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}

