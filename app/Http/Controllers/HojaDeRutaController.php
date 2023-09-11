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
            ]);
        }

        $hojaDeRuta = HojaDeRuta::create($request->hoja_de_ruta);

        if (isset($hojaDeRuta)) {
            $ventaDomicilio = new VentaDomicilioController();
            return $ventaDomicilio->register_ventaDomicilio($request, $hojaDeRuta->id_hr);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => "Error al crear la Hoja de Ruta",
            ], 400);
        }
    }

    public function obtenerHojasDeRutasPaginadasFiltro(Request $request){
        /*$hojas = 
        HojaDeRuta::with('ventaDomicilio')->with('creditoFiscalDomicilio')->with('empleado')->paginate(10);*/
        $parametrosConsulta = $request->all();
        $resultados = [];
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
        $resultados = $resultados->paginate(5);
        //->where("hojaderuta.fecha_entrega","=","10290-90-10")
        //->paginate(10); 
     

        return $resultados;
    }

    public function construirCondiciones($fechaEntrega){
        $condiciones = [];
        if($fechaEntrega!=null){
            $condiciones[] = "hojaderuta.fecha_entrega = '$fechaEntrega'";
        }

        return $condiciones;
    }
}
