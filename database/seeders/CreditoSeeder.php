<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use App\Models\Credito;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreditoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proveedores = Proveedor::all();
        foreach($proveedores as $proveedor){
            $credito = Credito::factory()->count(3)->for($proveedor)->create();
        }
    }
}
