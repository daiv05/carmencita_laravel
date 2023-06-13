<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Se retornan todos los productos, sin ningún filtro en forma de JSON
        return Producto::all();
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Se definen las reglas de validación para los campos del formulario
        $rules = [
            'codigo_barra_producto' => 'required|unique:producto|string|max:10', // El código de barras debe ser único
            'nombre_producto' => 'required|string|max:50',
            'cantidad_producto_disponible' => 'required|integer',
            'precio_unitario' => 'required|decimal:0,2',
            'esta_disponible' => 'required|boolean',
            'foto'=>'image'
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
        // Se valida que los datos ingresados sean correctos
        if ($request->validate($rules)){
            // Se crea el producto con los datos ingresados
            $producto = new Producto();
            $producto->codigo_barra_producto = $request->codigo_barra_producto;
            $producto->nombre_producto = $request->nombre_producto;
            $producto->cantidad_producto_disponible = $request->cantidad_producto_disponible;
            $producto->precio_unitario = $request->precio_unitario;
            $producto->esta_disponible = $request->esta_disponible;
            //$producto = Producto::create($request->all());
            //guardamos la foto y obtenemos la ruta en donde se guardo
            $ruta = $request->foto->store("public/productos");
            $producto->foto = $ruta;
            $producto->save();
            // Se valida que el producto se haya creado correctamente
            if (isset($producto)){
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Producto creado correctamente',
                ], 201);
            }
            // Si el producto no se creó correctamente, se retorna un mensaje de error
            else{
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al guardar el producto',
                ]);
            }
        }
        // Si los datos ingresados no son correctos, se retorna un mensaje de error
        else{
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error en los datos ingresados',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //error_log($producto);
        // Se valida que el producto exista
        if(isset($producto)){
            // Si el producto existe, se retorna el producto en formato JSON
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Producto obtenido correctamente',
                'producto' => $producto
            ], 200);
        }
        // Si no se encuentra el producto, se retorna un mensaje de error
        else{
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al obtener el producto',
            ], 400);
        }

    }

    public function foto(Producto $producto){
        return response()->download(public_path(Storage::url($producto->foto)),$producto->nombre_producto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        // Se definen las reglas de validación para los campos a actualizar igual que en el método store
        $rules = [
            'codigo_barra_producto' => 'required|unique:producto|string|max:10', // El código de barras debe ser único
            'nombre_producto' => 'required|string|max:50',
            'cantidad_producto_disponible' => 'required|integer',
            'precio_unitario' => 'required|decimal:0,2',
            'esta_disponible' => 'required|boolean',
            'foto'=>'image'
        ];
        // Se crea una instancia del validador, para validar los datos ingresados utilizando las reglas definidas
        $validator = Validator::make($request->all(), $rules);
        // Se valida que la variable $validator no tenga errores al validar los datos ingresados
        if ($validator->fails()){
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all()
            ], 400);
        }
        // Si los datos ingresados son correctos, se actualiza el producto
       if ($request->validate($rules)){
            // Se actualiza el producto con los datos ingresados
            $producto->update($request->all());
            // Se valida que el producto se haya actualizado correctamente
            if (isset($producto)){
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Producto actualizado correctamente',
                ], 200);
            }
            // Si el producto no se actualizó correctamente, se retorna un mensaje de error
            else{
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al actualizar el producto',
                ], 400);
            }
        }
        // Si los datos ingresados no son correctos, se retorna un mensaje de error
        else{
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error en los datos ingresados',
            ], 400);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        // Se valida que el producto exista
        if (isset($producto)){
            // Si el producto existe, se elimina el producto
            $producto->delete();
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Producto eliminado correctamente',
            ], 200);
        }
        // Si el producto no se eliminó correctamente, se retorna un mensaje de error
        else{
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al eliminar el producto',
            ], 400);
        }
    }

    //Método para actualizar el estado de un producto
    public function updateEstado(Producto $producto)
    {
        //$producto = Producto::find($producto->codigo_barra_producto);

        if($producto->esta_disponible)
        {
            $producto->esta_disponible = false;
        }
        else
        {
            $producto->esta_disponible = true;
        }

        $producto->update();

        return response()->json([
            'status'=>true,
            'empleado_activo'=>$producto->esta_disponible,
        ]);        
        
    }
}
