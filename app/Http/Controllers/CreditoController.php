<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Credito;

class CreditoController extends Controller
{
    //Listar los creditos
    public function index(){
        return Credito::all();
    }

    //Crear un nuevo credito
    public function store(Request $request){
        $inputs = $request->input();
        $respuesta = Credito::create($inputs);
        return $respuesta;
    }
}
