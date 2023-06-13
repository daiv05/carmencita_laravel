<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;

class VentasCFController extends Controller
{
    public function index()
    {
        $ventasCF = Venta::all();
        return response()->json(['ventasCF' => $ventasCF]);
    }

    public function buscarVentaCF(Request $request)
    {
        $ventasCF = Venta::where('id_venta', 'like', '%' . $request->q . '%')
            ->orWhere('fecha_venta', 'like', '%' . $request->q . '%')->get();
        return response()->json(['ventasCF' => $ventasCF]);
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
}
