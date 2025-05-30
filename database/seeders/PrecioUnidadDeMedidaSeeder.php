<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PrecioUnidadDeMedida;

class PrecioUnidadDeMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $precio_unidad_de_medida = [
            // Blusa Roja Manga Corta - Unidad y Docena
            [
                'precio_unidad_medida_producto' => 15.50,
                'id_unidad_de_medida' => 1,
                'codigo_barra_producto' => '750894641833',
                'cantidad_producto' => 1,
            ],
            [
                'precio_unidad_medida_producto' => 170.00, // 14.17 c/u aprox
                'id_unidad_de_medida' => 3,
                'codigo_barra_producto' => '750894641833',
                'cantidad_producto' => 12,
            ],

            // Vestido Largo Floral - Unidad y Caja
            [
                'precio_unidad_medida_producto' => 32.99,
                'id_unidad_de_medida' => 1,
                'codigo_barra_producto' => '750894641834',
                'cantidad_producto' => 1,
            ],
            [
                'precio_unidad_medida_producto' => 310.00, // 31.00 c/u aprox
                'id_unidad_de_medida' => 6,
                'codigo_barra_producto' => '750894641834',
                'cantidad_producto' => 10,
            ],

            // Palazzo Negro Elegante - Unidad y Media Docena
            [
                'precio_unidad_medida_producto' => 28.75,
                'id_unidad_de_medida' => 1,
                'codigo_barra_producto' => '750894641835',
                'cantidad_producto' => 1,
            ],
            [
                'precio_unidad_medida_producto' => 160.00, // 26.67 c/u
                'id_unidad_de_medida' => 4,
                'codigo_barra_producto' => '750894641835',
                'cantidad_producto' => 6,
            ],

            // Chaqueta Cuero Negra - Unidad y Paquete
            [
                'precio_unidad_medida_producto' => 59.99,
                'id_unidad_de_medida' => 1,
                'codigo_barra_producto' => '750894641840',
                'cantidad_producto' => 1,
            ],
            [
                'precio_unidad_medida_producto' => 290.00, // 58.00 c/u
                'id_unidad_de_medida' => 5,
                'codigo_barra_producto' => '750894641840',
                'cantidad_producto' => 5,
            ],

            // Top Deportivo Fucsia - Unidad y Docena
            [
                'precio_unidad_medida_producto' => 18.25,
                'id_unidad_de_medida' => 1,
                'codigo_barra_producto' => '750894641841',
                'cantidad_producto' => 1,
            ],
            [
                'precio_unidad_medida_producto' => 198.00, // 16.50 c/u
                'id_unidad_de_medida' => 3,
                'codigo_barra_producto' => '750894641841',
                'cantidad_producto' => 12,
            ],
            // Blazer Blanco Casual - Unidad y Caja
            [
                'precio_unidad_medida_producto' => 39.99,
                'id_unidad_de_medida' => 1,
                'codigo_barra_producto' => '750894641836',
                'cantidad_producto' => 1,
            ],
            [
                'precio_unidad_medida_producto' => 380.00, // 38.00 c/u aprox
                'id_unidad_de_medida' => 6,
                'codigo_barra_producto' => '750894641836',
                'cantidad_producto' => 10,
            ],

            // Falda Plisada Beige - Unidad y Media Docena
            [
                'precio_unidad_medida_producto' => 22.40,
                'id_unidad_de_medida' => 1,
                'codigo_barra_producto' => '750894641837',
                'cantidad_producto' => 1,
            ],
            [
                'precio_unidad_medida_producto' => 125.00, // 20.83 c/u aprox
                'id_unidad_de_medida' => 4,
                'codigo_barra_producto' => '750894641837',
                'cantidad_producto' => 6,
            ],

            // Camisa Oversize Denim - Unidad y Docena
            [
                'precio_unidad_medida_producto' => 24.99,
                'id_unidad_de_medida' => 1,
                'codigo_barra_producto' => '750894641838',
                'cantidad_producto' => 1,
            ],
            [
                'precio_unidad_medida_producto' => 270.00, // 22.50 c/u aprox
                'id_unidad_de_medida' => 3,
                'codigo_barra_producto' => '750894641838',
                'cantidad_producto' => 12,
            ],

            // Pantalón Cargo Verde - Unidad y Paquete
            [
                'precio_unidad_medida_producto' => 29.90,
                'id_unidad_de_medida' => 1,
                'codigo_barra_producto' => '750894641839',
                'cantidad_producto' => 1,
            ],
            [
                'precio_unidad_medida_producto' => 285.00, // 28.50 c/u aprox
                'id_unidad_de_medida' => 5,
                'codigo_barra_producto' => '750894641839',
                'cantidad_producto' => 10,
            ],

            // Short Jean Rasgado - Unidad y Media Docena
            [
                'precio_unidad_medida_producto' => 20.00,
                'id_unidad_de_medida' => 1,
                'codigo_barra_producto' => '750894641842',
                'cantidad_producto' => 1,
            ],
            [
                'precio_unidad_medida_producto' => 110.00, // 18.33 c/u aprox
                'id_unidad_de_medida' => 4,
                'codigo_barra_producto' => '750894641842',
                'cantidad_producto' => 6,
            ],
        ];


        foreach ($precio_unidad_de_medida as $precio) {
            PrecioUnidadDeMedida::create($precio);
        }
    }
}
