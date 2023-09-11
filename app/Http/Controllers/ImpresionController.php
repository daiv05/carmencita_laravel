<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImpresionController extends Controller
{
    public function generate_pdf_consumidor_final(Venta $venta)
    {
        $venta->with('detalleVenta');
        foreach ($venta->detalleVenta as $detalle) {
            $detalle->with('producto');
        }
        $pdf = Pdf::loadView('impresion_facturas', compact('venta'))->setOption(['defaultFont' => 'gabriele-l']);
        $ruta_pdf = 'cons_final/factura_venta_' . $venta->id_venta . '.pdf';
        $pdf->save($ruta_pdf);
        
        $command1 = 'PDFXEdit /importp "C:\settings_editor.dat" ';
        $salida_import = exec($command1, $output, $return_var);

        error_log('----------- IMPORT ------------');
        error_log('salida. ' . implode(',', $output));
        error_log('status. ' . $return_var);

        $command2 = 'PDFXEdit /print:default=no;showui=no;printer="Microsoft Print to PDF" ' . public_path($ruta_pdf);
        $salida_impresion = exec($command2, $output1, $return_var1);

        error_log('----------- IMPRESION ------------');
        error_log('salida. ' . implode(',', $output1));
        error_log('status. ' . $return_var1);

        return implode(',', $output) . ' ' . implode(',', $output1);
    }

    public function generate_pdf_credito_fiscal(Venta $venta)
    {
        $venta->with('detalleVenta');
        foreach ($venta->detalleVenta as $detalle) {
            $detalle->with('producto');
        }
        $pdf = Pdf::loadView('impresion_facturas', compact('venta'))->setOption(['defaultFont' => 'gabriele-l']);
        $ruta_pdf = $pdf->download('factura_venta.pdf')->store("public/facturas/{$venta->id}/");
        
        $command = 'C:\Program Files\Tracker Software\PDF Editor\PDFXEdit.exe /print:default=no;showui=no;printer="Canon G3060 series" "' . public_path(Storage::url($ruta_pdf)) . '" /exit';
        $output = shell_exec($command);
        
        return $output;
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

