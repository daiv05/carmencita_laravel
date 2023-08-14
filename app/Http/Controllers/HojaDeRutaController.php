<?php

namespace App\Http\Controllers;

use App\Models\HojaDeRuta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HojaDeRutaController extends Controller
{
    public function index()
    {
        return HojaDeRuta::all();
    }

    public function store(Request $request){

        $validator = Validator::make($request->hoja_de_ruta, [
            'fecha_entrega' =>'required',
            'id_empleado' => 'required',
            'total' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all()
            ]);
        }

        $hojaDeRuta = HojaDeRuta::create($request->hoja_de_ruta);

        if (isset($hojaDeRuta)) {
            $ventaDomicilio = new VentaDomicilioController();
            return $ventaDomicilio->register_ventaDomicilio($request, $hojaDeRuta->id_hr);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => "Error al crear la Hoja de Ruta",
            ], 400);
        }

    }

}
