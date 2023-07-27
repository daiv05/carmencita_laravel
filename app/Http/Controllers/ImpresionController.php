<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ImpresionController extends Controller
{
    public function generatePDF()
    {
        $data = ['1']; // Puedes pasar datos adicionales a la vista si es necesario.

        $pdf = Pdf::loadView('prueba_impresion', $data);
        return $pdf->download('archivo.pdf'); // Descarga el PDF automáticamente
    }
}

