<?php

namespace App\Http\Controllers;

use App\Models\VentaDomicilio;
use Illuminate\Http\Request;

class VentaDomicilioController extends Controller
{
    public function guardar_venta_domicilio(Request $request, int $id_venta)
    {
        $ventaDomicilio = VentaDomicilio::create([
            'id_venta' => $id_venta,
            'esta_cancelada' => 0,
            'esta_emitida' => 0,
        ]);
        $ventaDomicilio->save();
        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Venta Domicilio registrada correctamente',
        ], 201);

    }

    public function register_ventaDomicilio(Request $request, int $id_hr){

        $pedidos = $request->pedidos_factura;
        if(isset($pedidos)){

            foreach($pedidos as $pedido){
                $existe = VentaDomicilio::where('id_venta',$pedido['id_venta'])->first();
                if(!$existe){
                    $ventaDomicilio = VentaDomicilio::create([
                        'id_hr' => $id_hr,
                        'id_venta'=>$pedido['id_venta']
                    ]);
                    $ventaDomicilio->save();
                }else{
                    $mensaje = ["La Venta Domicilio ya esta asignada"];
                    return response()->json([
                        'respuesta' => false,
                        'mensaje' => $mensaje,
                    ], 201);
                }
            }

            if(isset($request->pedidos_fiscal)){
                $creditoFiscalDomicilio = new CreditoFiscalDomicilioController();
                return $creditoFiscalDomicilio->register_CreditoFiscalDomicilio($request, $id_hr);
            }
            
            $mensaje = ["Venta Domicilio registrada correctamente"];
            return response()->json([
                'respuesta' => true,
                'mensaje' => $mensaje,
            ], 201);

        }else{
            return response()->json([
                'respuesta' => true,
                'mensaje' => "no se asignaron pedidos",
            ], 201);
        }


    }
}
