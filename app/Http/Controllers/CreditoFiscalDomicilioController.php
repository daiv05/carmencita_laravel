<?php

namespace App\Http\Controllers;

use App\Models\CreditoFiscalDomicilio;
use Illuminate\Http\Request;

class CreditoFiscalDomicilioController extends Controller
{
    public function index(){
        $creditoFiscal = CreditoFiscalDomicilio::with('creditoFiscal')->get();
        return response()->json([
            'creditoFiscal' => $creditoFiscal,
        ], 201);
    }

    public function show($id){
        $cred = CreditoFiscalDomicilio::find($id)->with('creditoFiscal')->get();
        return response()->json([
            'creditoFiscal' => $cred,
        ], 201);
    }

    public function register_CreditoFiscalDomicilio(Request $request, int $id_hr){

        $pedidos = $request->pedidos_fiscal;
        if(isset($pedidos)){

            foreach($pedidos as $pedido){
                $existe = CreditoFiscalDomicilio::where('id_creditofiscal',$pedido['id_creditofiscal'])->first();
                if(!$existe){
                    $creditoFiscal = CreditoFiscalDomicilio::create([
                        'id_hr' => $id_hr,
                        'id_creditofiscal'=>$pedido['id_creditofiscal']
                    ]);
                    $creditoFiscal->save();
                }else{
                    return response()->json([
                        'respuesta' => false,
                        'mensaje' => 'El credito fiscal ya esta asignado',
                    ], 201);
                }
            }
            $mensaje = ["Hoja de ruta registrada correctamente"];
            return response()->json([
                'respuesta' => true,
                'mensaje' => $mensaje,
            ], 201);

        }else{
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'no se asignaron pedidos',
            ], 201);
        }


    }
}
