<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venta>
 */
class VentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha_venta'=> Carbon::create(2023,rand(10,12),10),
            'total_venta'=>0,
            'total_iva'=>0,
            'nombre_cliente_venta'=>'Mr.Robot',
            'estado_venta'=>false,
            'domicilio'=>true
        ];
    }
}
