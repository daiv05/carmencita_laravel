<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 
        // Crear registros de productos
        Producto::create([
            'codigo_barra_producto' => '750894641833',
            'nombre_producto' => 'Jabón Zixx Ultra+',
            'cantidad_producto_disponible' => 100,
            'precio_unitario' => 1.10,
            'esta_disponible' => true
        ]);

        Producto::create([
            'codigo_barra_producto' => '7411001800903',
            'nombre_producto' => 'COCA-COLA 2.5L',
            'cantidad_producto_disponible' => 100,
            'precio_unitario' => 2.75,
            'esta_disponible' => true
        ]);

        Producto::create([
            'codigo_barra_producto' => '7411001802341',
            'nombre_producto' => 'COCA-COLA 1.25L',
            'cantidad_producto_disponible' => 100,
            'precio_unitario' => 1.25,
            'esta_disponible' => true
        ]);

        Producto::create([
            'codigo_barra_producto' => '7413100033053',
            'nombre_producto' => 'ACEITE ORISOL CLÁSICO 700ML',
            'cantidad_producto_disponible' => 100,
            'precio_unitario' => 2.25,
            'esta_disponible' => true
        ]);
    }
}
