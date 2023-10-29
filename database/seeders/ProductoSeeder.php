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
                'codigo_barra_producto' => '750894641833',
                'nombre_producto' => 'Jabón Zixx Ultra+',
                'cantidad_producto_disponible' => 100,
                'cantidad_producto_fisico' => 100,
                'precio_unitario' => 1.10,
                'esta_disponible' => true,
                'foto'=>""
            ],
            [
                'codigo_barra_producto' => '7411001800903',
                'nombre_producto' => 'COCA COLA 2.5L',
                'cantidad_producto_disponible' => 100,
                'cantidad_producto_fisico' => 100,
                'precio_unitario' => 2.25,
                'esta_disponible' => true,
                'foto'=>"",
            ],
            [
                'codigo_barra_producto' => '7411001802341',
                'nombre_producto' => 'COCA COLA 1.25L',
                'cantidad_producto_disponible' => 100,
                'cantidad_producto_fisico' => 100,
                'precio_unitario' => 1.25,
                'esta_disponible' => true,
                'foto'=>"",
            ],
            [
                'codigo_barra_producto' => '7413100033053',
                'nombre_producto' => 'ACEITE ORISOL CLÁSICO 700ML',
                'cantidad_producto_disponible' => 100,
                'cantidad_producto_fisico' => 100,
                'precio_unitario' => 2.25,
                'esta_disponible' => true,
                'foto'=>"",
            ],

            //Otros fake
            [
                'codigo_barra_producto' => '1234567890127',
                'nombre_producto' => '7up',
                'cantidad_producto_disponible' => 100,
                'cantidad_producto_fisico' => 100,
                'precio_unitario' => 1.50,
                'esta_disponible' => true,
                'foto'=>"",
            ],
            [
                'codigo_barra_producto' => '1234567890128',
                'nombre_producto' => 'Coca Cola Zero',
                'cantidad_producto_disponible' => 100,
                'cantidad_producto_fisico' => 100,
                'precio_unitario' => 1.50,
                'esta_disponible' => true,
                'foto'=>"",
            ],
            [
                'codigo_barra_producto' => '1234567890129',
                'nombre_producto' => 'Pepsi Zero',
                'cantidad_producto_disponible' => 100,
                'cantidad_producto_fisico' => 100,
                'precio_unitario' => 1.50,
                'esta_disponible' => true,
                'foto'=>"",
            ],
            [
                'codigo_barra_producto' => '1234567890130',
                'nombre_producto' => 'Fanta Zero',
                'cantidad_producto_disponible' => 100,
                'cantidad_producto_fisico' => 100,
                'precio_unitario' => 1.50,
                'esta_disponible' => true,
                'foto'=>"",
            ],
            [
                'codigo_barra_producto' => '1234567890131',
                'nombre_producto' => 'Sprite Zero',
                'cantidad_producto_disponible' => 100,
                'cantidad_producto_fisico' => 100,
                'precio_unitario' => 1.50,
                'esta_disponible' => true,
                'foto'=>"",
            ],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }

    }
}
