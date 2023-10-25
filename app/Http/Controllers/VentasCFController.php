<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\CreditoFiscal;
use App\Models\DetalleCredito;
use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\Municipio;

class VentasCFController extends Controller
{
    //Para traer todas las ventas
    public function index()
    {
        $ventasCF = Venta::all();
        return response()->json(['ventasCF' => $ventasCF]);
    }

    //Para traer todos los creditos fiscal
    public function indexCF()
    {
        $CFSales = CreditoFiscal::with('cliente')->get();
        return response()->json(['CFSales' => $CFSales]);
    }

    //Para buscar una venta en especifica
    public function buscarVentaCF(Request $request)
    {
        $ventasCF = Venta::where('id_venta', 'like', '%' . $request->q . '%')
            ->orWhere('fecha_venta', 'like', '%' . $request->q . '%')->get();
        return response()->json(['ventasCF' => $ventasCF]);
    }

    //Para buscar un credito fiscal en especifico
    public function buscarCreditoF(Request $request){
        $CFSales = CreditoFiscal::where('id_creditofiscal', 'like', '%' . $request->q . '%')
            ->orWhere('fecha_credito', 'like', '%' . $request->q . '%')
            ->orWhereHas('cliente', function ($query) use ($request) {
                $query->where('nrc_cliente', 'like', '%' . $request->q . '%');
            })
            ->orWhereHas('cliente', function ($query) use ($request) {
                $query->where('distintivo_cliente', 'like', '%' . $request->q . '%');
            })->with('cliente')->get();

        return response()->json(['CFSales' => $CFSales]);
    }

    public function eliminarVentaCF($id_venta)
    {
        $ventaCF = Venta::findOrFail($id_venta);
        $ventaCF->detalleVenta()->delete();
        $ventaCF->delete();
        return "Venta eliminada";
    }

    public function obtenerVentaAndDetalle($id_venta){
        $ventaCF = Venta::with('detalleVenta', 'detalleVenta.producto','detalleVenta.producto.precioUnidadDeMedida','ventaDomicilio')->findOrFail($id_venta);
        return response()->json(['ventaCF' => $ventaCF]);
    }

    public function obtenerCreditoAndDetalle($id_creditofiscal){
        $CFSales = CreditoFiscal::with('cliente.municipio','cliente.municipio.departamento','detallecredito.producto', 'detallecredito.producto.precioUnidadDeMedida','creditoFiscalDomicilio')->findOrFail($id_creditofiscal);
        return response()->json($CFSales);
    }

    //Método para actualizar el estado de una venta
    public function updateEstado(Venta $ventaCF)
    {
        //$producto = Producto::find($producto->codigo_barra_producto);

        if($ventaCF->estado_venta)
        {
            $ventaCF->estado_venta = false;
            $this->update_existencias_venta($ventaCF, false);
        }
        else
        {
            $ventaCF->estado_venta = true;
            $this->update_existencias_venta($ventaCF, true);
        }

        $ventaCF->update();

        return response()->json([
            'status'=>true,
            'estado_venta'=>$ventaCF->estado_venta,
        ]);        
        
    }

        //Método para actualizar el estado de un credito fiscal
        public function updateEstadoCredito(CreditoFiscal $CFSales)
        {
            //$producto = Producto::find($producto->codigo_barra_producto);
    
            if($CFSales->estado_credito)
            {
                $CFSales->estado_credito = false;

                $this->update_existencias_credito($CFSales, false);
            }
            else
            {
                $CFSales->estado_credito = true;
                $this->update_existencias_credito($CFSales, true);
            }
    
            $CFSales->update();
    
            return response()->json([
                'status'=>true,
                'estado_credito'=>$CFSales->estado_credito,
            ]);        
            
        }

        public function update_existencias_venta(Venta $venta, $salida){
            foreach($venta->detalleVenta as $detalle){
                $producto = Producto::findOrFail($detalle->codigo_barra_producto);
                $producto->updateExistencias($detalle->cantidad_producto, $salida);
            }
        }

        public function update_existencias_credito(CreditoFiscal $credito, $salida){
            foreach($credito->detallecredito as $detalle){
                $producto = Producto::findOrFail($detalle->codigo_barra_producto);
                $producto->updateExistencias($detalle->cantidad_producto_credito, $salida);
            }
        }
}
