<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Credito>
 */
class CreditoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha_credito'=>Carbon::create(2023,8,10),
            'fecha_limite_pago'=>Carbon::create(2023,8,10),
            'monto_credito'=>1000,
            'detalle_credito'=>'Mercancias',
            //'id_proveedor'=,
            'pendiente' => 1000,
        ];
    }
}
