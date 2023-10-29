<?php

namespace App\Http\Controllers;

use App\Models\HojaDeRuta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HojaDeRutaController extends Controller
{
    public function index()
    {
        $hojas = HojaDeRuta::with('ventaDomicilio')->with('creditoFiscalDomicilio')->with('empleado')->get();

        foreach ($hojas as $hoja) {
            if ($hoja->ventaDomicilio) {
                foreach ($hoja->ventaDomicilio as $vd) {
                    $vd->venta;
                }
            }
            if ($hoja->creditoFiscalDomicilio) {
                foreach ($hoja->creditoFiscalDomicilio as $cfd) {
                    $cfd->credito_fiscal;
                }
            }
        }

        return response()->json([
            'hojas' => $hojas,
        ], 201);
    }

    public function show($id)
    {
        $hr = HojaDeRuta::where('id_hr', $id)->with('ventaDomicilio')->with('creditoFiscalDomicilio')->with('empleado')->get();
        if ($hr == null) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe la Hoja de Ruta',
            ], 201);
        }

        if ($hr[0]->ventaDomicilio) {
            foreach ($hr[0]->ventaDomicilio as $vd) {
                $vd->venta;
            }
        }
        if ($hr[0]->creditoFiscalDomicilio) {
            foreach ($hr[0]->creditoFiscalDomicilio as $cfd) {
                $cfd->creditoFiscal;
                $cfd->creditoFiscal->cliente;
            }
        }

        return response()->json([
            'hoja' => $hr[0],
        ], 201);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->hoja_de_ruta, [
            'fecha_entrega' => 'required',
            'id_empleado' => 'required',
            'total' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all()
            ],400);
        }

        $hojaDeRuta = HojaDeRuta::create($request->hoja_de_ruta);

        if (isset($hojaDeRuta)) {
            $ventaDomicilio = new VentaDomicilioController();
            $ventaDomicilio->register_ventaDomicilio($request, $hojaDeRuta->id_hr);
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Hoja de Ruta guardada correctamente.'
            ]);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => "Error al crear la Hoja de Ruta",
            ], 400);
        }
    }

    public function obtenerHojasDeRutasPaginadasFiltro(Request $request)
    {
        /*$hojas = 
        HojaDeRuta::with('ventaDomicilio')->with('creditoFiscalDomicilio')->with('empleado')->paginate(10);*/
        $parametrosConsulta = $request->all();
        $resultados = HojaDeRuta::with('empleado');
        $condiciones = $this->construirCondiciones(
            isset($parametrosConsulta["fechaEntrega"]) ? $parametrosConsulta["fechaEntrega"] : null,
            isset($parametrosConsulta["estaEntregado"]) ? $parametrosConsulta["estaEntregado"] : null
        );
        if (count($condiciones) > 0) {
            $resultados->where(
                function ($query) use ($condiciones) {
                    foreach ($condiciones as $condicion) {
                        $query->whereRaw($condicion);
                    }
                }
            );
        }
        $resultados->orderBy("fecha_entrega", "desc");
        return $resultados->paginate(10);
        /*$resultados = [];
        $condiciones = $this->construirCondiciones(
            isset($parametrosConsulta["fechaEntrega"])?$parametrosConsulta["fechaEntrega"]:null);
            
        if(isset($parametrosConsulta["tipo"])){
            if($parametrosConsulta["tipo"] == "Consumidor final"){
                $resultados = DB::table('hojaderuta')
                ->select('hojaderuta.id_hr', 'hojaderuta.fecha_entrega', 'hojaderuta.total', DB::raw("'Consumidor Final' as tipo"))
                ->join('ventadomicilio', 'hojaderuta.id_hr', '=', 'ventadomicilio.id_hr')
                ->join('venta', 'venta.id_venta', '=', 'ventadomicilio.id_venta');    
            }
            else if($parametrosConsulta["tipo"] == "Crédito Fiscal"){
                $resultados = DB::table('hojaderuta')
                ->select('hojaderuta.id_hr', 'hojaderuta.fecha_entrega', 'hojaderuta.total', DB::raw("'Crédito Fiscal' as tipo"))
                ->join('creditofiscaldomicilio', 'creditofiscaldomicilio.id_hr', '=', 'hojaderuta.id_hr')
                ->join('creditofiscal', 'creditofiscal.id_creditofiscal', '=', 'creditofiscaldomicilio.id_creditofiscal');
            }
        }
        if(count($condiciones) > 0){
            $resultados->where(
                function($query) use ($condiciones){
                    foreach($condiciones as $condicion){
                        $query->whereRaw($condicion);
                    }
                }
            );
        }
        $resultados = $resultados->paginate(5);*/
        //->where("hojaderuta.fecha_entrega","=","10290-90-10")
        //->paginate(10); 


        //return $resultados;
    }

    public function marcarEntregada($id)
    {
        $hoja = HojaDeRuta::find($id);
        if ($hoja == null) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => "No existe la hoja de ruta",
            ], 400);
        }
        if ($hoja->esta_entregado == 1) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => "Esta hoja de ruta ya ha sido marcada como entregada",
            ], 400);
        }
        try {
            $hoja->esta_entregado = true;
            foreach ($hoja->ventaDomicilio as $vd) {
                $vd->esta_cancelada == 1 ? null : $vd->esta_cancelada = 1;
                $vd->save();
            }
            foreach ($hoja->creditoFiscalDomicilio as $cfd) {
                $cfd->esta_cancelado == 1 ? null : $cfd->esta_cancelado = 1;
                $cfd->save();
            }
            $hoja->save();
        } catch (\Throwable $th) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => "Error al marcar como entregada la hoja de ruta",
                'error' => $th->getMessage(),
            ], 400);
        }
        return response()->json([
            'respuesta' => true,
            'mensaje' => "Se marco como entregada la hoja de ruta",
        ], 201);
    }

    public function construirCondiciones($fechaEntrega, $estaEntregado)
    {
        $condiciones = [];
        if ($fechaEntrega != null) {
            $condiciones[] = "fecha_entrega = '$fechaEntrega'";
        }
        if ($estaEntregado != null) {
            $condiciones[] = "esta_entregado = '$estaEntregado'";
        }

        return $condiciones;
    }

    public function deleteHojaRuta($id_hr)
    {
        DB::table('ventadomicilio')->where('id_hr', $id_hr)->delete();
        DB::table('creditofiscaldomicilio')->where('id_hr', $id_hr)->delete();
        DB::table('hojaderuta')->where('id_hr', $id_hr)->delete();

        return response()->json(['message' => 'Hoja de ruta y registros eliminados']);
    }

    public function update(Request $request, HojaDeRuta $hojaDeRuta)
    {
        if (isset($hojaDeRuta)) {

            if ($hojaDeRuta->esta_entregado) {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'La Hoja de ruta no se puede modificar, porque ya ha sido entregada.'
                ], 400);
            }
            
            $myValidator = $this->create_validator_hojaDeRuta($request->hoja_de_ruta);
            
            if ($myValidator->fails()) {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => $myValidator->errors()->all()
                ],400);
            } else {
                //HojaDeRuta::update($request->hoja_de_ruta);
                $hojaDeRuta->update($request->hoja_de_ruta);

                $creditos_fiscales_asignados_old_and_new = $hojaDeRuta->creditoFiscalDomicilio()->get();
                $facturas_asignadas_old_and_new = $hojaDeRuta->ventaDomicilio()->get();

                #eliminar los creditos sobrantes de la lista old and new
                foreach ($creditos_fiscales_asignados_old_and_new as $credito) {
                    $credito->delete();
                }

                foreach ($facturas_asignadas_old_and_new as $factura) {
                    $factura->delete();
                }

                $ventaDomicilio = new VentaDomicilioController();
                $ventaDomicilio->register_ventaDomicilio($request, $hojaDeRuta->id_hr);

                return response()->json([
                    'respuesta' => true,
                    'mensaje' => "Hoja de ruta actualizada correctamente."
                ]);

            }

        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Hoja de ruta no encontrada.'
            ], 400);
        }
    }

    public function create_validator_hojaDeRuta($datos)
    {
        $validator = Validator::make($datos, [
            'fecha_entrega' => 'required',
            'id_empleado' => 'required',
            'total' => 'required'
        ]);

        return $validator;
    }
}