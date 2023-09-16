<?php

namespace App\Http\Controllers;

use App\Models\CreditoFiscal;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImpresionController extends Controller
{
    public function generate_pdf_consumidor_final($id_venta)
    {
        $venta = Venta::find($id_venta);
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
        $command1 = 'PDFXEdit /importp "C:\setting_3060.dat" ';
        exec($command1, $output, $return_var);
        $command2 = 'PDFXEdit /print:default=no;showui=no;printer="Canon G3060 series" ' . public_path($ruta_pdf);
        exec($command2, $output1, $return_var1);
        return implode(',', $output) . ' ' . implode(',', $output1);
    }

    public function generate_pdf_credito_fiscal($id_credito)
    {
        $credito = CreditoFiscal::find($id_credito);
        $credito->with('detalleCredito')->with('cliente')->with('municipio')->with('departamento');
        error_log($credito);
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
        $command1 = 'PDFXEdit /importp "C:\setting_3060.dat" ';
        exec($command1, $output, $return_var);
        $command2 = 'PDFXEdit /print:default=no;showui=no;printer="Canon G3060 series" ' . public_path($ruta_pdf);
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
}
