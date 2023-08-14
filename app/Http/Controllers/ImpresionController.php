<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ImpresionController extends Controller
{
    public function generatePDF(Venta $venta)
    {
        $venta->with('detalleVenta');
        foreach ($venta->detalleVenta as $detalle) {
            $detalle->with('producto');
        }
        
        //dd($ventaArray);
        $pdf = Pdf::loadView('impresion_facturas', compact('venta'))->setOption(['defaultFont' => 'gabriele-l']);
        return $pdf->download('archivo.pdf');
    }

    public function ver_factura(Request $request){
        $venta = Venta::find(1);
        $venta->with('detalleVenta');
        foreach ($venta->detalleVenta as $detalle) {
            $detalle->with('producto');
        }
        // $pdf = Pdf::loadView('impresion_facturas', compact('venta'))->setOption(['defaultFont' => 'gabriele-l']);
        // return $pdf->download('archivo.pdf');
        return view('impresion_facturas')->with('venta', $venta);
    }
}

