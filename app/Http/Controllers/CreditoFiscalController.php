<?php

namespace App\Http\Controllers;

use App\Models\CreditoFiscal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DetalleCreditoController;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

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
        if ($creditoFiscal->estado_credito or !($creditoFiscal->domicilio)) {
            //Para validar que sea pedido a domicilio y que no este emitido
            $mensaje = 'Este pedido no se puede actualizar';
            if ($creditoFiscal->estado_credito) {
                $mensaje = 'Este pedido no se puede actualizar porque ya se ha emitido';
            }

            return response()->json([
                'respuesta' => false,
                'mensaje' => $mensaje
            ], 400);
        }

        $detalle_credito_controller = new DetalleCreditoController();

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
                'mensaje' => $validator->errors()->all(),
            ], 400);
        }

        //if ($request->validate($rules)) {
        $creditoFiscal->update($request->credito);
        $id_credito = $creditoFiscal->id_creditofiscal;
        $detallesActuales = $creditoFiscal->detalleCredito()->get(); //Obtiene los detalles actuales de la venta (detalles antes del update)
        foreach ($detallesActuales as $detalleActual) {
            $detalle_credito_controller->destroy($detalleActual);
        }

        return $detalle_credito_controller->register_detalle_credito($request, $id_credito);

        if (isset($creditoFiscal)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Credito fiscal actualizado correctamente',
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al actualizar el credito fiscal',
            ], 400);
        }
        //}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CreditoFiscal $creditoFiscal)
    {
        //
        $detalle_credito_controller = new DetalleCreditoController();

        if (isset($creditoFiscal)) {
            if ($creditoFiscal->estado_credito or !($creditoFiscal->domicilio)) {
                //Para validar que sea pedido a domicilio y que no este emitido

                $mensaje = 'Este pedido no se puede eliminar';
                if ($creditoFiscal->estado_credito) {
                    $mensaje = 'Este pedido no se puede eliminar porque ya se ha emitido';
                }

                return response()->json([
                    'respuesta' => false,
                    'mensaje' => $mensaje
                ], 200);
            }
            $detallesActuales = $creditoFiscal->detalleCredito()->get(); //Obtiene los detalles actuales de la venta (detalles antes del update)

            foreach ($detallesActuales as $detalleActual) {
                $detalle_credito_controller->destroy($detalleActual);
            }

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
            'total_credito' => 'required|decimal:0,4',
            'total_iva_credito' => 'required|decimal:0,4',
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
        $credito->domicilio = $request->domicilio;
        $credito->save();
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

    public function getCreditosFiscalesDomicilio(Request $request)
    {
        //funcion para obtener los creditos fiscales que no estan asignados a una hoja de ruta
        $date = $request->fecha;
        $creditos = DB::select("SELECT * FROM creditofiscal WHERE creditofiscal.domicilio = 1 and creditofiscal.id_creditofiscal NOT IN (SELECT id_creditofiscal FROM creditofiscaldomicilio) and creditofiscal.fecha_credito=:fecha", ['fecha' => $date]);

        foreach ($creditos as $credito) {
            $cliente = Cliente::where('id_cliente', $credito->id_cliente)->first();
            $credito->id_cliente = $cliente->distintivo_cliente;
        }

        if (isset($creditos)) {
            return response()->json([
                'status' => true,
                'creditos' => $creditos,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'no se encontraron pedidos'
            ], 400);
        }
    }
}