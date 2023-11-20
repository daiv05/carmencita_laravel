<?php

namespace App\Http\Controllers;

use App\Models\CreditoFiscal;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\HojaDeRuta;
use App\Models\VentaDomicilio;
use Illuminate\Support\Facades\DB;

class ImpresionController extends Controller
{
    public function generate_pdf_consumidor_final(Venta $venta)
    {
        error_log('imprimiendo desde detalle hr');
        error_log($venta);
        if ($venta == null) {
            return response()->json([
                'message' => 'No se encontró la venta'
            ], 404);
        }
        $venta->with('detalleVenta');
        foreach ($venta->detalleVenta as $detalle) {
            $detalle->with('producto');
            $cantidad = $detalle->cantidad_producto;
            // Ordenar $detalle->producto->precioUnidadDeMedida en forma ascendente
            $precios = $detalle->producto->precioUnidadDeMedida->sortBy('cantidad_producto');
            // Obtener el primero
            $precio_cercano = $precios->first();
            if ($precios->isEmpty()) {
                break;
            }
            if ($cantidad < $precio_cercano->cantidad_producto) {
                $detalle->producto->precio_unitario = $detalle->producto->precio_unitario;
                error_log('unitario actual');
                error_log($detalle->producto->precio_unitario);
                break;
            } else {
                foreach ($precios as $precio_ordenado) {
                    if ($precio_ordenado->cantidad_producto <= $cantidad) {
                        $precio_cercano = $precio_ordenado;
                    } else {
                        break;
                    }
                }
                // Calcular el precio_producto basado en el promedio entre cantidad_producto y precio_unidad
                $detalle->producto->precio_unitario = number_format($precio_cercano->precio_unidad_medida_producto / $precio_cercano->cantidad_producto, 4);
            }
        }
        $pdf = Pdf::loadView('impresion_facturas', compact('venta'));
        $ruta_pdf = 'factura_venta_' . $venta->id_venta . '.pdf';
        $pdf->save($ruta_pdf);
        $command1 = ' ';//$command1 = 'PDFXEdit /importp "C:\setting_3060.dat" ';
        exec($command1, $output, $return_var);
        //$command2 = 'PDFXEdit /print:default=no;showui=no;printer="Canon G3060 series" ' . public_path($ruta_pdf);
        $command2 = '/PDFx-Editor/PDFXEdit.exe /print:default=no;showui=no;printer="Brother DCP-T720DW Printer" ' . public_path($ruta_pdf);
        exec($command2, $output1, $return_var1);
        return implode(',', $output) . ' ' . implode(',', $output1);
    }

    public function generate_pdf_credito_fiscal(CreditoFiscal $credito)
    {
        $credito->with('detalleCredito')->with('cliente')->with('municipio')->with('departamento');
        foreach ($credito->detalleCredito as $detalle) {
            $detalle->with('producto');
            $cantidad = $detalle->cantidad_producto_credito;
            // Ordenar $detalle->producto->precioUnidadDeMedida en forma ascendente
            $precios = $detalle->producto->precioUnidadDeMedida->sortBy('cantidad_producto');
            if ($precios->isEmpty()) {
                break;
            }
            // Obtener el primero
            $precio_cercano = $precios->first();
            if ($cantidad < $precio_cercano->cantidad_producto) {
                $detalle->producto->precio_unitario = $detalle->producto->precio_unitario;
                break;
            } else {
                foreach ($precios as $precio_ordenado) {
                    if ($precio_ordenado->cantidad <= $cantidad) {
                        $precio_cercano = $precio_ordenado;
                    } else {
                        break;
                    }
                }
                // Calcular el precio_producto basado en el promedio entre cantidad_producto y precio_unidad
                $detalle->producto->precio_unitario = number_format($precio_cercano->precio_unidad_medida_producto / $precio_cercano->cantidad_producto, 4);
            }
        }
        $pdf = Pdf::loadView('impresion_creditos', compact('credito'));
        $ruta_pdf = 'factura_credito_' . $credito->id_creditofiscal . '.pdf';
        $pdf->save($ruta_pdf);
        $command1 = ' ';//'PDFXEdit /importp "C:\setting_3060.dat" ';
        exec($command1, $output, $return_var);
        //$command2 = 'PDFXEdit /print:default=no;showui=no;printer="Canon G3060 series" ' . public_path($ruta_pdf);
        $command2 = '/PDFx-Editor/PDFXEdit.exe /print:default=no;showui=no;printer="Brother DCP-T720DW Printer" ' . public_path($ruta_pdf);
        exec($command2, $output1, $return_var1);
        return implode(',', $output) . ' ' . implode(',', $output1);
    }

    public function ver_factura(Request $request)
    {
        $venta = Venta::find(9);
        $venta->with('detalleVenta');
        foreach ($venta->detalleVenta as $detalle) {
            $detalle->with('producto');
            $cantidad = $detalle->cantidad_producto;
            // Ordenar $detalle->producto->precioUnidadDeMedida en forma ascendente
            $precios = $detalle->producto->precioUnidadDeMedida->sortBy('cantidad_producto');
            if ($precios->isEmpty()) {
                break;
            }
            // Obtener el primero
            $precio_cercano = $precios->first();
            if ($cantidad < $precio_cercano->cantidad_producto) {
                $detalle->producto->precio_unitario = $precio_cercano->precio_unidad_medida_producto;
                break;
            } else {
                foreach ($precios as $precio_ordenado) {
                    if ($precio_ordenado->cantidad_producto <= $cantidad) {
                        $precio_cercano = $precio_ordenado;
                    } else {
                        break;
                    }
                }
                // Calcular el precio_producto basado en el promedio entre cantidad_producto y precio_unidad
                $detalle->producto->precio_unitario = number_format($precio_cercano->precio_unidad_medida_producto / $precio_cercano->cantidad_producto, 4);
            }
        }
        return view('impresion_facturas')->with('venta', $venta);
    }

