<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cargos = [
            [
                "id_jornada_laboral_diaria" => 1, 
                "nombre_cargo" => "Gerente",
                "salario_cargo" => 700.00,
                "descripcion_cargo" => "Administrar y gestionar el local",
            ],
            [
                "id_jornada_laboral_diaria" => 1, 
                "nombre_cargo" => "Sub-Gerente",
                "salario_cargo" => 400.0,
                "descripcion_cargo" => "Repartir pedidos" 
            ],
            [
                "id_jornada_laboral_diaria" => 1, 
                "nombre_cargo" => "Despachador",
                "salario_cargo" => 365.0,
                "descripcion_cargo" => "Atender a los clientes" 
            ],
            [
                "id_jornada_laboral_diaria" => 1, 
                "nombre_cargo" => "Repartidor",
                "salario_cargo" => 365.0,
                "descripcion_cargo" => "Repartir pedidos" 
            ],
        ];

        foreach ($cargos as $cargo) {
            \App\Models\Cargo::create($cargo);
        }
    }
}
