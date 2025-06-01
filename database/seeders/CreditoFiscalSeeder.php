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
        $productos = Producto::all();
        $productoCodes = $productos->pluck('codigo_barra_producto')->toArray();
        
        // Créditos manuales con totales en 0
        $creditos = [
            [
                'id_cliente' => 1,
                'fecha_credito' => '2025-10-10',
                'total_credito' => 0,
                'total_iva_credito' => 0,
                'estado_credito' => false,
            ],
            [
                'id_cliente' => 2,
                'fecha_credito' => '2025-10-10',
                'total_credito' => 200.00,
                'total_iva_credito' => 23.00,
                'estado_credito' => false,
            ],
            [
                'id_cliente' => 1,
                'fecha_credito' => '2025-10-10',
                'total_credito' => 120.00,
                'total_iva_credito' => 13.50,
                'estado_credito' => false,
            ],
            [
                'id_cliente' => 1,
                'fecha_credito' => '2025-10-10',
                'total_credito' => 100.00,
                'total_iva_credito' => 11.50,
                'estado_credito' => false,
            ],
            [
                'id_cliente' => 2,
                'fecha_credito' => '2025-10-10',
                'total_credito' => 200.00,
                'total_iva_credito' => 23.00,
                'estado_credito' => false,
            ],
            [
                'id_cliente' => 1,
                'fecha_credito' => '2025-10-10',
                'total_credito' => 100.00,
                'total_iva_credito' => 11.50,
                'estado_credito' => false,
                'domicilio' => true,
            ],
            [
                'id_cliente' => 2,
                'fecha_credito' => '2024-10-10',
                'total_credito' => 200.00,
                'total_iva_credito' => 23.00,
                'estado_credito' => false,
                'domicilio' => true,
            ],
            [
                'id_cliente' => 1,
                'fecha_credito' => '2024-10-10',
                'total_credito' => 0,
                'total_iva_credito' => 0,
                'estado_credito' => false,
                'domicilio' => true,
            ],
        ];

        foreach ($creditos as $credito) {
            CreditoFiscal::create($credito);
        }

        // Créditos adicionales
        $creditosAdicionales = CreditoFiscal::factory()->count(20)->create();
        
        // Todos los créditos
        $todosCreditos = CreditoFiscal::all();

        foreach ($todosCreditos as $credito) {
            $totalCredito = 0;
            $detalles = [];

            // Crear 3 detalles por crédito
            for ($i = 0; $i < 3; $i++) {
                $producto = $productos->random();
                $cantidad = rand(1, 5);
                $subtotal = $cantidad * $producto->precio_unitario;

                $detalles[] = [
                    'id_creditofiscal' => $credito->id_creditofiscal,
                    'codigo_barra_producto' => $producto->codigo_barra_producto,
                    'cantidad_producto_credito' => $cantidad,
                    'subtotal_detalle_credito' => $subtotal,
                ];

                $totalCredito += $subtotal;
            }

            // Crear los detalles
            DetalleCredito::insert($detalles);

            // Actualizar totales
            $credito->total_credito = $totalCredito;
            $credito->total_iva_credito = $totalCredito - ($totalCredito / 1.13);
            $credito->save();
        }

    }
}