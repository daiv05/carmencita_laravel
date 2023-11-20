<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Models\Credito;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Validator;


class CreditoController extends Controller
{
    //Listar los creditos
    public function index()
    {
        return Credito::all();
    }

    public function show(Request $request, Credito $credito){

        $credito["abonos"] = $credito->abonos()->get();
        $credito["proveedor"] = $credito->proveedor()->first();
        return response()->json([
            'status'=>true,
            'credito'=>$credito
        ]);
    }

    public function getCreditos(Request $request)
    {
        $resultadosPorPagina = 10;
        $estado = request("estado") ?? 'all';
        $proveedor = request("proveedor") ?? 'all';

        if($estado == 'all'){
            $estado = '>=';
        }else if($estado == 'true'){
            $estado = '=';
        }else{
            $estado = '>';
        }

        if($proveedor == 'all'){
            $pagination = Credito::where('pendiente',$estado,0)
                                ->with('proveedor')->orderByDesc('fecha_limite_pago')->paginate($resultadosPorPagina);
        }else{
            $pagination = Credito::where('pendiente',$estado,0)
                                ->where('id_proveedor',$proveedor)
                                ->with('proveedor')->orderByDesc('fecha_limite_pago')->paginate($resultadosPorPagina);
        }

        return response()->json([
            'respuesta' => true,
            'pagination' => $pagination
        ], 200);
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
    public function getProveedores()
    {
        return Proveedor::all();
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            //'name' => 'required|string|max:255',
            'fecha_credito' => 'required',
            'fecha_limite_pago' => 'required|after:fecha_credito',
            'monto_credito' => ['required', 'numeric', 'gt:0'],
            'detalle_credito' => 'required',
            'id_proveedor' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all(),
                'Hola' => 'hola',
            ],400);
        }

        $credito = new Credito();
        $credito->fecha_credito = $request->fecha_limite_pago; //,
        if ($request->fecha_limite_pago) {
            $credito->fecha_limite_pago = $request->fecha_limite_pago;
        }
        if ($request->fecha_limite_pago) {
            $credito->fecha_limite_pago = $request->fecha_limite_pago;
        }

        $credito->fecha_credito = $request->fecha_credito;
        $credito->fecha_limite_pago = $request->fecha_limite_pago;
        $credito->monto_credito = $request->monto_credito;
        $credito->detalle_credito = $request->detalle_credito;
        $credito->id_proveedor = $request->id_proveedor;
        $credito->pendiente = $request->monto_credito;
        $credito->save();

        //$token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'status' => true,
            'message' => ['Credito registrado correctamente',],
            'credito' => $credito
        ],200);
    }
}