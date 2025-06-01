<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run(): void
    { 
        $clientes = [
            [
                'nombre_cliente' => 'María Guadalupe Martínez',
                'direccion_cliente' => 'Colonia Escalón, Calle Las Camelias #25',
                'dui_cliente' => '04568923-5',
                'nit_cliente' => '0614-121289-102-5',
                'nrc_cliente' => '987654-1',
                'id_municipio' => 6, // San Salvador
                'distintivo_cliente' => 'MG_Martinez',
            ],
            [
                'nombre_cliente' => 'Carlos Antonio Rodríguez',
                'direccion_cliente' => 'Residencial Las Cascadas, Casa #12',
                'dui_cliente' => '05623478-1',
                'nit_cliente' => '0614-342356-103-6',
                'nrc_cliente' => '876543-2',
                'id_municipio' => 6, // San Salvador
                'distintivo_cliente' => 'CA_Rodriguez',
            ],
            [
                'nombre_cliente' => 'Ana Patricia López',
                'direccion_cliente' => 'Colonia San Benito, Pasaje 3 #44',
                'dui_cliente' => '02345678-9',
                'nit_cliente' => '0614-567834-104-7',
                'nrc_cliente' => '765432-3',
                'id_municipio' => 6, // San Salvador
                'distintivo_cliente' => 'AP_Lopez',
            ],
            [
                'nombre_cliente' => 'José Miguel Flores',
                'direccion_cliente' => 'Urbanización Valle Verde, Block 5 Apt 302',
                'dui_cliente' => '06789123-4',
                'nit_cliente' => '0614-789012-105-8',
                'nrc_cliente' => '654321-4',
                'id_municipio' => 7, // Acajutla
                'distintivo_cliente' => 'JM_Flores',
            ],
            [
                'nombre_cliente' => 'Sofía Alejandra Ramírez',
                'direccion_cliente' => 'Colonia Médica, Polígono D #16',
                'dui_cliente' => '07891234-5',
                'nit_cliente' => '0614-890123-106-9',
                'nrc_cliente' => '543210-5',
                'id_municipio' => 8, // Armenia
                'distintivo_cliente' => 'SA_Ramirez',
            ],
            [
                'nombre_cliente' => 'Luis Fernando Hernández',
                'direccion_cliente' => 'Residencial Los Pinos, Casa #8',
                'dui_cliente' => '08912345-6',
                'nit_cliente' => '0614-901234-107-0',
                'nrc_cliente' => '432109-6',
                'id_municipio' => 6, // San Salvador
                'distintivo_cliente' => 'LF_Hernandez',
            ],
            [
                'nombre_cliente' => 'Gabriela Beatriz Castro',
                'direccion_cliente' => 'Colonia Flor Blanca, 1a Calle Poniente #321',
                'dui_cliente' => '09123456-7',
                'nit_cliente' => '0614-012345-108-1',
                'nrc_cliente' => '321098-7',
                'id_municipio' => 6, // San Salvador
                'distintivo_cliente' => 'GB_Castro',
            ],
            [
                'nombre_cliente' => 'Roberto Carlos Méndez',
                'direccion_cliente' => 'Colonia Miramonte, Pasaje Los Geranios #7',
                'dui_cliente' => '01234567-8',
                'nit_cliente' => '0614-123456-109-2',
                'nrc_cliente' => '210987-8',
                'id_municipio' => 9, // Caluco
                'distintivo_cliente' => 'RC_Mendez',
            ],
        ];
        
        foreach ($clientes as $cliente) {
            Cliente::firstOrCreate(
                ['distintivo_cliente' => $cliente['distintivo_cliente']],
                $cliente
            );
        }
    }
}