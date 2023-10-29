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
                'nombre_proveedor' => 'Proveedor 1',
                'nit_pr' => '1234-123456-123-1',
                'nrc_pr' => '123456-1',
                'estado_pr' => 1,
            ],
            [
                'nombre_proveedor' => 'Proveedor 2',
                'nit_pr' => '1234-123456-123-2',
                'nrc_pr' => '123456-2',
                'estado_pr' => 1,
            ],
            [
                'nombre_proveedor' => 'Proveedor 3',
                'nit_pr' => '1234-123456-123-3',
                'nrc_pr' => '123456-3',
                'estado_pr' => 1,
            ],
            [
                'nombre_proveedor' => 'Proveedor 4',
                'nit_pr' => '1234-123456-123-4',
                'nrc_pr' => '123456-4',
                'estado_pr' => 1,
            ],
            [
                'nombre_proveedor' => 'Proveedor 5',
                'nit_pr' => '1234-123456-123-5',
                'nrc_pr' => '123456-5',
                'estado_pr' => 1,
            ],
            [
                'nombre_proveedor' => 'Proveedor 6',
                'nit_pr' => '1234-123456-123-6',
                'nrc_pr' => '123456-6',
                'estado_pr' => 1,
            ],
            [
                'nombre_proveedor' => 'Proveedor 7',
                'nit_pr' => '1234-123456-123-7',
                'nrc_pr' => '123456-7',
                'estado_pr' => 1,
            ],
            [
                'nombre_proveedor' => 'Proveedor 8',
                'nit_pr' => '1234-123456-123-8',
                'nrc_pr' => '123456-8',
                'estado_pr' => 1,
            ],
            [
                'nombre_proveedor' => 'Proveedor 9',
                'nit_pr' => '1234-123456-123-9',
                'nrc_pr' => '123456-9',
                'estado_pr' => 1,
            ],
            [
                'nombre_proveedor' => 'Proveedor 10',
                'nit_pr' => '1234-123456-123-10',
                'nrc_pr' => '123456-10',
                'estado_pr' => 1,
            ]
        ];

        foreach ($prov as $p) {
            \App\Models\Proveedor::create($p);
        }
    }
}
