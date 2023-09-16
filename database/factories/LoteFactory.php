<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Producto;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lote>
 */
class LoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productos = Producto::all();
        
        return [
            "cantidad"=>rand(70,250),
            "cantidad_total_unidades"=>rand(50,500),
            "costo_total" => rand(100,1000),
            "fecha_ingreso"=>Carbon::create("2023","08","10"),
            "fecha_vencimiento"=> Carbon::create("2023","08","10")->addMonth(rand(1,8)),
            "precio_unitario"=>rand(2,100),
            //"codigo_barra_producto"=>$productos[rand(0,8)]->codigo_barra_producto,
        ];
    }
}
