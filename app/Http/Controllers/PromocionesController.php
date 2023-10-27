<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Promocion;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;




class PromocionesController extends Controller
{
    ////Obtener los productos
    public function getProductos()
    {
        return Producto::all();
    }

    //crear una nueva promocion
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            //'name' => 'required|string|max:255',
            'codigo_barra_producto' => 'required',
            'fecha_inicio_oferta' => 'required',
            'fecha_fin_oferta' => 'required|after:fecha_inicio_oferta',
            'precio_oferta' => ['required', 'numeric', 'gt:0'],
            'cantidad_producto' => 'required|integer|gt:0',
            'monto_rebaja' => 'numeric|gt:0',
            'nombre_oferta' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all(),
                'Hola' => 'hola',
            ],400);
        }

        $promocion = new Promocion();
        $promocion->fecha_inicio_oferta = $request->fecha_fin_oferta; //,
        if ($request->fecha_fin_oferta) {
            $promocion->fecha_fin_oferta = $request->fecha_fin_oferta;
        }
        if ($request->fecha_fin_oferta) {
            $promocion->fecha_fin_oferta = $request->fecha_fin_oferta;
        }

        $promocion->codigo_barra_producto = $request->codigo_barra_producto;
        $promocion->fecha_inicio_oferta = $request->fecha_inicio_oferta;
        $promocion->fecha_fin_oferta = $request->fecha_fin_oferta;
        $promocion->precio_oferta = $request->precio_oferta;
        $promocion->nombre_oferta = $request->nombre_oferta;
        $promocion->cantidad_producto = $request->cantidad_producto;
        $promocion->monto_rebaja = $request->monto_rebaja;
        $promocion->save();

        //$token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'status'=>true,
            'message'=>["Promoción registrada correctamente"],
            'promocion'=>$promocion
        ],200);
    }

    //Obtener todas las promociones vigentes y retono de JSON
    public function promocionesVigentes()
    {
        $fechaActual = Carbon::now()->toDateString();

        $promociones = DB::table('promocions')
            ->join('producto', 'promocions.codigo_barra_producto', '=', 'producto.codigo_barra_producto')
            ->select('promocions.*', 'producto.foto', 'producto.precio_unitario')
            ->where('promocions.fecha_inicio_oferta', '<=', $fechaActual)
            ->where('promocions.fecha_fin_oferta', '>=', $fechaActual)
            ->get();

        return response()->json($promociones);
    }

    //Lista todas las ofertas
    public function ofertasList()
    {
        $promociones = DB::table('promocions')
            ->join('producto', 'promocions.codigo_barra_producto', '=', 'producto.codigo_barra_producto')
            ->select('promocions.*', 'producto.nombre_producto')
            ->paginate(5);

        return response()->json($promociones);
    }

    public function destroy(Request $request, Promocion $promocion)
    {
        try {
            $resultado = $promocion->delete();
            return response()->json([
                "mensaje" => "Se elimino la oferta de manera exitosa",
                "respuesta" => $resultado,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "errores" => "El registro que desea eliminar no existe",
                "mensaje" => "El registro no esta en la base de datos, o se encuentra desconectada",
                "respuesta" => $resultado,
            ], 404);
        }
    }

    //Actualizar una promocion
    public function update(Request $request, Promocion $promocion)
    {
        try {

            if (!$promocion) {
                return response()->json([
                    'message' => 'Oferta no encontrada'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'codigo_barra_producto' => 'required',
                'fecha_inicio_oferta' => 'required',
                'fecha_fin_oferta' => 'required|after:fecha_inicio_oferta',
                'precio_oferta' => ['required', 'numeric', 'gt:0'],
                'nombre_oferta' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->all(),
                    'Hola' => 'hola',
                ]);
            }

            $promocion->fecha_inicio_oferta = $request->fecha_fin_oferta; //,
            if ($request->fecha_fin_oferta) {
                $promocion->fecha_fin_oferta = $request->fecha_fin_oferta;
            }
            if ($request->fecha_fin_oferta) {
                $promocion->fecha_fin_oferta = $request->fecha_fin_oferta;
            }

            $promocion->codigo_barra_producto = $request->codigo_barra_producto;
            $promocion->fecha_inicio_oferta = $request->fecha_inicio_oferta;
            $promocion->fecha_fin_oferta = $request->fecha_fin_oferta;
            $promocion->precio_oferta = $request->precio_oferta;
            $promocion->nombre_oferta = $request->nombre_oferta;
            $promocion->cantidad_producto = $request->cantidad_producto;
            $promocion->monto_rebaja = $request->monto_rebaja;
            $promocion->update();
            
            return response()->json([
                'status' => true,
                'message' => ["Oferta actualizada correctamente"],
                'promocion' => $promocion
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Algo salió mal."
            ], 500);
        }
    }

    public function show(Promocion $promocion)
    {
        //
        return $promocion->where('id',$promocion->id)->first();
    }
}
