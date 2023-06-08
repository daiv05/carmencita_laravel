<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NacionalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nacionalidades =[
            [
                'nombre_nacionalidad' => 'El Salvador'
            ],
            [
                'nombre_nacionalidad' => 'Honduras'
            ],
            [
                'nombre_nacionalidad' => 'Guatemala'
            ],
            [
                'nombre_nacionalidad' => 'Costa Rica'
            ],
            [
                'nombre_nacionalidad' => 'Nicaragua'
            ]
        ];

        foreach($nacionalidades as $nacionalidad)
        {
            \App\Models\Nacionalidad::create($nacionalidad);
        }
    }
}
