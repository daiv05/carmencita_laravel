<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Venta;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class InformeVentasController extends Controller
{
    //
    /*
        SELECT X1.id_venta as idVenta,SUM(X2.subtotal_detalle_venta) as total_venta,
        X1.fecha_venta AS fecha_venta
        FROM venta AS X1
        INNER JOIN detalleventa AS X2 ON X1.id_venta = X2.id_venta
        WHERE Month(X1.fecha_venta) = 1
        GROUP BY(X1.id_venta);

        ===============================
        SELECT X1.id_venta as idVenta,SUM(X2.subtotal_detalle_venta) as total_venta,
        X1.fecha_venta AS fecha_venta
        FROM venta AS X1
        INNER JOIN detalleventa AS X2 ON X1.id_venta = X2.id_venta
        WHERE Month(X1.fecha_venta)IN (1,2,3,4,5) AND YEAR(X1.fecha_venta) = 2021
        GROUP BY(X1.id_venta);
        ===================================
        SELECT SUM(X2.subtotal_detalle_venta) as total_venta,
        Month(X1.fecha_venta) AS mes_venta
        FROM venta AS X1
        INNER JOIN detalleventa AS X2 ON X1.id_venta = X2.id_venta
        WHERE Month(X1.fecha_venta)IN (1,2,3,4,5) AND YEAR(X1.fecha_venta) = 2021
        GROUP BY(Month(X1.fecha_venta));
    */
    protected $nombre_meses = ["ene","feb","mar","abr","may","jun","jul","ago","sep","oct","nov","dic"];
    public function obtenerVentasTotalesPorFecha(Request $request)
    {
       /* $validator = Validator::make($request->all(),[
            "filtro_meses"=>["array"],
            "anio_filtro"=>["string"],
        ]);
        if($validator->fails()){
            response()->json([
                "status"=>false,
                "errores"=>$validator->errors()->all(),
            ],500);
        }*/
        //$datos_filtro = $validator->validated();
        $filtro_meses = $request->input("filtro_meses");//$datos_filtro["filtro_meses"];//("filtro_meses");//$parametros["filtro_meses"]; 
        $anio_filtro = $request->input("anio_filtro");//$datos_filtro["anio_filtro"];//$parametros["anio_filtro"];
        $ventas = [];
        try{
            if(isset($filtro_meses) && sizeof($filtro_meses) > 0){
                $ventas = Venta::selectRaw('SUM(detalleventa.subtotal_detalle_venta) as total_venta, MONTH(venta.fecha_venta) AS mes_venta')
                ->join('detalleventa', 'venta.id_venta', '=', 'detalleventa.id_venta')
                ->whereIn(DB::raw('MONTH(venta.fecha_venta)'), $filtro_meses)
                ->whereYear('venta.fecha_venta', $anio_filtro)
                ->groupBy(DB::raw('MONTH(venta.fecha_venta)'))
                ->get();
                $control="1";
            }
            else{
                $ventas = Venta::join('detalleventa as X2', 'venta.id_venta', '=', 'X2.id_venta')
                ->selectRaw('SUM(X2.subtotal_detalle_venta) as total_venta, MONTH(venta.fecha_venta) AS mes_venta')
                ->whereYear('venta.fecha_venta', $anio_filtro)
                ->groupBy(DB::raw('MONTH(venta.fecha_venta)'))
                ->get();
            }
          
            foreach($ventas as $venta){
                for($i=1;$i<=12;$i++){
                    if($venta["mes_venta"]==$i){
                        $venta["nombre_mes"] = $this->nombre_meses[$i-1];
                    }
                }
            }
            return response()->json([
                "status"=>true,
                "mensaje"=>"Exito al realizar la consulta",
                "datos_filtrados"=>$ventas,
            ],200);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                "status"=>false,
                "mensaje"=>$e->getMessage(),
            ],500);
        }catch(QueryException $e){
            return response()->json([
                "status"=>false,
                "mensaje"=>$e->getMessage()
            ],500);
        }

    }
}
