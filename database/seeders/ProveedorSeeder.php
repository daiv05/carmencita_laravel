<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proveedores = [
            [
                'nombre_proveedor'=>'Bimbo'
            ],
            [
                'nombre_proveedor' => 'La Constancia'
            ],
            [
                'nombre_proveedor' => 'Diana'
            ],
            [
                'nombre_proveedor'=> 'Nestle'
            ],
            [
                'nombre_proveedor'=> 'Bocadeli'
            ],
            [
                'nombre_proveedor'=> 'Pepsi'
            ]
            
            ];

        foreach($proveedores as $proveedor){
            Proveedor::create($proveedor);
        }
    }
}
