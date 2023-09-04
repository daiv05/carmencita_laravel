<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 5 Ventas, con datos distintos
        $ventas = [
            [
                'fecha_venta' => '2021-01-01',
                'total_venta' => 10.00,
                'total_iva' => 1.00,
                'nombre_cliente_venta' => 'Cliente 1'
            ],
            [
                'fecha_venta' => '2021-01-02',
                'total_venta' => 20.00,
                'total_iva' => 2.00,
                'nombre_cliente_venta' => 'Cliente 2'
            ],
            [
                'fecha_venta' => '2021-01-03',
                'total_venta' => 30.00,
                'total_iva' => 3.00,
            ],
            [
                'fecha_venta' => '2021-01-04',
                'total_venta' => 40.00,
                'total_iva' => 4.00,
            ],
            [
                'fecha_venta' => '2021-01-05',
                'total_venta' => 50.00,
                'total_iva' => 5.00,
                'nombre_cliente_venta' => 'Cliente 5'
            ],
            //pedidos
            [
                'fecha_venta' => '2023-10-10',
                'total_venta' => 50.00,
                'total_iva' => 5.00,
                'nombre_cliente_venta' => 'Luis',
                'estado_venta' => false,
                'domicilio' => true,
            ],
            [
                'fecha_venta' => '2023-10-10',
                'total_venta' => 100.00,
                'total_iva' =>13.00,
                'nombre_cliente_venta' => 'Pedro',
                'estado_venta' => false,
                'domicilio' => true,
            ],
            [
                'fecha_venta' => '2023-10-10',
                'total_venta' => 50.00,
                'total_iva' => 5.00,
                'nombre_cliente_venta' => 'Maria',
                'estado_venta' => false,
                'domicilio' => true,
            ],
        ];

        foreach ($ventas as $venta) {
            \App\Models\Venta::create($venta);
        }
    }
}
