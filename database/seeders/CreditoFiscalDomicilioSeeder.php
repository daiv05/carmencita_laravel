<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreditoFiscalDomicilioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $domicilio = [
            [
                'id_hr' => 1,
                'id_creditofiscal' => 6,
                'esta_cancelado' => false,
                'esta_emitido' => false
            ],
            [
                'id_hr' => 1,
                'id_creditofiscal' => 7,
                'esta_cancelado' => false,
                'esta_emitido' => false
            ],
            [
                'id_hr' => 1,
                'id_creditofiscal' => 8,
                'esta_cancelado' => false,
                'esta_emitido' => false
            ],
            [
                'id_hr' => 2,
                'id_creditofiscal' => 6,
                'esta_cancelado' => false,
                'esta_emitido' => false
            ],
            [
                'id_hr' => 2,
                'id_creditofiscal' => 7,
                'esta_cancelado' => false,
                'esta_emitido' => false
            ],
            [
                'id_hr' => 2,
                'id_creditofiscal' => 8,
                'esta_cancelado' => false,
                'esta_emitido' => false
            ],
            [
                'id_hr' => 3,
                'id_creditofiscal' => 6,
                'esta_cancelado' => false,
                'esta_emitido' => false
            ],
            [
                'id_hr' => 3,
                'id_creditofiscal' => 7,
                'esta_cancelado' => false,
                'esta_emitido' => false
            ],
            [
                'id_hr' => 3,
                'id_creditofiscal' => 8,
                'esta_cancelado' => false,
                'esta_emitido' => false
            ],
        ];

        foreach ($domicilio as $d) {
            \App\Models\CreditoFiscalDomicilio::create($d);
        }
    }
}
