<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Venta;
use App\Models\Producto;
use Error;
use Illuminate\Support\Facades\Log;

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
            'codigo_barra_producto' => 'required|string|max:15',
            'cantidad_producto' => 'required|integer',
            'subtotal_detalle_venta' => 'required|decimal:0,2',
            'descuentos' => 'nullable|decimal:0,2',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all(),
            ], 400);
        }

        if ($request->validate($rules)) {


            //Validamos si existe la venta
            $venta = Venta::find($request->id_venta);
            if (!isset($venta)) {
                error_log('Venta no encontrada');
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'No existe la venta',
                ], 400);
            }


            //Validamos si existe el producto y luego si hay stock
            $producto = Producto::find($request->codigo_barra_producto);
            if (!isset($producto)) {
                error_log('Producto no encontrado');
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'No existe el producto: ' . $request->codigo_barra_producto,
                ], 400);
            }
            if ($producto->cantidad_producto_disponible < $request->cantidad_producto) {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'No hay stock suficiente para: ' . $producto->nombre_producto,
                ], 400);
            }


            $detalleVenta = DetalleVenta::create($request->all());
            if (isset($detalleVenta)) {
                error_log('Detalle creado correctamente');
                // Actualizar stock del producto
                //$producto->cantidad_producto_disponible = $producto->cantidad_producto_disponible - $detalleVenta->cantidad_producto;
                //$producto->update(['cantidad_producto_disponible' => $producto->cantidad_producto_disponible]);
                $producto->updateExistencias($detalleVenta->cantidad_producto, true);
                //Log::info('Stock actualizado: '. $request->cantidad_producto);
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Detalle de venta creado correctamente',
                ], 201);
            } else {
                error_log('Error al crear el detalle de venta');
                // En caso de error, eliminar el registro de venta creado
                $venta = Venta::find($request->id_venta);
                $venta->delete();
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
        if (isset($detalleVenta)) {
            // Retornar detalle de venta con su respectivo producto y venta
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Detalle de Venta encontrada',
                // Retorna el detalle de venta solicitado con su respectivo producto y venta
                'datos' => $detalleVenta->load('producto', 'venta'),
            ], 200);
        } else {
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
            'id_venta' => 'nullable|integer',
            'codigo_barra_producto' => 'nullable|string|max:15',
            'cantidad_producto' => 'nullable|integer',
            'subtotal_detalle_venta' => 'nullable|decimal:0,2',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all(),
            ], 400);
        } else {
            if ($request->validate($rules)) {
                try {
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
            // Actualizar stock del producto
            $producto = Producto::find($detalleVenta->codigo_barra_producto);
            //$producto->cantidad_producto_disponible = $producto->cantidad_producto_disponible + $detalleVenta->cantidad_producto;
            //$producto->update(['cantidad_producto_disponible' => $producto->cantidad_producto_disponible]);
            $producto->updateExistencias($detalleVenta->cantidad_producto,false);
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




    public function register_detalle_venta(Request $request, int $id_venta)
    {
        //
        $rules = [
            'id_venta' => 'required|integer',
            'codigo_barra_producto' => 'required|string|max:15',
            'cantidad_producto' => 'required|integer',
            'subtotal_detalle_venta' => 'required|decimal:0,2',
            'descuentos' => 'nullable|decimal:0,2',
        ];

        for ($i = 0; $i < count($request->detalles); $i++) {
            $validator = Validator::make($request->detalles[$i], $rules);

            if ($validator->fails()) {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => $validator->errors()->all(),
                ], 400);
            }
            //Validamos si existe la venta
            $venta = Venta::find($id_venta);
            error_log($venta);
            if (!isset($venta)) {
                error_log('Venta no encontrada');
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'No existe la venta',
                ], 400);
            }
            //Validamos si existe el producto y luego si hay stock
            $producto = Producto::find($request->detalles[$i]['codigo_barra_producto']);
            if (!isset($producto)) {
                error_log('Producto no encontrado');
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'No existe el producto',
                ], 400);
            } else {
                if ($producto->getExistencias() < $request->detalles[$i]['cantidad_producto']) {
                    error_log('No hay stock suficiente');
                    return response()->json([
                        'respuesta' => false,
                        'mensaje' => 'Stock insuficiente: ' . $producto->nombre_producto. ' (' . $producto->cantidad_producto_disponible . ') Unidades disponibles',
                    ], 400);
                }
            }

            //Crear detalle de venta con id de venta del request
            $detalleVenta = DetalleVenta::create([
                'id_venta' => $id_venta,
                'codigo_barra_producto' => $request->detalles[$i]['codigo_barra_producto'],
                'cantidad_producto' => $request->detalles[$i]['cantidad_producto'],
                'subtotal_detalle_venta' => $request->detalles[$i]['subtotal_detalle_venta'],
                'descuentos' => $request->detalles[$i]['descuentos'],
            ]);
            $detalleVenta->save();

            error_log("el detalle de venta es: \n");
            error_log($detalleVenta);

            if (isset($detalleVenta)) {
                error_log('Detalle creado correctamente');
                // Actualizar stock del producto
                //$producto->cantidad_producto_disponible = $producto->cantidad_producto_disponible - $detalleVenta->cantidad_producto;
                //$producto->update(['cantidad_producto_disponible' => $producto->cantidad_producto_disponible]);
                
                $producto->updateExistencias($detalleVenta->cantidad_producto,true);
                
                //Log::info('Stock actualizado: '. $request->cantidad_producto);
            } else {
                error_log('Error al crear el detalle de venta');
                // En caso de error, eliminar el registro de venta creado
                $venta->delete();
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al crear el detalle de venta',
                ], 400);
            }
        }
        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Detalle de venta creado correctamente',
        ], 201);
    }
}
