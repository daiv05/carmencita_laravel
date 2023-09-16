<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetalleCreditoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 3 Detalles de Credito por cada Credito, con datos distintos (id_creditofiscal, codigo_barra_producto, cantidad_producto, subtotal_detalle_credito)
        $detalle_creditos = [
            [
                'id_creditofiscal' => 1,
                'codigo_barra_producto' => '1234567890128',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 10.00,
            ],
            [
                'id_creditofiscal' => 1,
                'codigo_barra_producto' => '1234567890129',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 10.00,
            ],
            [
                'id_creditofiscal' => 1,
                'codigo_barra_producto' => '7411001800903',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 10.00,
            ],
            [
                'id_creditofiscal' => 2,
                'codigo_barra_producto' => '7411001800903',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 20.00,
            ],
            [
                'id_creditofiscal' => 2,
                'codigo_barra_producto' => '1234567890129',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 20.00,
            ],
            [
                'id_creditofiscal' => 2,
                'codigo_barra_producto' => '1234567890128',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 20.00,
            ],
            [
                'id_creditofiscal' => 3,
                'codigo_barra_producto' => '1234567890129',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 30.00,
            ],
            [
                'id_creditofiscal' => 3,
                'codigo_barra_producto' => '7411001800903',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 30.00,
            ],
            [
                'id_creditofiscal' => 3,
                'codigo_barra_producto' => '1234567890128',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 30.00
            ],
            [
                'id_creditofiscal' => 4,
                'codigo_barra_producto' => '1234567890129',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 40.00,
            ],
            [
                'id_creditofiscal' => 5,
                'codigo_barra_producto' => '1234567890129',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 30.00,
            ],
            [
                'id_creditofiscal' => 5,
                'codigo_barra_producto' => '7411001800903',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 30.00,
            ],
            [
                'id_creditofiscal' => 5,
                'codigo_barra_producto' => '1234567890128',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 30.00
            ],
            [
                'id_creditofiscal' => 6,
                'codigo_barra_producto' => '1234567890129',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 30.00,
            ],
            [
                'id_creditofiscal' => 6,
                'codigo_barra_producto' => '7411001800903',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 30.00,
            ],
            [
                'id_creditofiscal' => 6,
                'codigo_barra_producto' => '1234567890128',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 30.00
            ],
            [
                'id_creditofiscal' => 7,
                'codigo_barra_producto' => '1234567890129',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 30.00,
            ],
            [
                'id_creditofiscal' => 7,
                'codigo_barra_producto' => '7411001800903',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 30.00,
            ],
            [
                'id_creditofiscal' => 7,
                'codigo_barra_producto' => '1234567890128',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 30.00
            ],
            [
                'id_creditofiscal' => 8,
                'codigo_barra_producto' => '1234567890129',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 30.00,
            ],
            [
                'id_creditofiscal' => 8,
                'codigo_barra_producto' => '7411001800903',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 30.00,
            ],
            [
                'id_creditofiscal' => 8,
                'codigo_barra_producto' => '1234567890128',
                'cantidad_producto_credito' => 1,
                'subtotal_detalle_credito' => 30.00
            ],
        ];

        foreach ($detalle_creditos as $detalle_credito) {
            \App\Models\DetalleCredito::create($detalle_credito);
        }
    }
}
