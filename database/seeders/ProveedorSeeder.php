<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $prov = [
            [
                'nombre_proveedor' => 'Carmen Camisas s.a de cv',
                'nit_pr' => '1856-153556-153-3',
                'nrc_pr' => '123456-1',
                'estado_pr' => 1,
            ],
            [
                'nombre_proveedor' => 'Pedro fashion',
                'nit_pr' => '5489-785623-456-7',
                'nrc_pr' => '753159-2',
                'estado_pr' => 1,
            ],
            [
                'nombre_proveedor' => 'Rosario boutique',
                'nit_pr' => '457812-456123-785-3',
                'nrc_pr' => '852741-3',
                'estado_pr' => 1,
            ],
            [
                'nombre_proveedor' => 'New Ale',
                'nit_pr' => '456123-789456-159-4',
                'nrc_pr' => '123456-4',
                'estado_pr' => 1,
            ],
            [
                'nombre_proveedor' => 'Estilo S.A DE C.V',
                'nit_pr' => '458745-123789-456-5',
                'nrc_pr' => '423785-5',
                'estado_pr' => 1,
            ]
        ];

        foreach ($prov as $p) {
            \App\Models\Proveedor::firstOrCreate(
                ['nit_pr' => $p['nit_pr']], // condición para no repetir
                $p
            );
        }
    }
}
