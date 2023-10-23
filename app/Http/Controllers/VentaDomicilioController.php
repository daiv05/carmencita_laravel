<?php

namespace App\Http\Controllers;

use App\Models\VentaDomicilio;
use ErrorException;
use Illuminate\Http\Request;

class VentaDomicilioController extends Controller
{
    public function index()
    {
        return VentaDomicilio::with('venta')->get();;
    }

    public function show($id)
    {
        return VentaDomicilio::find($id)->with('venta')->get();
    }
    
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

    public function desvincularHojaRuta(Request $request){
        $venta_domicilio = VentaDomicilio::where('id_venta', $request->pedido_id)->first();
        if (isset($venta_domicilio)){
            if ($venta_domicilio->esta_cancelada == 1 || $venta_domicilio->esta_emitida == 1){
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => "Pedido ya emitido/entregado. No se puede desvincular",
                ], 401);
            } else {
                try{
                    $venta_domicilio->delete();
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

    public function confirmar_pago_venta (Request $request, string $venta_domicilio){
        $v_d = VentaDomicilio::find((int)$venta_domicilio);
        if (isset($v_d)){
            if ($v_d->esta_cancelada == 1){
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => "Error. El pago ya se había registrado anteriormente",
                ], 401);
            }
            try {
                $v_d->esta_cancelada = 1;
                $v_d->save();
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
