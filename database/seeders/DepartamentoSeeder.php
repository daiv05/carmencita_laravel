<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Departamento;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $departamentos = [
            [
                'nombre_departamento' => 'San Salvador',
            ],
            [
                'nombre_departamento' => 'La Libertad',
            ],
            [
                'nombre_departamento' => 'Sonsonate',
            ],
            [
                'nombre_departamento' => 'Santa Ana',
            ],
            [
                'nombre_departamento' => 'San Miguel',
            ],
            [
                'nombre_departamento' => 'La Union',
            ],
            [
                'nombre_departamento' => 'La Paz',
            ],
            [
                'nombre_departamento' => 'Cuscatlan',
            ],
            [
                'nombre_departamento' => 'Chalatenango',
            ],
            [
                'nombre_departamento' => 'San Vicente',
            ],
            [
                'nombre_departamento' => 'Usulutan',
            ],
            [
                'nombre_departamento' => 'Morazan',
            ],
            [
                'nombre_departamento' => 'Ahuachapan',
            ],
        ];

        foreach ($departamentos as $departamento) {
            Departamento::create($departamento);
        }
    }
}
