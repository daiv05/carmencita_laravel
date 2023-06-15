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
        $ventaCF = Venta::with('detalleVenta', 'detalleVenta.producto')->findOrFail($id_venta);
        return response()->json(['ventaCF' => $ventaCF]);
    }

    public function obtenerCreditoAndDetalle($id_creditofiscal){
        $CFSales = CreditoFiscal::with('cliente','municipio.departamento','detallecredito.producto')->findOrFail($id_creditofiscal);
        return response()->json($CFSales);
    }
}
