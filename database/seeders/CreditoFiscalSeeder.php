<?php

namespace Database\Seeders;

use App\Models\CreditoFiscal;
use App\Models\DetalleCredito;
use App\Models\Producto;
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
            ],
            [
                'id_cliente' => 2,
                'fecha_credito' => '2023-10-10',
                'total_credito' => 200.00,
                'total_iva_credito' => 23.00,
                'estado_credito' => false,
            ],
            [
                'id_cliente' => 1,
                'fecha_credito' => '2023-10-10',
                'total_credito' => 120.00,
                'total_iva_credito' => 13.50,
                'estado_credito' => false,
            ],
            [
                'id_cliente' => 1,
                'fecha_credito' => '2023-10-10',
                'total_credito' => 100.00,
                'total_iva_credito' => 11.50,
                'estado_credito' => false,
            ],
            [
                'id_cliente' => 2,
                'fecha_credito' => '2023-10-10',
                'total_credito' => 200.00,
                'total_iva_credito' => 23.00,
                'estado_credito' => false,
            ],
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
            CreditoFiscal::create($credito);
        }

        $productos = Producto::all();
        $creditosFiscales = CreditoFiscal::factory()->count(20)->create();
        foreach($creditosFiscales as $venta){
            $totalVenta = 0;
            $detallesVenta = DetalleCredito::factory()->count(3)->for($venta)->for($productos[rand(1,7)])->create();
            foreach($detallesVenta as $detalle){
                $producto = Producto::where('codigo_barra_producto',$detalle->codigo_barra_producto)->first();
                $detalle->subtotal_detalle_credito= $detalle->cantidad_producto_credito* $producto['precio_unitario'];
                $detalle->update();
                $totalVenta += $detalle->subtotal_detalle_credito;
            }

            $venta->total_credito = $totalVenta;
            $venta->total_iva_credito = $totalVenta - ($totalVenta/1.13);
            $venta->update();

        }

    }
}