<?php

namespace App\Http\Controllers;

//use App\Models\Producto;
//use App\Models\UnidadDeMedida;
use App\Models\PrecioUnidadDeMedida;
use Illuminate\Auth\Events\Validated;
//use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class PrecioUnidadDeMedidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Se retorna la lista de los precios de unidades de medida
        return PrecioUnidadDeMedida::all();
    }

    /**
     * Store a newly list of unidad de medidas
     */
    public function storeList(Request $request){
        $rules = ["codigo_barra_producto" => 'required|string',
                  "lista_precios_unidades"=>'required|array'];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json([
                "respuesta"=>"false",
                "mensaje"=>"datos incompletos",
            ],412);
        }else{
            $listaPreciosUnidades = $request->lista_precios_unidades;
            $codigoDeBarra = $request->codigo_barra_producto;
            foreach($listaPreciosUnidades as $precioUnidadProducto){

                $precioUnidadDeMedida = new PrecioUnidadDeMedida();

                $precioUnidadDeMedida->codigo_barra_producto = $codigoDeBarra;
                $precioUnidadDeMedida->id_unidad_de_medida = $precioUnidadProducto["idUnidadMedida"];
                $precioUnidadDeMedida->cantidad_producto = $precioUnidadProducto["cantidad"];
                $precioUnidadDeMedida->precio_unidad_medida_producto = $precioUnidadProducto["precio"];

                $precioUnidadDeMedida->save();
            }
            return response()->json([
                'resultado'=>true,
                'mensaje'=>'Se guardaron los datos con exito'
            ],200);
        }
    }

    public function updateList(Request $request,$codigo_de_barra){
        $rules = [
            "lista_precios_unidades" => "array",
            "codigo_barra_actualizado"=> "string|required",
        ];
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){
            $codigoBarraProductoAntiguo = $codigo_de_barra;
            $codigoBarraProducto = $request->codigo_barra_actualizado;
            $listaPreciosUnidades = $request->lista_precios_unidades;
            PrecioUnidadDeMedida::where("codigo_barra_producto",$codigoBarraProductoAntiguo)->delete();
            foreach($listaPreciosUnidades as $precioUnidadProducto){

                $precioUnidadDeMedida = new PrecioUnidadDeMedida();

                $precioUnidadDeMedida->codigo_barra_producto = $codigoBarraProducto;
                $precioUnidadDeMedida->id_unidad_de_medida = $precioUnidadProducto["idUnidadMedida"];
                $precioUnidadDeMedida->cantidad_producto = $precioUnidadProducto["cantidad"];
                $precioUnidadDeMedida->precio_unidad_medida_producto = $precioUnidadProducto["precio"];

                $precioUnidadDeMedida->save();
            }
            return response()->json([
                'resultado'=>true,
                'mensaje'=>'Se actualizaron los datos con exito'
            ],200);
        }
        else{
            return response()->json(
                [
                    "resultado" => false,
                    "mensaje"=> $validator->errors()->all()
                ]
            );
        }
        return response()->json(
            [
                "resultado"=>true,
                "mensaje" => "si funciona"
            ]
        );
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Se defininen las reglas de validación
        $rules = [
            'codigo_barra_producto' => 'required|string|max:13',
            'id_unidad_de_medida' => 'required|integer',
            'cantidad_producto' => 'required|integer',
            'precio_unidad_medida_producto' => 'required|decimal:0,2',
        ];
        // Se crea una instancia del validador, para validar los datos ingresados utilizando las reglas definidas
        $validator = Validator::make($request->all(), $rules);
        // Si el validador falla, se retorna un mensaje de error
        if ($validator->fails()){
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all()
            ], 400);
        }
        // Se valida que los datos ingresados sean correctos, según las reglas definidas
        if ($request->validate($rules)){
            // Se crea el precio de unidad de medida con los datos ingresados
            $precioUnidadDeMedida = PrecioUnidadDeMedida::create($request->all());
            // Se valida que el precio de unidad de medida se haya creado correctamente
            if (isset($precioUnidadDeMedida)){
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Precio de unidad de medida creado correctamente',
                ], 201);
            }
            // Si el precio de unidad de medida no se creó correctamente, se retorna un mensaje de error
            else{
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al crear el precio de unidad de medida',
                ], 400);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Buscar el precio de unidad de medida por el ID en la base de datos
        $precioUnidadDeMedida = PrecioUnidadDeMedida::find($id);

        // Verificar si se encontró el precio de unidad de medida
        if ($precioUnidadDeMedida) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Precio de unidad de medida encontrado',
                'datos' => $precioUnidadDeMedida
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Precio de unidad de medida no encontrado o no existe',
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) 
    {
        // Buscar el precio de unidad de medida por el ID en la base de datos
        $precioUnidadDeMedida = PrecioUnidadDeMedida::find($id);

        // Verificar si se encontró el precio de unidad de medida
        if ($precioUnidadDeMedida) {

            // Se definen las reglas de validación
            $rules = [
                'codigo_barra_producto' => 'required|string|max:13',
                'id_unidad_de_medida' => 'required|integer',
                'cantidad_producto' => 'required|integer',
                'precio_unidad_medida_producto' => 'required|decimal:0,2',
            ];
            // Se crea una instancia del validador, para validar los datos ingresados utilizando las reglas definidas
            $validator = Validator::make($request->all(), $rules);
            // Si la validación falla, retornar un mensaje de error
            if ($validator->fails()) {
        // Se defininen las reglas de validación
        $rules = [
            'codigo_barra_producto' => 'required|string|max:13',
            'id_unidad_de_medida' => 'required|integer',
            'cantidad_producto' => 'required|integer',
            'precio_unidad_medida_producto' => 'required|decimal:0,2',
        ];
        // Se crea una instancia del validador, para validar los datos ingresados utilizando las reglas definidas
        $validator = Validator::make($request->all(), $rules);
        // Si el validador falla, se retorna un mensaje de error
        if ($validator->fails()){
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all()
            ], 400);
        }
        // Se valida que los datos ingresados sean correctos, según las reglas definidas
        if ($request->validate($rules)){
            // Se actualiza el precio de unidad de medida con los datos ingresados
            $precioUnidadDeMedida->update($request->all());
            // Se valida que el precio de unidad de medida se haya actualizado correctamente
            if (isset($precioUnidadDeMedida)){
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Precio de unidad de medida actualizado correctamente',
                ], 200);
            }
            // Si el precio de unidad de medida no se actualizó correctamente, se retorna un mensaje de error
            else{
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => $validator->errors()->all()
                ], 400);
            }

            if ($request->validate($rules)) {
                // Se actualiza el precio de unidad de medida con los datos ingresados
                $precioUnidadDeMedida->update($request->all());
                // Se valida que el precio de unidad de medida se haya actualizado correctamente
                if (isset($precioUnidadDeMedida)) {
                    return response()->json([
                        'respuesta' => true,
                        'mensaje' => 'Precio de unidad de medida actualizado correctamente',
                    ], 200);
                }
                // Si el precio de unidad de medida no se actualizó correctamente, se retorna un mensaje de error
                else {
                    return response()->json([
                        'respuesta' => false,
                        'mensaje' => 'Error al actualizar el precio de unidad de medida',
                    ], 400);
                }
            }

        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Precio de unidad de medida no encontrado o no existe',
            ], 400);
        }
    }
 }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Buscar el precio de unidad de medida por el ID en la base de datos
        $precioUnidadDeMedida = PrecioUnidadDeMedida::find($id);

        // Verificar si se encontró el precio de unidad de medida
        if ($precioUnidadDeMedida) {
            // Eliminar el precio de unidad de medida
            $precioUnidadDeMedida->delete();

            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Precio de unidad de medida eliminado correctamente',
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al eliminar el precio de unidad de medida',
            ], 400);
        }
    }

    public function obtenerListaPreciosPorCodigoDeBarra($codigoDeBarra){
        $listaPreciosUnidades = PrecioUnidadDeMedida::where("codigo_barra_producto","=",$codigoDeBarra)
        ->with([
            "UnidadDeMedida"=>function($query){
                $query->select("id_unidad_de_medida","nombre_unidad_de_medida");
            }
        ])
        ->get();

        return response()->json([
            "respuesta"=>true,
            "lista_precios_extra"=>$listaPreciosUnidades
        ]);
    }

}
