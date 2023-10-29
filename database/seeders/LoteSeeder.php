<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lote;
use App\Models\Producto;

class LoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = Producto::all();
        foreach($productos as $producto){
            
            $lotes = Lote::factory()->count(3)->for($producto)->create();
            $producto->cantidad_producto_disponible=0;
            foreach($lotes as $lote){
                $producto->cantidad_producto_disponible += $lote->cantidad;
                $producto->update();
            } 
        }
    }
}
