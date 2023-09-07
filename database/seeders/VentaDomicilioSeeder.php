<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VentaDomicilioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $domicilio = [
            [
                'id_hr' => 1,
                'id_venta' => 6,
                'esta_cancelada' => false,
                'esta_emitida' => false
            ],
            [
                'id_hr' => 1,
                'id_venta' => 7,
                'esta_cancelada' => false,
                'esta_emitida' => false
            ],
            [
                'id_hr' => 1,
                'id_venta' => 8,
                'esta_cancelada' => false,
                'esta_emitida' => false
            ],
            [
                'id_hr' => 2,
                'id_venta' => 6,
                'esta_cancelada' => false,
                'esta_emitida' => false
            ],
            [
                'id_hr' => 2,
                'id_venta' => 7,
                'esta_cancelada' => false,
                'esta_emitida' => false
            ],
            [
                'id_hr' => 2,
                'id_venta' => 8,
                'esta_cancelada' => false,
                'esta_emitida' => false
            ],
            [
                'id_hr' => 3,
                'id_venta' => 6,
                'esta_cancelada' => false,
                'esta_emitida' => false
            ],
            [
                'id_hr' => 3,
                'id_venta' => 7,
                'esta_cancelada' => false,
                'esta_emitida' => false
            ],
            [
                'id_hr' => 3,
                'id_venta' => 8,
                'esta_cancelada' => false,
                'esta_emitida' => false
            ],
        ];

        foreach ($domicilio as $dom) {
            \App\Models\VentaDomicilio::create($dom);
        }
    }
}
