<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "codigo_barra_producto"=>Str::random(13),
            "nombre_producto"=> fake()->name(),
            "cantidad_producto_disponible"=>random_int(50,250),
            "cantidad_producto_fisico"=>random_int(50,250),
            "precio_unitario"=>random_int(2,90),
            "esta_disponible"=>true,
            "foto"=>" ",
        ];
    }
}
