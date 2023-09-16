<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Credito;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Validator;


class CreditoController extends Controller
{
    //Listar los creditos
    public function index(){
        return Credito::all();
    }

    //Crear un nuevo credito
    /*public function store1(Request $request){

        $validator = Validator::make($request->all(),[
            //'name' => 'required|string|max:255',
            'fecha_credito' => 'required',
            'fecha_limite_pago' => 'required',
            'monto_credito' => 'required',
            'detalle_credito' => 'required',
            'id_proveedor' => 'required',
        ]);

        $inputs = $request->input();
        $respuesta = Credito::create($inputs);
        return $respuesta;
    }*/

    //Obtener proveedores
    public function getProveedores(){
        return Proveedor::all();
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            //'name' => 'required|string|max:255',
            'fecha_credito' => 'required',
            'fecha_limite_pago' => 'required',
            'monto_credito' => ['required', 'numeric', 'min:1'],
            'detalle_credito' => 'required',
            'id_proveedor' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> false,
                'message'=> $validator->errors()->all(),
                'Hola' => 'hola',
            ]);
        }

        $credito = new Credito();
            $credito->fecha_credito = $request->fecha_limite_pago;//,
            if($request->fecha_limite_pago)
            {      
                $credito->fecha_limite_pago = $request->fecha_limite_pago;
            }
            if($request->fecha_limite_pago)
            {
                $credito->fecha_limite_pago= $request->fecha_limite_pago; 
            }

            $credito->fecha_credito= $request->fecha_credito;
            $credito->fecha_limite_pago = $request->fecha_limite_pago;
            $credito->monto_credito= $request->monto_credito;
            $credito->detalle_credito= $request->detalle_credito;
            $credito->id_proveedor= $request->id_proveedor;
            $credito->save();

        //$token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'status'=>true,
            'message'=>$validator->errors()->all(),
            'credito'=>$credito
        ]);
    }
}
