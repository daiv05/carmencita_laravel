<?php

namespace App\Http\Controllers;

use App\Models\DetalleCredito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'codigo_barra_producto' => 'required|string|max:10',
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
            $detalleCredito = DetalleCredito::create($request->all());
            if (isset($detalleCredito)) {
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
                'datos' => $detalleCredito
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
            'codigo_barra_producto' => 'string|max:10',
            'id_creditofiscal' => 'integer',
            'cantidad_producto_credito' => 'integer',
            'subtotal_detalle_credito' => 'decimal:0,2'
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
}
