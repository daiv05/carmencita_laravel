<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            [
                'codigo_barra_producto' => '750894641833',
                'nombre_producto' => 'Blusa Roja Manga Corta',
                'cantidad_producto_disponible' => 100,
                'cantidad_producto_fisico' => 100,
                'precio_unitario' => 15.50,
                'esta_disponible' => true,
                'foto' => '',
            ],
            [
                'codigo_barra_producto' => '750894641834',
                'nombre_producto' => 'Vestido Largo Floral',
                'cantidad_producto_disponible' => 80,
                'cantidad_producto_fisico' => 80,
                'precio_unitario' => 32.99,
                'esta_disponible' => true,
                'foto' => '',
            ],
            [
                'codigo_barra_producto' => '750894641835',
                'nombre_producto' => 'Palazzo Negro Elegante',
                'cantidad_producto_disponible' => 50,
                'cantidad_producto_fisico' => 50,
                'precio_unitario' => 28.75,
                'esta_disponible' => true,
                'foto' => '',
            ],
            [
                'codigo_barra_producto' => '750894641836',
                'nombre_producto' => 'Blazer Blanco Casual',
                'cantidad_producto_disponible' => 60,
                'cantidad_producto_fisico' => 60,
                'precio_unitario' => 39.99,
                'esta_disponible' => true,
                'foto' => '',
            ],
            [
                'codigo_barra_producto' => '750894641837',
                'nombre_producto' => 'Falda Plisada Beige',
                'cantidad_producto_disponible' => 90,
                'cantidad_producto_fisico' => 90,
                'precio_unitario' => 22.40,
                'esta_disponible' => true,
                'foto' => '',
            ],
            [
                'codigo_barra_producto' => '750894641838',
                'nombre_producto' => 'Camisa Oversize Denim',
                'cantidad_producto_disponible' => 70,
                'cantidad_producto_fisico' => 70,
                'precio_unitario' => 24.99,
                'esta_disponible' => true,
                'foto' => '',
            ],
            [
                'codigo_barra_producto' => '750894641839',
                'nombre_producto' => 'Pantalón Cargo Verde',
                'cantidad_producto_disponible' => 55,
                'cantidad_producto_fisico' => 55,
                'precio_unitario' => 29.90,
                'esta_disponible' => true,
                'foto' => '',
            ],
            [
                'codigo_barra_producto' => '750894641840',
                'nombre_producto' => 'Chaqueta Cuero Negra',
                'cantidad_producto_disponible' => 40,
                'cantidad_producto_fisico' => 40,
                'precio_unitario' => 59.99,
                'esta_disponible' => true,
                'foto' => '',
            ],
            [
                'codigo_barra_producto' => '750894641841',
                'nombre_producto' => 'Top Deportivo Fucsia',
                'cantidad_producto_disponible' => 75,
                'cantidad_producto_fisico' => 75,
                'precio_unitario' => 18.25,
                'esta_disponible' => true,
                'foto' => '',
            ],
            [
                'codigo_barra_producto' => '750894641842',
                'nombre_producto' => 'Short Jean Rasgado',
                'cantidad_producto_disponible' => 85,
                'cantidad_producto_fisico' => 85,
                'precio_unitario' => 20.00,
                'esta_disponible' => true,
                'foto' => '',
            ],
        ];


        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}
