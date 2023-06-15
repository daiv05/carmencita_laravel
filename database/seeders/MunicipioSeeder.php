<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 262 municipios de El Salvador
        $municipios = [
            [
                'nombre_municipio' => 'Aguilares',
                'id_departamento' => 1,
            ],
            [
                'nombre_municipio' => 'Apopa',
                'id_departamento' => 1,
            ],
            [
                'nombre_municipio' => 'Ayutuxtepeque',
                'id_departamento' => 1,
            ],
            [
                'nombre_municipio' => 'Ciudad Delgado',
                'id_departamento' => 1,
            ],
            [
                'nombre_municipio' => 'Cuscatancingo',
                'id_departamento' => 1,
            ],
            [
                'nombre_municipio' => 'San Salvador',
                'id_departamento' => '1',
            ],



            [
                'nombre_municipio' => 'Acajutla',
                'id_departamento' => 2,
            ],
            [
                'nombre_municipio' => 'Armenia',
                'id_departamento' => 2,
            ],
            [
                'nombre_municipio' => 'Caluco',
                'id_departamento' => 2,
            ],
            [
                'nombre_municipio' => 'Cuisnahuat',
                'id_departamento' => 2,
            ],
            [
                'nombre_municipio' => 'Izalco',
                'id_departamento' => 2,
            ],
            [
                'nombre_municipio' => 'Juayua',
                'id_departamento' => 2,
            ],
            [
                'nombre_municipio' => 'Nahuizalco',
                'id_departamento' => 2,
            ],
            [
                'nombre_municipio' => 'Santo Domingo de Guzmán',
                'id_departamento' => 2,
            ],
        ];

        foreach ($municipios as $municipio) {
            \App\Models\Municipio::create($municipio);
        }
    }
}
