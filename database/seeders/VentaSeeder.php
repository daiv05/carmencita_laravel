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
        $productos = Producto::all();
        $productoCodes = $productos->pluck('codigo_barra_producto')->toArray();
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
                'total_venta' => 0,
                'total_iva' => 0,
                'nombre_cliente_venta' => 'Cliente 5'
            ],
            [
                'fecha_venta' => '2021-01-03',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2021-02-15',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2021-03-22',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2021-04-10',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2021-05-05',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2021-06-18',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2021-07-09',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2021-08-28',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2021-09-14',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2021-10-20',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2021-11-07',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2021-12-12',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2022-01-25',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2022-02-08',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2022-03-30',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2022-04-19',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2022-05-06',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2022-06-28',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2022-07-15',
                'total_venta' => 0,
                'total_iva' => 0,
            ],
            [
                'fecha_venta' => '2022-08-22',
                'total_venta' => 0,
                'total_iva' => 0,
            ],    
            //pedidos
            [
                'fecha_venta' => '2023-10-10',
                'total_venta' => 0,
                'total_iva' => 0,
                'nombre_cliente_venta' => 'Luis',
                'estado_venta' => false,
                'domicilio' => true,
            ],
            [
                'fecha_venta' => '2023-10-10',
                'total_venta' => 0,
                'total_iva' =>0,
                'nombre_cliente_venta' => 'Pedro',
                'estado_venta' => false,
                'domicilio' => true,
            ],
            [
                'fecha_venta' => '2023-10-10',
                'total_venta' => 0,
                'total_iva' => 0,
                'nombre_cliente_venta' => 'Maria',
                'estado_venta' => false,
                'domicilio' => true,
            ],
        ];

        foreach ($ventas as $venta) {
            Venta::create($venta);
        }

        // Crear ventas adicionales
        $ventasAdicionales = Venta::factory()->count(20)->create();
        
        // Todas las ventas (manuales + adicionales)
        $todasVentas = Venta::all();

        foreach ($todasVentas as $venta) {
            $totalVenta = 0;
            $detalles = [];

            // Crear 3 detalles por venta
            for ($i = 0; $i < 3; $i++) {
                $producto = $productos->random();
                $cantidad = rand(1, 5);
                $subtotal = $cantidad * $producto->precio_unitario;

                $detalles[] = [
                    'id_venta' => $venta->id_venta,
                    'codigo_barra_producto' => $producto->codigo_barra_producto,
                    'cantidad_producto' => $cantidad,
                    'subtotal_detalle_venta' => $subtotal,
                ];

                $totalVenta += $subtotal;
            }

            // Crear los detalles
            DetalleVenta::insert($detalles);

            // Actualizar totales de la venta
            $venta->total_venta = $totalVenta;
            $venta->total_iva = $totalVenta - ($totalVenta / 1.13);
            $venta->save();
        }

    }
}
