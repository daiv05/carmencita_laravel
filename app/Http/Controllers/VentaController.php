<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\VentaDomicilio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DetalleVentaController;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\DetalleVenta;
use App\Models\Producto;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Lista de ventas',
            'datos' => Venta::all(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $rules = [
            // fecha_venta en formato dd-mm-aaaa
            'fecha_venta' => 'required|date',
            'total_venta' => 'required|decimal:0,2',
            'total_iva' => 'required|decimal:0,2',
            'nombre_cliente_venta' => 'nullable|string|max:30',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all()
            ], 400);
        }
        if ($request->validate($rules)) {
            $venta = Venta::create($request->all());
            if (isset($venta)) {
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Venta creada correctamente',
                    'datos' => $venta->id_venta,
                ], 201);
            } else {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al crear la venta',
                ], 400);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        //Validar si existe el registro
        if (isset($venta)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Venta encontrada',
                'datos' => $venta,
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Venta no encontrada',
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venta $venta)
    {
        if ($venta->estado_venta or !($venta->domicilio)) {
            //Para validar que sea pedido a domicilio y que no este emitido
            $mensaje = 'Este pedido no se puede actualizar';
            if ($venta->estado_venta) {
                $mensaje = 'Este pedido no se puede actualizar porque ya se ha emitido';
            }

            return response()->json([
                'respuesta' => false,
                'mensaje' => $mensaje
            ], 400);
        }
        $detalle_venta_controller = new DetalleVentaController();

        $rules = [
            // fecha_venta en formato dd-mm-aaaa
            'fecha_venta' => 'required|date',
            'total_venta' => 'required|decimal:0,2',
            'total_iva' => 'required|decimal:0,2',
            'nombre_cliente_venta' => 'nullable|string|max:30',
        ];

        $validator = Validator::make($request->venta, $rules);
        
        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all()
            ], 400);
        }
        
        //Para validar que la fecha no se modifique si ya esta asignada a hoja de ruta
        $datosNuevosVenta = $request->venta;
        $asignada = VentaDomicilio::where('id_venta',$venta->id_venta)->exists();
        if($asignada and ($request->venta["fecha_venta"] != $venta->fecha_venta)){
            $datosNuevosVenta["fecha_venta"] = $venta->fecha_venta;
        }

        $venta->update($datosNuevosVenta);
        $detallesActuales = $venta->detalleVenta()->get(); //Obtiene los detalles actuales de la venta (detalles antes del update)
        foreach ($detallesActuales as $detalleActual) {
            $detalle_venta_controller->destroy($detalleActual);
        }

        return $detalle_venta_controller->register_detalle_venta($request, $venta->id_venta);

        if (isset($venta)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Venta actualizada correctamente',
            ], 201);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al actualizar la venta',
            ], 400);
        }
        //}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        try {

            $detalle_venta_controller = new DetalleVentaController();

            if (isset($venta)) {

                if ($venta->estado_venta or !($venta->domicilio)) {
                    //Para validar que sea pedido a domicilio y que no este emitido
                    $mensaje = 'Este pedido no se puede eliminar';
                    if ($venta->estado_venta) {
                        $mensaje = 'Este pedido no se puede eliminar porque ya se ha emitido';
                    }

                    return response()->json([
                        'respuesta' => false,
                        'mensaje' => $mensaje
                    ], 200);
                }
                
                $asignada = VentaDomicilio::where('id_venta',$venta->id_venta)->exists();
                if($asignada){
                    return response()->json([
                        'respuesta' => false,
                        'mensaje' => 'El pedido no se puede eliminar porque ya esta asignado a una hoja de ruta'
                    ], 200);
                }
                
                $detallesActuales = $venta->detalleVenta()->get();
                foreach ($detallesActuales as $detalleActual) {
                    $detalle_venta_controller->destroy($detalleActual);
                }

                $venta->delete();

                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Venta eliminada correctamente',
                    'detalles' => $detallesActuales,
                    'venta' => $venta
                ], 200);

            } else {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al eliminar la venta',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $e->getMessage(),
            ], 400);
        }
    }


    public function register_venta_detalle(Request $request)
    {
        //
        $rules = [
            // fecha_venta en formato dd-mm-aaaa
            'fecha_venta' => 'required|date',
            'total_venta' => 'required|decimal:0,4',
            'total_iva' => 'required|decimal:0,4',
            'nombre_cliente_venta' => 'nullable|string|max:30'
        ];
        $validator = Validator::make($request->venta, $rules);
        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all()
            ], 400);
        }

        $venta = Venta::create($request->venta);
        $venta->domicilio = $request->domicilio;
        $venta->estado_venta = !$request->domicilio;
        $venta->save();
        if (isset($venta)) {
            $detalle_venta = new DetalleVentaController();
            $validar = $detalle_venta->register_detalle_venta($request, $venta->id_venta);
            if ($validar->getStatusCode() == 201) {
                if (!$venta->domicilio) {
                    $impresion_service = new ImpresionController();
                    $impresion_service->generate_pdf_consumidor_final($venta);
                    return response()->json([
                        'respuesta' => true,
                        'mensaje' => 'Venta creada correctamente',
                        'datos' => $venta,
                        "hoy" => $impresion_service->generate_pdf_consumidor_final($venta)
                    ], 201);
                }
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Venta creada correctamente',
                    'datos' => $venta,
                ], 201);
            } else {
                return $validar;
            }
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al crear la venta',
            ], 400);
        }
    }

    public function getVentasDomicilio(Request $request)
    {

        $today = now()->format('Y-m-d');
        $date = $request->fecha;
        //$ventas = Venta::where('fecha_venta',$date)->get();
        $ventas = DB::select("SELECT * FROM venta WHERE venta.domicilio = 1 and venta.id_venta NOT IN (SELECT id_venta FROM ventadomicilio) and venta.fecha_venta=:fecha_venta", ['fecha_venta' => $date]);
        if (isset($ventas)) {
            return response()->json([
                'status' => true,
                'facturas' => $ventas,
                'fecha' => $date
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'no se encontraron pedidos'
            ], 400);
        }
    }

    public function getPedidos(Request $request){

        $queryBaseVentas = "select 'Factura' as tipo,venta.estado_venta as estado, venta.id_venta as id,nombre_cliente_venta as cliente ,fecha_venta as fecha, total_venta as total,hojaderuta.id_hr as hr from venta left join ventadomicilio on ventadomicilio.id_venta = venta.id_venta
        left join hojaderuta on hojaderuta.id_hr = ventadomicilio.id_hr where venta.domicilio = 1"; //obtiene todas las facturas 
        $ventasNoAsignadas = " and venta.id_venta not in (SELECT id_venta from ventadomicilio)"; // agrega la condicion para mostrar solo las no asignadas
        $ventasAsignadas = " and venta.id_venta in (SELECT id_venta from ventadomicilio)"; // agrega la condicion para mostrar solo las asignadas
        $ventasFecha = " venta.fecha_venta=:fecha_venta";

        $queryBaseCreditos = " select 'Credito Fiscal'as tipo,creditofiscal.estado_credito as estado,creditofiscal.id_creditofiscal as id, id_cliente as cliente, fecha_credito as fecha,total_credito as total, hojaderuta.id_hr as hr from creditofiscal left join creditofiscaldomicilio on creditofiscaldomicilio.id_creditofiscal=creditofiscal.id_creditofiscal 
        left join hojaderuta on hojaderuta.id_hr = creditofiscaldomicilio.id_hr where creditofiscal.domicilio=1";
        $creditosNoAsignados = " and creditofiscal.id_creditofiscal not in (SELECT id_creditofiscal from creditofiscaldomicilio)";
        $creditosFecha = " fecha_credito=:fecha_credito";
        $creditosAsignados = " and creditofiscal.id_creditofiscal in (SELECT id_creditofiscal from creditofiscaldomicilio)";
        $orderby = ' order by id';
        $queryFinal = "";

        if (!isset($request->tipo)) {
            $request->tipo = 'all';
        }

        if ($request->tipo == 'factura' or $request->tipo == 'all') {
            $queryFinal = $queryBaseVentas;
            $whereFactura = false; // para controlar cuando se asigne un where a la query
            if ($request->estado == 'asignadas') {
                $queryFinal .= $ventasAsignadas;
                $whereFactura = true;
            } else if ($request->estado == 'no_asignadas') {
                $queryFinal .= $ventasNoAsignadas;
                $whereFactura = true;
            }
            if (isset($request->fecha)) {
                if ($whereFactura) {
                    $queryFinal .= " and" . $ventasFecha;
                } else {
                    $queryFinal .= " and" . $ventasFecha;
                }
            }
            if ($request->tipo == 'all') {
                $queryFinal .= " union";
            }
        }
        if ($request->tipo == 'credito' or $request->tipo == 'all') {
            $queryFinal .= $queryBaseCreditos;
            $whereCredito = false;
            if ($request->estado == 'asignadas') {
                $queryFinal .= $creditosAsignados;
                $whereCredito = true;
            } else if ($request->estado == 'no_asignadas') {
                $queryFinal .= $creditosNoAsignados;
                $whereCredito = true;
            }

            if (isset($request->fecha)) {
                if ($whereCredito) {
                    $queryFinal .= " and" . $creditosFecha;
                } else {
                    $queryFinal .= " and" . $creditosFecha;
                }
            }
        }

        $queryFinal .= $orderby;

        if (isset($request->fecha)) {
            if ($request->tipo == 'all') {
                $pedidos = DB::select($queryFinal, ['fecha_venta' => $request->fecha, 'fecha_credito' => $request->fecha]);
            } else if ($request->tipo == 'factura') {
                $pedidos = DB::select($queryFinal, ['fecha_venta' => $request->fecha]);
            } else {
                $pedidos = DB::select($queryFinal, ['fecha_credito' => $request->fecha]);
            }
        } else {
            $pedidos = DB::select($queryFinal);
        }

        foreach ($pedidos as $pedido) {
            if ($pedido->tipo == 'Credito Fiscal') {
                $cliente = Cliente::where('id_cliente', $pedido->cliente)->first();
                if (isset($cliente)) {
                    $pedido->cliente = $cliente->distintivo_cliente;
                }
            }

        }

        $perPage = 15;
        $currentPage = request("page") ?? 1;
        //$offset = ($currentPage - 1) * $perPage;

        $pagination = new LengthAwarePaginator(
            array_slice($pedidos, ($currentPage - 1) * $perPage, $perPage),
            count($pedidos),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        if (isset($pedidos)) {
            return response()->json([
                'status' => true,
                'pedidos' => $pedidos,
                'pagination' => $pagination
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'no se encontraron pedidos'
            ], 400);
        }
    }
}