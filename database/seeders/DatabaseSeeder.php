<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CreditoFiscal;
use App\Models\HojaDeRuta;
use App\Models\JornadaLaboralDiaria;
use App\Models\Municipio;
use App\Models\UnidadDeMedida;
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

        $this->call(UnidadDeMedidaSeeder::class);
        $this->call(DepartamentoSeeder::class);
        $this->call(MunicipioSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(PrecioUnidadDeMedidaSeeder::class);
        $this->call(VentaSeeder::class);
        $this->call(DetalleVentaSeeder::class);
        $this->call(CreditoFiscalSeeder::class);
        $this->call(DetalleCreditoSeeder::class);
        $this->call(SexoSeeder::class);
        $this->call(ProveedorSeeder::class);

        $this->call(EstadoFamiliarSeeder::class);
        $this->call(NacionalidadSeeder::class);
        
        $this->call(JornadaLaboralDiariaSeeder::class);
        $this->call(CargoSeeder::class);
        $this->call(EmpleadoSeeder::class);
        $this->call(AsistenciaSeeder::class);
        $this->call(RoleSeeder::class);

        $this->call(HojaDeRutaSeeder::class);
        $this->call(CreditoFiscalDomicilioSeeder::class);
        $this->call(VentaDomicilioSeeder::class);
        $this->call(LoteSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(CreditoSeeder::class);

    }
}
