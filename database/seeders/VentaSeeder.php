<?php

namespace Database\Seeders;

use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Venta;
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
           /* [
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
            ],*/
            [
                'fecha_venta' => '2021-01-05',
                'total_venta' => 50.00,
                'total_iva' => 5.00,
                'nombre_cliente_venta' => 'Cliente 5'
            ],
            [
                'fecha_venta' => '2021-01-03',
                'total_venta' => 30.00,
                'total_iva' => 3.00,
            ],
            [
                'fecha_venta' => '2021-02-15',
                'total_venta' => 45.00,
                'total_iva' => 4.50,
            ],
            [
                'fecha_venta' => '2021-03-22',
                'total_venta' => 62.80,
                'total_iva' => 6.28,
            ],
            [
                'fecha_venta' => '2021-04-10',
                'total_venta' => 28.75,
                'total_iva' => 2.87,
            ],
            [
                'fecha_venta' => '2021-05-05',
                'total_venta' => 55.20,
                'total_iva' => 5.52,
            ],
            [
                'fecha_venta' => '2021-06-18',
                'total_venta' => 70.50,
                'total_iva' => 7.05,
            ],
            [
                'fecha_venta' => '2021-07-09',
                'total_venta' => 42.10,
                'total_iva' => 4.21,
            ],
            [
                'fecha_venta' => '2021-08-28',
                'total_venta' => 38.25,
                'total_iva' => 3.83,
            ],
            [
                'fecha_venta' => '2021-09-14',
                'total_venta' => 52.70,
                'total_iva' => 5.27,
            ],
            [
                'fecha_venta' => '2021-10-20',
                'total_venta' => 29.80,
                'total_iva' => 2.98,
            ],
            [
                'fecha_venta' => '2021-11-07',
                'total_venta' => 64.90,
                'total_iva' => 6.49,
            ],
            [
                'fecha_venta' => '2021-12-12',
                'total_venta' => 47.60,
                'total_iva' => 4.76,
            ],
            [
                'fecha_venta' => '2022-01-25',
                'total_venta' => 33.40,
                'total_iva' => 3.34,
            ],
            [
                'fecha_venta' => '2022-02-08',
                'total_venta' => 51.25,
                'total_iva' => 5.13,
            ],
            [
                'fecha_venta' => '2022-03-30',
                'total_venta' => 26.70,
                'total_iva' => 2.67,
            ],
            [
                'fecha_venta' => '2022-04-19',
                'total_venta' => 59.90,
                'total_iva' => 5.99,
            ],
            [
                'fecha_venta' => '2022-05-06',
                'total_venta' => 37.20,
                'total_iva' => 3.72,
            ],
            [
                'fecha_venta' => '2022-06-28',
                'total_venta' => 44.60,
                'total_iva' => 4.46,
            ],
            [
                'fecha_venta' => '2022-07-15',
                'total_venta' => 63.80,
                'total_iva' => 6.38,
            ],
            [
                'fecha_venta' => '2022-08-22',
                'total_venta' => 48.90,
                'total_iva' => 4.89,
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
            Venta::create($venta);
        }

        $productos = Producto::all();
        $ventas = Venta::factory()->count(20)->create();
        foreach($ventas as $venta){
            $totalVenta = 0;
            $detallesVenta = DetalleVenta::factory()->count(3)->for($venta)->for($productos[rand(1,7)])->create();
            foreach($detallesVenta as $detalle){
                $producto = Producto::where('codigo_barra_producto',$detalle->codigo_barra_producto)->first();
                $detalle->subtotal_detalle_venta = $detalle->cantidad_producto * $producto['precio_unitario'];
                $detalle->update();
                $totalVenta += $detalle->subtotal_detalle_venta;
            }

            $venta->total_venta = $totalVenta;
            $venta->total_iva = $totalVenta - ($totalVenta/1.13);
            $venta->update();

        }

    }
}
