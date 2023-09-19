<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Producto;
use App\models\Lote;
use Carbon\Carbon;

class InformeProductosPorVencerController extends Controller
{
    //Para obetener todos los productos que vencen en los proximos 15 dias
    public function index(){
        $fechaActual = Carbon::now()->toDateString();
        $fechaLimite = Carbon::now()->addDays(15)->toDateString();

        $productosPV = Lote::whereBetween('fecha_vencimiento', [$fechaActual, $fechaLimite])->with('producto')->get();

        return response()->json(['productosPV'=>$productosPV]);
    }
    
}
