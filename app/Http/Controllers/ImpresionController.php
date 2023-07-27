<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ImpresionController extends Controller
{
    public function generatePDF(Venta $venta)
    {
        $venta->load('detalle_venta');
        $pdf = Pdf::loadView('impresion_factura', $venta);
        return $pdf->download('archivo.pdf'); // Descarga el PDF automáticamente
    }
}

