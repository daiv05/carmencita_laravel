<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetalleVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retornar listado de detalles de venta con sus respectivos productos y ventas
        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Lista de detalles de venta',
            'datos' => DetalleVenta::with('producto', 'venta')->get(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'id_venta' => 'required|integer',
            'codigo_barra_producto' => 'required|string|max:10',
            'cantidad_producto' => 'required|integer',
            'subtotal_detalle_venta' => 'required|decimal:0,2',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all(),
            ], 400);
        }

        if ($request->validate($rules)) {
            $detalleVenta = DetalleVenta::create($request->all());
            if (isset($detalleVenta)) {
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Detalle de venta creado correctamente',
                ], 201);
            } else {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al crear el detalle de venta',
                ], 400);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DetalleVenta $detalleVenta)
    {
        //Validar si existe el registro
        if (isset($detalleVenta)){
            // Retornar detalle de venta con su respectivo producto y venta
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Detalle de Venta encontrada',
                // Retorna el detalle de venta solicitado con su respectivo producto y venta
                'datos' => $detalleVenta->load('producto', 'venta'),
            ], 200);
        }
        else{
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Detalle de Venta no encontrada',
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetalleVenta $detalleVenta)
    {
        //
        $rules = [
            'id_venta' => 'integer',
            'codigo_barra_producto' => 'string|max:10',
            'cantidad_producto' => 'integer',
            'subtotal_detalle_venta' => 'decimal:0,2',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all(),
            ], 400);
        } else {
            if ($request->validate($rules)) {
                try{
                    // Actualizar detalle de venta, no permitiendo que los campos sean nulos
                    $detalleVenta->update($request->all());
                } catch (\Exception $e) {
                    error_log($e);
                    return response()->json([
                        'respuesta' => false,
                        'mensaje' => 'Error al actualizar el detalle de venta',
                    ], 400);
                }
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Detalle de venta actualizado correctamente',
                ], 201);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetalleVenta $detalleVenta)
    {
        //
        if (isset($detalleVenta)) {
            $detalleVenta->delete();
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Detalle de venta eliminado correctamente',
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al eliminar el detalle de venta',
            ], 400);
        }
    }
}
