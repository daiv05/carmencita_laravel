<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarProductoRequest;
use App\Models\Producto;
use Error;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Se retornan todos los productos, sin ningún filtro en forma de JSON
        $rules = [
            "codigo_barra_producto" => 'required|string',
        ];
        return Producto::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Se definen las reglas de validación para los campos del formulario
        $rules = [
            'codigo_barra_producto' => 'required|unique:producto|string|max:13',
            // El código de barras debe ser único
            'nombre_producto' => 'required|string|max:50',
            'cantidad_producto_disponible' => 'required|integer',
            'cantidad_producto_fisico' => 'required|integer',
            'precio_unitario' => 'required|decimal:0,2',
            'esta_disponible' => 'required|boolean',
            'foto' => 'image'
        ];
        // Se crea una instancia del validador, para validar los datos ingresados utilizando las reglas definidas
        $validator = Validator::make($request->all(), $rules);
        // Si el validador falla, se retorna un mensaje de error
        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all()
            ], 400);
        }
        // Se valida que los datos ingresados sean correctos
        if ($request->validate($rules)) {
            // Se crea el producto con los datos ingresados
            $producto = new Producto();
            $producto->codigo_barra_producto = $request->codigo_barra_producto;
            $producto->nombre_producto = $request->nombre_producto;
            $producto->cantidad_producto_disponible = $request->cantidad_producto_disponible;
            $producto->cantidad_producto_fisico = $request->cantidad_producto_fisico;
            $producto->precio_unitario = $request->precio_unitario;
            $producto->esta_disponible = $request->esta_disponible;
            //$producto = Producto::create($request->all());
            //guardamos la foto y obtenemos la ruta en donde se guardo
            if ($request->foto) {
                $ruta = $request->foto->store("public/productos");
                $producto->foto = $ruta;
            } else {
                $producto->foto = "";
            }
            $producto->save();
            // Se valida que el producto se haya creado correctamente
            if (isset($producto)) {
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Producto creado correctamente',
                    'foto' => $request->foto
                ], 201);
            }
            // Si el producto no se creó correctamente, se retorna un mensaje de error
            else {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al guardar el producto',
                ]);
            }
        }
        // Si los datos ingresados no son correctos, se retorna un mensaje de error
        else {
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
        if (isset($producto)) {
            // Si el producto existe, se retorna el producto en formato JSON
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Producto obtenido correctamente',
                'producto' => $producto
            ], 200);
        }
        // Si no se encuentra el producto, se retorna un mensaje de error
        else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al obtener el producto',
            ], 400);
        }
    }

    public function foto(Producto $producto)
    {
        return response()->download(public_path(Storage::url($producto->foto)), $producto->nombre_producto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        // Se definen las reglas de validación para los campos a actualizar igual que en el método store
        /*  $rules = [
            'codigo_barra_producto' => [
                'string',
                'max:10',
                Rule::unique('Producto','codigo_barra_producto')->ignore($this->route("codigo_barra_producto"),'codigo_barra_producto'),
            ], // El código de barras debe ser único

        $rules = [
            'codigo_barra_producto' => 'required|unique:producto|string|max:10', // El código de barras debe ser único

            'nombre_producto' => 'required|string|max:50',
            'cantidad_producto_disponible' => 'required|integer',
            'precio_unitario' => 'required|decimal:0,2',
            'esta_disponible' => 'required|boolean',
            'foto'=>'image'
<<<<<<< HEAD
        ];

         /*    'foto'=>'required'
            'codigo_barra_producto' => 'nullable|unique:producto|string|max:13', // El código de barras debe ser único
            'nombre_producto' => 'nullable|string|max:50',
            'cantidad_producto_disponible' => 'nullable|integer',
            'precio_unitario' => 'nullable|decimal:0,2',
            'esta_disponible' => 'nullable|boolean',

        ];
        ];*/

        // Se crea una instancia del validador, para validar los datos ingresados utilizando las reglas definidas
        //$validator = Validator::make($request->all(), $rules);
        // Se valida que la variable $validator no tenga errores al validar los datos ingresados
        $controlFoto = 0;
        $validator = Validator::make($request->all(), [
            'codigo_barra_producto' => [
                'string',
                'max:13',
                Rule::unique('producto')->ignore($producto, 'codigo_barra_producto'),
            ],
            // El código de barras debe ser único
            'nombre_producto' => 'required|string|max:50',
            'cantidad_producto_disponible' => 'required|integer',
            'cantidad_producto_fisico' => 'required|integer',
            'precio_unitario' => 'required|decimal:0,2',
            'esta_disponible' => 'required|boolean',
            'foto' => 'image'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all()
            ], 400);
        }
        // Si los datos ingresados son correctos, se actualiza el producto
        else {
            // Se actualiza el producto con los datos ingresados
            $producto->codigo_barra_producto = $request->codigo_barra_producto;
            $producto->nombre_producto = $request->nombre_producto;
            $producto->cantidad_producto_disponible = $request->cantidad_producto_disponible;
            $producto->cantidad_producto_fisico = $request->cantidad_producto_fisico;
            $producto->precio_unitario = $request->precio_unitario;
            $producto->esta_disponible = $request->esta_disponible;

            if ($request->foto) {
                if ($producto->foto == "") {
                    $ruta = $request->foto->store("public/productos");
                    $producto->foto = $ruta;
                } else if ($producto->foto != "") {
                    Storage::delete($producto->foto);
                    $ruta = $request->foto->store("public/productos");
                    $producto->foto = $ruta;
                }
            }
            $producto->save();
            //$producto->update($request->all());
            // Se valida que el producto se haya actualizado correctamente
            if (isset($producto)) {
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Producto actualizado correctamente',
                    "guardo_foto" => $controlFoto
                ], 200);
            }
            // Si el producto no se actualizó correctamente, se retorna un mensaje de error
            else {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al actualizar el producto',
                ], 400);
            }
        }
        // Si los datos ingresados no son correctos, se retorna un mensaje de error

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        // Se valida que el producto exista
        if (isset($producto)) {
            // Si el producto existe, se elimina el producto
            $producto->delete();
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Producto eliminado correctamente',
            ], 200);
        }
        // Si el producto no se eliminó correctamente, se retorna un mensaje de error
        else {
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

        if ($producto->esta_disponible) {
            $producto->esta_disponible = false;
        } else {
            $producto->esta_disponible = true;
        }

        $producto->update();

        return response()->json([
            'status' => true,
            'empleado_activo' => $producto->esta_disponible,
        ]);
    }

    // Obtener Producto por nombre
    function getProductoPorNombre($nombre_producto)
    {
        // Buscar el producto por nombre
        $producto = Producto::where('nombre_producto', $nombre_producto)->get();
        // $producto[0]->ofertas_vigentes = $producto[0]->promocions()
        //     ->where('fecha_inicio_oferta', '<=', now())
        //     ->where('fecha_fin_oferta', '>=', now())
        //     ->get();
        // Se valida que el producto no este vacio
        if ($producto) {
            return response()->json([
                'respuesta' => true,
                'producto' => $producto->load('precioUnidadDeMedida'),
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Producto inexistente',
            ], 400);
        }
    }

    //Obtener todos los nombres de los productos
    public function getNombresProductos()
    {
        // Se obtienen todos los productos
        $productos = Producto::where('esta_disponible', true)->get();
        // Se valida que la lista de productos no este vacia
        if (!($productos->isEmpty())) {
            // Se crea una lista con los nombres de los productos
            $nombres_productos = array();
            foreach ($productos as $producto) {
                array_push($nombres_productos, $producto->nombre_producto);
            }
            // Se retorna la lista de nombres de productos en formato JSON
            return response()->json([
                'respuesta' => true,
                'nombres_productos' => $nombres_productos
            ], 200);
        }
        // Si no se encuentra el producto, se retorna un mensaje de error
        else {
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
        if (!($producto->isEmpty())) {
            // Si el producto existe, se retorna el producto en formato JSON
            return response()->json([
                'respuesta' => true,
                'producto' => $producto->load('precioUnidadDeMedida')
            ], 200);
        }
        // Si no se encuentra el producto, se retorna un mensaje de error
        else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al obtener el producto',
            ], 400);
        }
    }

    // Paginación de productos
    public function getPaginacionProductos(Request $request,$cantidad_productos)
    {
        // Se obtienen todos los productos
        if($request->sort_by == 0 || $request->sort_by == '0'){
            $productos = Producto::orderBy('cantidad_producto_disponible', 'asc')->paginate($cantidad_productos);
        } else if($request->sort_by == 1 || $request->sort_by == '1'){
            $productos = Producto::orderBy('cantidad_producto_disponible', 'desc')->paginate($cantidad_productos);
        }else{
            $productos = Producto::paginate($cantidad_productos);
        }
        
        // Se valida que la lista de productos no este vacia
        if (!($productos->isEmpty())) {
            // Se retorna la lista de productos en formato JSON
            return response()->json([
                'respuesta' => true,
                'productos' => $productos,
            ], 200);
        }
        // Si no se encuentra el producto, se retorna un mensaje de error
        else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al obtener los productos',
            ], 400);
        }
    }

}