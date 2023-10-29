<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetalleVentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 3 Detalles de Venta por cada Venta, con datos distintos (id_venta, codigo_barra_producto, cantidad_producto, subtotal_detalle_venta)
        $detalle_ventas = [
           [
                'id_venta' => 1,
                'codigo_barra_producto' => '750894641833',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 10.00,
            ],
            /*[
                'id_venta' => 1,
                'codigo_barra_producto' => '7411001800903',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 10.00,
            ],
            [
                'id_venta' => 1,
                'codigo_barra_producto' => '7411001800903',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 10.00,
            ],*/
            [
                'id_venta' => 2,
                'codigo_barra_producto' => '7411001800903',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 20.00,
            ],
            /*[
                'id_venta' => 2,
                'codigo_barra_producto' => '7411001800903',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 20.00,
            ],
            [
                'id_venta' => 2,
                'codigo_barra_producto' => '7411001800903',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 20.00,
            ],*/
            [
                'id_venta' => 3,
                'codigo_barra_producto' => '7411001800903',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 30.00,
            ],
            /*[
                'id_venta' => 3,
                'codigo_barra_producto' => '1234567890127',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 30.00,
            ],
            [
                'id_venta' => 3,
                'codigo_barra_producto' => '1234567890128',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 30.00,
            ],*/
            [
                'id_venta' => 4,
                'codigo_barra_producto' => '1234567890129',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 40.00,
            ],
            /*[
                'id_venta' => 4,
                'codigo_barra_producto' => '1234567890130',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 40.00,
            ],*/
            [
                'id_venta' => 5,
                'codigo_barra_producto' => '7413100033053',
                'cantidad_producto' => 2,
                'subtotal_detalle_venta' => 55.00,
            ],
            [
                'id_venta' => 6,
                'codigo_barra_producto' => '7413100033053',
                'cantidad_producto' => 3,
                'subtotal_detalle_venta' => 72.50,
            ],
            [
                'id_venta' => 7,
                'codigo_barra_producto' => '7413100033053',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 28.75,
            ],
            [
                'id_venta' => 8,
                'codigo_barra_producto' => '7413100033053',
                'cantidad_producto' => 2,
                'subtotal_detalle_venta' => 45.20,
            ],
            [
                'id_venta' => 9,
                'codigo_barra_producto' => '7413100033053',
                //'codigo_barra_producto' => '1234567890128',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 30.00,
            ],
            [
                'id_venta' => 10,
                'codigo_barra_producto' => '7413100033053',
                'cantidad_producto' => 4,
                'subtotal_detalle_venta' => 60.80,
            ],
            [
                'id_venta' => 11,
                'codigo_barra_producto' => '7413100033053',
                'cantidad_producto' => 2,
                'subtotal_detalle_venta' => 35.00,
            ],
            [
                'id_venta' => 12,
                'codigo_barra_producto' => '7413100033053',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 22.50,
            ],
            [
                'id_venta' => 13,
                'codigo_barra_producto' => '7413100033053',
                'cantidad_producto' => 3,
                'subtotal_detalle_venta' => 48.75,
            ],
            [
                'id_venta' => 14,
                'codigo_barra_producto' => '7413100033053',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 31.20,
            ],
            [
                'id_venta' => 15,
                'codigo_barra_producto' => '7413100033053',
                'cantidad_producto' => 2,
                'subtotal_detalle_venta' => 40.00,
            ],
            [
                'id_venta' => 16,
                'codigo_barra_producto' => '7413100033053',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 18.75,
            ],
            [
                'id_venta' => 17,
                'codigo_barra_producto' => '7413100033053',
                'cantidad_producto' => 2,
                'subtotal_detalle_venta' => 55.20,
            ],
            [
                'id_venta' => 18,
                'codigo_barra_producto' => '7413100033053',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 25.00,
            ],
            [
                'id_venta' => 19,
                'codigo_barra_producto' => '7413100033053',
                'cantidad_producto' => 3,
                'subtotal_detalle_venta' => 52.75,
            ],
            [
                'id_venta' => 20,
                'codigo_barra_producto' => '7413100033053',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 33.60,
                /*'id_venta' => 5,
                'codigo_barra_producto' => '1234567890129',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 40.00,*/
            ],
            /*[
                'id_venta' => 5,
                'codigo_barra_producto' => '1234567890130',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 40.00,
            ],
            [
                'id_venta' => 6,
                'codigo_barra_producto' => '1234567890128',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 30.00,
            ],
            [
                'id_venta' => 6,
                'codigo_barra_producto' => '1234567890129',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 40.00,
            ],
            [
                'id_venta' => 6,
                'codigo_barra_producto' => '1234567890130',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 40.00,
            ],
            [
                'id_venta' => 7,
                'codigo_barra_producto' => '1234567890128',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 30.00,
            ],
            [
                'id_venta' => 7,
                'codigo_barra_producto' => '1234567890129',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 40.00,
            ],
            [
                'id_venta' => 7,
                'codigo_barra_producto' => '1234567890130',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 40.00,
            ],
            [
                'id_venta' => 8,
                'codigo_barra_producto' => '1234567890130',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 40.00,
            ],
            [
                'id_venta' => 8,
                'codigo_barra_producto' => '1234567890128',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 30.00,
            ],
            [
                'id_venta' => 8,
                'codigo_barra_producto' => '1234567890129',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 40.00,
            ],
            [
                'id_venta' => 8,
                'codigo_barra_producto' => '1234567890130',
                'cantidad_producto' => 1,
                'subtotal_detalle_venta' => 40.00,
            ],*/

        ];

        foreach ($detalle_ventas as $detalle_venta) {
            \App\Models\DetalleVenta::create($detalle_venta);
        }
    }
}
