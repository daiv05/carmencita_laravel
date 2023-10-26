<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreditoFiscal>
 */
class CreditoFiscalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_cliente'=>rand(1,2),
            'fecha_credito'=>Carbon::create(2023,rand(10,12),10),
            'total_credito'=>0,
            'total_iva_credito'=>0,
            'estado_credito'=>false,
            'domicilio'=>true
        ];
    }
}
