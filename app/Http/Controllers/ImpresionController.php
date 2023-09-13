<?php

namespace App\Http\Controllers;

use App\Models\CreditoFiscal;
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

            $cantidad = $detalle->cantidad_producto;

            // Ordenar $detalle->producto->precioUnidadDeMedida en forma ascendente
            $precios = $detalle->producto->precioUnidadDeMedida->sortBy('cantidad_producto');
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
        $pdf = Pdf::loadView('impresion_facturas', compact('venta'));
        $ruta_pdf = 'factura_venta_' . $venta->id_venta . '.pdf';
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

    public function generate_pdf_credito_fiscal(CreditoFiscal $credito)
    {
        $credito->with('detalleVenta');
        foreach ($credito->detalleVenta as $detalle) {
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
        $pdf = Pdf::loadView('impresion_creditos', compact('credito'));
        $ruta_pdf = 'factura_credito_' . $credito->id_creditofiscal . '.pdf';
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
        // $pdf = Pdf::loadView('impresion_facturas', compact('venta'))->setOption(['defaultFont' => 'gabriele-l']);
        // return $pdf->download('archivo.pdf');
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
        // $pdf = Pdf::loadView('impresion_facturas', compact('venta'))->setOption(['defaultFont' => 'gabriele-l']);
        // return $pdf->download('archivo.pdf');
        return view('impresion_creditos')->with('credito', $venta);
    }
}
