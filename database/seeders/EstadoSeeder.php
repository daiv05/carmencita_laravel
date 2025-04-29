<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estado;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            [
                'nombre' => 'Pendiente'
            ],
            [
                'nombre' => 'Aprobado'
            ],
            [
                'nombre' => 'Rechazado'
            ],
        ];

        foreach ($estados as $estado) {
            Estado::create($estado);
        }
    }
}
