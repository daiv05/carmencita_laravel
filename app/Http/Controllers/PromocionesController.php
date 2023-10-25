<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Promocion;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class PromocionesController extends Controller
{
    ////Obtener los productos
    public function getProductos(){
        return Producto::all();
    }

    //crear una nueva promocion
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            //'name' => 'required|string|max:255',
            'codigo_barra_producto' => 'required',
            'fecha_inicio_oferta' => 'required',
            'fecha_fin_oferta' => 'required|after:fecha_inicio_oferta',
            'precio_oferta' => ['required', 'numeric', 'gt:0'],
            'nombre_oferta' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> false,
                'message'=> $validator->errors()->all(),
                'Hola' => 'hola',
            ]);
        }

        $promocion = new Promocion();
            $promocion->fecha_inicio_oferta = $request->fecha_fin_oferta;//,
            if($request->fecha_fin_oferta)
            {      
                $promocion->fecha_fin_oferta = $request->fecha_fin_oferta;
            }
            if($request->fecha_fin_oferta)
            {
                $promocion->fecha_fin_oferta= $request->fecha_fin_oferta; 
            }

            $promocion->codigo_barra_producto= $request->codigo_barra_producto;
            $promocion->fecha_inicio_oferta= $request->fecha_inicio_oferta;
            $promocion->fecha_fin_oferta = $request->fecha_fin_oferta;
            $promocion->precio_oferta= $request->precio_oferta;
            $promocion->nombre_oferta= $request->nombre_oferta;
            $promocion->save();

        //$token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'status'=>true,
            'message'=>$validator->errors()->all(),
            'promocion'=>$promocion
        ]);
    }

    //Obtener todas las promociones vigentes y retono de JSON
    public function promocionesVigentes(){
        $fechaActual = Carbon::now()->toDateString();

        $promociones = DB::table('promocions')
        ->join('producto', 'promocions.codigo_barra_producto', '=', 'producto.codigo_barra_producto')
        ->select('promocions.*', 'producto.foto')
        ->where('promocions.fecha_inicio_oferta', '<=', $fechaActual)
        ->where('promocions.fecha_fin_oferta', '>=', $fechaActual)
        ->get();

        return response()->json($promociones);

    }

}
