<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


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
            'codigo_barra_producto' => 'required|unique:producto|string|max:13', // El código de barras debe ser único
            'nombre_producto' => 'required|string|max:50',
            'cantidad_producto_disponible' => 'required|integer',
            'precio_unitario' => 'required|decimal:0,2',
            'esta_disponible' => 'required|boolean',
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
            $producto = Producto::create($request->all());
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
        error_log($producto);
        // Se valida que el producto exista
        if(isset($producto)){
            // Si el producto existe, se retorna el producto en formato JSON
            return response()->json([
                'respuesta' => true,
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        // Se definen las reglas de validación para los campos a actualizar igual que en el método store
        $rules = [
            'codigo_barra_producto' => 'unique:producto|string|max:13', // El código de barras debe ser único
            'nombre_producto' => 'string|max:50',
            'cantidad_producto_disponible' => 'integer',
            'precio_unitario' => 'decimal:0,2',
            'esta_disponible' => 'boolean',
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
        else{
            $producto->update($request->all());
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Producto actualizado correctamente',
            ], 200);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        // Se elimina el producto
        $producto->delete();
        // Se retorna un mensaje de éxito
        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Producto eliminado correctamente',
        ], 200);
    }

    // Obtener Producto por nombre
    public function getProductoPorNombre($nombre_producto)
    {
        // Buscar el producto por nombre
        $producto = Producto::where('nombre_producto', $nombre_producto)->get();
        // Se valida que el producto no este vacio
        if(!($producto->isEmpty())){
            // Si el producto existe, se retorna el producto en formato JSON
            return response()->json([
                'respuesta' => true,
                'producto' => $producto->load('precioUnidadDeMedida')
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

    //Obtener todos los nombres de los productos
    public function getNombresProductos()
    {
        // Se obtienen todos los productos
        $productos = Producto::all();
        // Se valida que la lista de productos no este vacia
        if(!($productos->isEmpty())){
            // Se crea una lista con los nombres de los productos
            $nombres_productos = array();
            foreach ($productos as $producto){
                array_push($nombres_productos, $producto->nombre_producto);
            }
            // Se retorna la lista de nombres de productos en formato JSON
            return response()->json([
                'respuesta' => true,
                'nombres_productos' => $nombres_productos
            ], 200);
        }
        // Si no se encuentra el producto, se retorna un mensaje de error
        else{
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al obtener los nombres de los productos',
            ], 400);
        }
    }

    // Obtener Producto por código de barras, junto a todos sus detalles
    public function getProductoConUnidadMedida($codigo_barra_producto)
    {
        // Buscar el producto por código de barras
        $producto = Producto::where('codigo_barra_producto', $codigo_barra_producto)->get();
        // Se valida que el producto no este vacio
        if(!($producto->isEmpty())){
            // Si el producto existe, se retorna el producto en formato JSON
            return response()->json([
                'respuesta' => true,
                'producto' => $producto->load('precioUnidadDeMedida')
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
}
