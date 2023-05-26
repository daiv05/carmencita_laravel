<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Se retornan todos los productos, sin ningún filtro en forma de JSON
        return Producto::all(); 

        // Esta es otra forma de hacerlo
        //$productos = Producto::all();
        //return response()->json($productos);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Se definen las reglas de validación para los campos del formulario
        $rules = [
            'codigo_barra_producto' => 'required|string|max:10', // El código de barras debe ser único
            'nombre_producto' => 'required|string|max:50',
            'cantidad_producto_disponible' => 'required|integer',
            'precio_unitario' => 'required|numeric',
            'esta_disponible' => 'required|boolean',
        ];
        // Se crea una instancia del validador, para validar los datos ingresados utilizando las reglas definidas
        $validator = \Validator::make($request->input(), $rules);
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
            $producto = Producto::create($request->input());
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
    public function show(Producto $codigo_barra_producto)
    {
        // Se crea una instancia del producto con el código de barras ingresado
        $producto = Producto::find($codigo_barra_producto);
        // Se valida que el producto exista
        if(isset($producto)){
            // Si el producto existe, se retorna el producto en formato JSON
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Producto encontrado',
                'datos' => $producto,
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        // Se definen las reglas de validación para los campos a actualizar igual que en el método store
        $rules = [
            'codigo_barra_producto' => 'required|string|max:10', // El código de barras debe ser único
            'nombre_producto' => 'required|string|max:50',
            'cantidad_producto_disponible' => 'required|integer',
            'precio_unitario' => 'required|numeric',
            'esta_disponible' => 'required|boolean',
        ];
        // Se crea una instancia del validador, para validar los datos ingresados utilizando las reglas definidas
        $validator = \Validator::make($request->input(), $rules);
        // Se valida que la variable $validator no tenga errores al validar los datos ingresados
        if ($validator->fails()){
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all()
            ], 400);
        }
        // Se valida que los datos ingresados sean correctos
        if ($request->validate($rules)){
            // Se actualiza el producto con los datos ingresados
            $producto->update($request->input());
            // Se valida que el producto se haya creado correctamente
            if (isset($producto)){
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Producto actualizado correctamente',
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
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $codigo_barra_producto)
    {
        // Se elimina el producto
        $codigo_barra_producto->delete();
        // Se valida que el producto se haya eliminado correctamente
        if(isset($codigo_barra_producto)){
            // Si el producto se eliminó correctamente, se retorna un mensaje de éxito
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



        /*// Se retorna un mensaje de éxito
        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Producto eliminado correctamente',
        ], 200);*/
    }
}
