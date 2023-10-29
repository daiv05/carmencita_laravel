<?php

namespace Database\Seeders;

use App\Models\CreditoFiscal;
use App\Models\CreditoFiscalDomicilio;
use App\Models\HojaDeRuta;
use App\Models\VentaDomicilio;
use App\Models\Venta;
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
                'fecha_entrega' => '2023-11-10',
                'id_empleado' => 4,
                'total' => 1000,
                'esta_entregado'=> false
            ],
            [
                'fecha_entrega' => '2023-10-10',
                'id_empleado' => 2,
                'total' => 2000,
                'esta_entregado'=>true
            ],
            [
                'fecha_entrega' => '2023-12-10',
                'id_empleado' => 4,
                'total' => 3000,
                'esta_entregado'=>false
            ],
        ];
        foreach ($hr as $hoja) {
            HojaDeRuta::create($hoja);
        }

        $hojasDeRuta = HojaDeRuta::all();

        foreach($hojasDeRuta as $hojaDeRuta){
            $total = 0;
            $ventas = Venta::where('fecha_venta',$hojaDeRuta->fecha_entrega)->take(2)->get();
            $creditos = CreditoFiscal::where('fecha_credito',$hojaDeRuta->fecha_entrega)->take(2)->get();
            foreach($ventas as $venta){
                VentaDomicilio::factory()->for($hojaDeRuta)->for($venta)->create();
                $total += $venta->total_venta;
            }

            foreach($creditos as $venta){
                CreditoFiscalDomicilio::factory()->for($hojaDeRuta)->for($venta)->create();
                $total += $venta->total_credito;
            }
            $hojaDeRuta->total = $total;
            $hojaDeRuta->update();
        }

    }
}
