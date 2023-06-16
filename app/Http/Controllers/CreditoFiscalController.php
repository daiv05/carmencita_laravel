<?php

namespace App\Http\Controllers;

use App\Models\CreditoFiscal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DetalleCreditoController;
use App\Models\Cliente;

class CreditoFiscalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retornar listado de creditos fiscales
        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Lista de creditos fiscales',
            'datos' => CreditoFiscal::with('cliente')->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'id_cliente' => 'required|integer',
            'fecha_credito' => 'required|date',
            'total_credito' => 'required|decimal:0,2',
            'total_iva_credito' => 'required|decimal:0,2',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all(),
            ], 400);
        }

        if ($request->validate($rules)) {
            $creditoFiscal = CreditoFiscal::create($request->all());
            if (isset($creditoFiscal)) {
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Credito fiscal creado correctamente',
                    'datos' => $creditoFiscal->id_creditofiscal,
                ], 201);
            } else {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al crear el credito fiscal',
                ], 400);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CreditoFiscal $creditoFiscal)
    {
        // Validar si existe el credito fiscal
        if (isset($creditoFiscal)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Credito fiscal encontrado',
                'datos' => $creditoFiscal->load('cliente')
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Credito fiscal no encontrado',
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CreditoFiscal $creditoFiscal)
    {
        //
        $rules = [
            'id_cliente' => 'integer',
            'fecha_credito' => 'date',
            'total_credito' => 'decimal:0,2',
            'total_iva_credito' => 'decimal:0,2',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all(),
            ], 400);
        }

        if ($request->validate($rules)) {
            $creditoFiscal->update($request->all());
            if (isset($creditoFiscal)) {
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Credito fiscal actualizado correctamente',
                ], 201);
            } else {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al actualizar el credito fiscal',
                ], 400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CreditoFiscal $creditoFiscal)
    {
        //
        if (isset($creditoFiscal)) {
            $creditoFiscal->delete();
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Credito fiscal eliminado correctamente',
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al eliminar el credito fiscal',
            ], 400);
        }
    }



    public function register_credito_detalle(Request $request)
    {
        $rules = [
            'id_cliente' => 'required|integer',
            'fecha_credito' => 'required|date',
            'total_credito' => 'required|decimal:0,2',
            'total_iva_credito' => 'required|decimal:0,2',
        ];

        $validator = Validator::make($request->credito, $rules);
        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all()
            ], 400);
        }

        // Validar que exista el cliente
        $cliente = Cliente::find($request->credito['id_cliente']);
        if (!isset($cliente)) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'El cliente no existe'
            ], 400);
        }

        $credito = CreditoFiscal::create($request->credito);
        if (isset($credito)) {
            $detalle_credito = new DetalleCreditoController();
            return $detalle_credito->register_detalle_credito($request, $credito->id_creditofiscal);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al crear el credito',
            ], 400);
        }
    }
}
