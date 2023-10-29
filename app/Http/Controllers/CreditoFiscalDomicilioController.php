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

    public function desvincularHojaRuta(Request $request){
        $credito_domicilio = CreditoFiscalDomicilio::where('id_creditofiscal', $request->pedido_id)->first();
        if (isset($credito_domicilio)){
            if ($credito_domicilio->esta_cancelado == 1 || $credito_domicilio->esta_emitido == 1){
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => "Pedido ya emitido/entregado. No se puede desvincular",
                ], 401);
            } else {
                try{
                    $credito_domicilio->delete();
                    return response()->json([
                        'respuesta' => true,
                        'mensaje' => "El pedido se ha desvinculado de la hoja de ruta",
                    ], 201);
                } catch (\Exception $e) {
                    return response()->json([
                        'respuesta' => false,
                        'mensaje' => "Ocurrió un error, vuelva a intentar",
                    ], 401);
                }
                
            }
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => "Pedido inexistente",
            ], 401);
        }
    }

    public function confirmar_pago_credito (Request $request, string $credito_domicilio){
        $c_d = CreditoFiscalDomicilio::find((int)$credito_domicilio);
        if (isset($c_d)){
            if ($c_d->esta_cancelado == 1){
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => "Error. El pago ya se había registrado anteriormente",
                ], 401);
            }
            try {
                $c_d->esta_cancelado = 1;
                $c_d->save();
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => "Pago de pedido registrado",
                ], 201);
            } catch (\ErrorException $err){
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => "Ocurrió un error, vuelva a intentar.",
                ], 401);
            }
        }
    }
}
