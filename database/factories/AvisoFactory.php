<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aviso>
 */
class AvisoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titulos = [
            'Título 1',
            'Título 2',
            'Título 3',
            'Título 4',
            'Título 5',
            'Título 6',
            
        ];
        $cuerpos = [
            "cuerpo 1",
            "cuerpo 2",
            "cuerpo 3",
            "cuerpo 4",
            "cuerpo 5",
            "cuerpo 6",
        ];
        return [
            "fecha_creacion"  => now(),
            "fecha_finalizacion" => now(),
            "estado_aviso"=> true,
            "titulo_aviso"=>$titulos[array_rand($titulos)],
            "cuerpo_aviso"=>$cuerpos[array_rand($cuerpos)]
        ];
    }
}
