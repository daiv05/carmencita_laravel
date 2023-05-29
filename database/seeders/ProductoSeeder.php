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
        // Productos con su codigo de barra REAL siguiendo el estandard EAN-13
        $productos = [
            [
                'codigo_barra_producto' => '1234567890123',
                'nombre_producto' => 'Coca Cola',
                'cantidad_producto_disponible' => 100,
                'precio_unitario' => 1.50,
                'esta_disponible' => true,
            ],
            [
                'codigo_barra_producto' => '1234567890124',
                'nombre_producto' => 'Pepsi',
                'cantidad_producto_disponible' => 100,
                'precio_unitario' => 1.50,
                'esta_disponible' => true,
            ],
            [
                'codigo_barra_producto' => '1234567890125',
                'nombre_producto' => 'Fanta',
                'cantidad_producto_disponible' => 100,
                'precio_unitario' => 1.50,
                'esta_disponible' => true,
            ],
            [
                'codigo_barra_producto' => '1234567890126',
                'nombre_producto' => 'Sprite',
                'cantidad_producto_disponible' => 100,
                'precio_unitario' => 1.50,
                'esta_disponible' => true,
            ],
            [
                'codigo_barra_producto' => '1234567890127',
                'nombre_producto' => '7up',
                'cantidad_producto_disponible' => 100,
                'precio_unitario' => 1.50,
                'esta_disponible' => true,
            ],
            [
                'codigo_barra_producto' => '1234567890128',
                'nombre_producto' => 'Coca Cola Zero',
                'cantidad_producto_disponible' => 100,
                'precio_unitario' => 1.50,
                'esta_disponible' => true,
            ],
            [
                'codigo_barra_producto' => '1234567890129',
                'nombre_producto' => 'Pepsi Zero',
                'cantidad_producto_disponible' => 100,
                'precio_unitario' => 1.50,
                'esta_disponible' => true,
            ],
            [
                'codigo_barra_producto' => '1234567890130',
                'nombre_producto' => 'Fanta Zero',
                'cantidad_producto_disponible' => 100,
                'precio_unitario' => 1.50,
                'esta_disponible' => true,
            ],
            [
                'codigo_barra_producto' => '1234567890131',
                'nombre_producto' => 'Sprite Zero',
                'cantidad_producto_disponible' => 100,
                'precio_unitario' => 1.50,
                'esta_disponible' => true,
            ],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}
