<?php

namespace App\Http\Controllers;

use App\Models\DetalleCredito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CreditoFiscal;
use App\Models\Producto;

class DetalleCreditoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Retornar listado de detalles de credito fiscal junto con el credito fiscal y producto
        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Lista de detalles de credito fiscal',
            'datos' => DetalleCredito::with('creditoFiscal', 'producto')->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'codigo_barra_producto' => 'required|string|max:13',
            'id_creditofiscal' => 'required|integer',
            'cantidad_producto_credito' => 'required|integer',
            'subtotal_detalle_credito' => 'required|decimal:0,2'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all()
            ], 400);
        }

        if ($request->validate($rules)) {

            //Validamos si existe el credito fiscal
            $creditoFiscal = CreditoFiscal::find($request->id_creditofiscal);
            if (!isset($creditoFiscal)) {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'No existe el credito fiscal'
                ], 400);
            }

            //Validamos si existe el producto y luego verificamos si tiene stock
            $producto = Producto::find($request->codigo_barra_producto);
            if (!isset($producto)) {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'No existe el producto'
                ], 400);
            }
            
            if ($producto->cantidad_producto_disponible < $request->cantidad_producto_credito) {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'No hay stock suficiente para: '. $producto->nombre_producto,
                ], 400);
            }


            $detalleCredito = DetalleCredito::create($request->all());
            if (isset($detalleCredito)) {
                // Actualizar stock del producto
                //$producto->cantidad_producto_disponible = $producto->cantidad_producto_disponible - $request->cantidad_producto;
                //$producto->update(['cantidad_producto_disponible' => $producto->cantidad_producto_disponible]);
                
                $producto->updateExistencias($detalleCredito->cantidad_producto_credito,true);
                
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Detalle de credito fiscal creado correctamente'
                ], 201);
            } else {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al crear el detalle de credito fiscal'
                ], 400);
            }
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(DetalleCredito $detalleCredito)
    {
        //Validar si existe el detalle de credito fiscal
        if (isset($detalleCredito)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Detalle de credito fiscal encontrado',
                'datos' => $detalleCredito->load('creditoFiscal', 'producto')
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Detalle de credito fiscal no encontrado'
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetalleCredito $detalleCredito)
    {
        //
        $rules = [
            'codigo_barra_producto' => 'string|max:13',
            'id_creditofiscal' => 'integer',
            'cantidad_producto_credito' => 'integer',
            'subtotal_detalle_credito' => 'decimal:0,2',
            'descuentos' => 'decimal:0,2',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all()
            ], 400);
        }

        if ($request->validate($rules)) {
            $detalleCredito->update($request->all());
            if (isset($detalleCredito)) {
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Detalle de credito fiscal actualizado correctamente'
                ], 201);
            } else {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al actualizar el detalle de credito fiscal'
                ], 400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetalleCredito $detalleCredito)
    {
        //
        if (isset($detalleCredito)) {
            $detalleCredito->delete();
            // Actualizar stock del producto
            $producto = Producto::find($detalleCredito->codigo_barra_producto);
            //$producto->cantidad_producto_disponible = $producto->cantidad_producto_disponible + $detalleCredito->cantidad_producto;
            //$producto->update(['cantidad_producto_disponible' => $producto->cantidad_producto_disponible]);
            $producto->updateExistencias($detalleCredito->cantidad_producto_credito,false);
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Detalle de credito fiscal eliminado correctamente'
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al eliminar el detalle de credito fiscal'
            ], 400);
        }
    }

    public function register_detalle_credito(Request $request, int $id_credito)
    {
        //
        $rules = [
            'codigo_barra_producto' => 'required|string|max:13',
            'id_creditofiscal' => 'required|integer',
            'cantidad_producto_credito' => 'required|integer',
            'subtotal_detalle_credito' => 'required|decimal:0,2',
            'descuentos' => 'decimal:0,2',
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
            $credito = CreditoFiscal::find($id_credito);
            error_log($credito);
            if (!isset($credito)) {
                error_log('Credito no encontrado');
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'No existe el Credito Fiscal',
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
                if ($producto->getExistencias() < $request->detalles[$i]['cantidad_producto_credito']) {
                    error_log('No hay stock suficiente');
                    return response()->json([
                        'respuesta' => false,
                        'mensaje' => 'Stock insuficiente: ' . $producto->nombre_producto. ' (' . $producto->cantidad_producto_disponible . ') Unidades disponibles',
                    ], 400);
                }
            }

            //Crear detalle de credito con id de credito del request
            $detalle = DetalleCredito::create([
                'id_creditofiscal' => $id_credito,
                'codigo_barra_producto' => $request->detalles[$i]['codigo_barra_producto'],
                'cantidad_producto_credito' => $request->detalles[$i]['cantidad_producto_credito'],
                'subtotal_detalle_credito' => $request->detalles[$i]['subtotal_detalle_credito'],
                'descuentos' => $request->detalles[$i]['descuentos'],
            ]);
            $detalle->save();

            error_log("el detalle de credito es: \n");
            error_log($detalle);

            if (isset($detalle)) {
                error_log('Detalle creado correctamente');
                // Actualizar stock del producto
                //$producto->cantidad_producto_disponible = $producto->cantidad_producto_disponible - $detalle->cantidad_producto_credito;
                //$producto->update(['cantidad_producto_disponible' => $producto->cantidad_producto_disponible]);
                $producto->updateExistencias($detalle->cantidad_producto_credito,true);
                //Log::info('Stock actualizado: '. $request->cantidad_producto);
            } else {
                error_log('Error al crear el detalle de credito');
                // En caso de error, eliminar el registro de credito creado
                $credito->delete();
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al crear el detalle de credito',
                ], 400);
            }
        }
        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Detalle de credito creado correctamente',
        ], 201);
    }
}
