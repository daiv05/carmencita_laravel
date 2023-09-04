<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreditoFiscalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $creditos = [
            [
                'id_cliente' => 1,
                'fecha_credito' => '2023-10-10',
                'total_credito' => 100.00,
                'total_iva_credito' => 11.50,
                'estado_credito' => false,
                'domicilio' => true,
            ],
            [
                'id_cliente' => 2,
                'fecha_credito' => '2023-10-10',
                'total_credito' => 200.00,
                'total_iva_credito' => 23.00,
                'estado_credito' => false,
                'domicilio' => true,
            ],
            [
                'id_cliente' => 1,
                'fecha_credito' => '2023-10-10',
                'total_credito' => 120.00,
                'total_iva_credito' => 13.50,
                'estado_credito' => false,
                'domicilio' => true,
            ],
        ];

        foreach ($creditos as $credito) {
            \App\Models\CreditoFiscal::create($credito);
        }
    }
}