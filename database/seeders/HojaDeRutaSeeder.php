<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HojaDeRutaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hr = [
            [
                'fecha_entrega' => '2021-05-01',
                'id_empleado' => 5,
                'total' => 1000
            ],
            [
                'fecha_entrega' => '2021-05-02',
                'id_empleado' => 6,
                'total' => 2000
            ],
            [
                'fecha_entrega' => '2021-05-03',
                'id_empleado' => 7,
                'total' => 3000
            ],
        ];
        foreach ($hr as $hoja) {
            \App\Models\HojaDeRuta::create($hoja);
        }
    }
}
