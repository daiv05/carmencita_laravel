<?php

namespace App\Http\Controllers;

use App\Models\Abono;
use App\Models\Credito;
use Illuminate\Http\Request;

class AbonoController extends Controller
{
    public function show(Request $request, Abono $credito){
        return response()->json([
            'status'=>true,
            'credito'=>$credito
        ]);
    }

    public function store(Request $request)
    {   
        $validator = \Validator::make($request->all(), [
            'monto' => 'required|numeric|min:0|not_in:0',
            'credito'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'mensaje'=> $validator->errors()->first(),
            ],400);
        }

        $fecha = request('fecha') ?? new \DateTime();
        $monto = request("monto") ?? 0;
        $credito = Credito::where('id', $request->credito)->first();

        if(isset($credito)){
            if($credito->pendiente == 0){
                return response()->json([
                    'status'=>false,
                    'mensaje'=>'Abono no registrado, el credito ya esta pagado.'
                ],200);
            }
            if($credito->updateMontoPendiente($monto)){
                $abono = Abono::create([
                    'monto' => $monto,
                    'fecha' => $fecha,
                    'id_credito'=> $credito->id
                ]);
    
                return response()->json([
                    'status'=>true,
                    'mensaje'=>'Abono registrado correctamente.',
                    'abono' => $abono
                ],200);
            }else{
                return response()->json([
                    'status'=>false,
                    'mensaje'=>'El abono supera el monto pendiente del credito.'
                ],200);
            }

        }else{
            return response()->json([
                'status'=>false,
                'mensaje'=>'El credito no existe'
            ],404);
        }

    }
}