    public function ver_credito(Request $request)
    {
        $venta = CreditoFiscal::find(10);
        $venta->with('detalleCredito');
        foreach ($venta->detalleCredito as $detalle) {
            $detalle->with('producto');
            $cantidad = $detalle->cantidad_producto_credito;
            // Ordenar $detalle->producto->precioUnidadDeMedida en forma ascendente
            $precios = $detalle->producto->precioUnidadDeMedida->sortBy('cantidad_producto');
            if ($precios->isEmpty()) {
                break;
            }
            // Obtener el primero
            $precio_cercano = $precios->first();
            if ($cantidad < $precio_cercano->cantidad_producto) {
                $detalle->producto->precio_unitario = $precio_cercano->precio_unidad_medida_producto;
                break;
            } else {
                foreach ($precios as $precio_ordenado) {
                    if ($precio_ordenado->cantidad <= $cantidad) {
                        $precio_cercano = $precio_ordenado;
                    } else {
                        break;
                    }
                }
                // Calcular el precio_producto basado en el promedio entre cantidad_producto y precio_unidad
                $detalle->producto->precio_unitario = number_format($precio_cercano->precio_unidad_medida_producto / $precio_cercano->cantidad_producto, 4);
            }
        }
        return view('impresion_creditos')->with('credito', $venta);
    }

    //Ver detalle hoja de ruta
    public function ver_detalle_hoja_de_ruta(Request $request, int $id_hoja_de_ruta)
    {
        //$id_hoja_de_ruta = $request->id_hoja_de_ruta;
        
        $id_hoja_de_ruta = 1;
        
        /*$hoja_de_ruta = DB::table('hojaderuta')
        ->join('ventadomicilio', 'ventadomicilio.id_hr', '=', 'hojaderuta.id_hr')
        ->join('venta', 'ventadomicilio.id_venta', '=', 'venta.id_venta')
        ->select('hojaderuta.*', 'ventadomicilio.*', 'venta.*')
        //->find($id_hoja_de_ruta, 'hojaderuta.id_hr')
        ->where('hojaderuta.id_hr', '=', $id_hoja_de_ruta)
        ->get();*/

        $hoja_de_ruta = HojaDeRuta::with('ventadomicilio.venta')
        ->with('empleado')
        ->get();
        
        /*HojaDeRuta::find(1);
        ->with('creditoFiscalDomicilio')
        ->with('ventaDomicilio')
        ->with('venta')->with('empleado')->first();*/
        
        //$hoja_de_ruta = HojaDeRuta::with(['posts', 'comments', 'profile'])->get();

        return view('impresion_hoja_de_ruta')->with(['hoja_de_ruta' => $hoja_de_ruta]);
    }

    public function ver_hr_json (Request $request) {
        
        $hoja = HojaDeRuta::find(1);
        // $hoja->with('creditoFiscalDomicilio')->with('creditoFiscal')->with('cliente');
        // $hoja->with('ventaDomicilio')->with('venta')->with('empleado');
        
        foreach ($hoja->creditoFiscalDomicilio as $credito) {
            $credito->creditoFiscal;
            $credito->creditoFiscal->cliente;
        }

        foreach ($hoja->ventaDomicilio as $venta) {
            $venta->venta;
        }
        
        return response()->json($hoja);
    }

    public function ver_hr_blade (Request $request) {
        
        $hoja = HojaDeRuta::find(1);
        $hoja->empleado;
        // $hoja->with('creditoFiscalDomicilio')->with('creditoFiscal')->with('cliente');
        // $hoja->with('ventaDomicilio')->with('venta')->with('empleado');
        
        foreach ($hoja->creditoFiscalDomicilio as $credito) {
            $credito->creditoFiscal;
            $credito->creditoFiscal->cliente;
        }

        foreach ($hoja->ventaDomicilio as $venta) {
            $venta->venta;
        }
        
        return view('impresion_hoja_de_ruta')->with('hoja_de_ruta', $hoja);
    }

    public function generate_pdf_hoja_de_ruta($id_hr)
    {
        $hoja_de_ruta = HojaDeRuta::find($id_hr);
        
        $hoja_de_ruta->empleado;
        
        foreach ($hoja_de_ruta->creditoFiscalDomicilio as $credito) {
            $credito->creditoFiscal;
            $credito->creditoFiscal->cliente;
        }

        foreach ($hoja_de_ruta->ventaDomicilio as $venta) {
            $venta->venta;
        }
        
        $pdf = Pdf::loadView('impresion_hoja_de_ruta', compact('hoja_de_ruta'));
        $ruta_pdf = 'resumen_hoja_' . $hoja_de_ruta->id_hr . '.pdf';
        $pdf->save($ruta_pdf);

        $command1 = ' ';//'PDFXEdit /importp "C:\setting_3060.dat" ';
        exec($command1, $output, $return_var);
        $command2 = '/PDFx-Editor/PDFXEdit.exe /print:default=no;showui=no;printer="Brother DCP-T720DW Printer" ' . public_path($ruta_pdf);
        exec($command2, $output1, $return_var1);
        
        return implode(',', $output) . ' ' . implode(',', $output1);

        //return "ok";
    }

}
