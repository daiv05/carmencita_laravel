<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CreditoFiscal;
use App\Models\JornadaLaboralDiaria;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        
        // PARA LLAMAR A LOS SEEDERS, EN ORDEN DEPENDIENTE DE LAS FOREIGN KEYS

        $this->call(ClienteSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(VentaSeeder::class);
        $this->call(DetalleVentaSeeder::class);
        $this->call(CreditoFiscalSeeder::class);
        $this->call(DetalleCreditoSeeder::class);
        $this->call(SexoSeeder::class);

        $this->call(EstadoFamiliarSeeder::class);
        $this->call(NacionalidadSeeder::class);
        
        $this->call(JornadaLaboralDiariaSeeder::class);
        $this->call(CargoSeeder::class);

    }
}
