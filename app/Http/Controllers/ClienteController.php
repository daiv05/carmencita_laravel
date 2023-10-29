<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Lista de clientes',
            'datos' => Cliente::with('municipio')->with('municipio.departamento')->get(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre_cliente' => 'required|string|max:50',
            'direccion_cliente' => 'required|string|max:50',
            'dui_cliente' => 'nullable|string|max:10',
            'nit_cliente' => 'nullable|string|max:20',
            'nrc_cliente' => 'required|string|max:20',
            'id_municipio' => 'required|integer',
            'distintivo_cliente' => 'required|string|max:50',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all(),
            ], 400);
        }

        //Validar si existe el cliente con el mismo distintivo
        $cliente = Cliente::where('distintivo_cliente', $request->distintivo_cliente)->first();
        if (isset($cliente)) {
            return response()->json([
                'respuesta' => false,
                'distintivo_exist' => true,
            ], 400);
        }

        if ($request->validate($rules)) {
            $cliente = Cliente::create($request->all());
            if (isset($cliente)) {
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Cliente creado correctamente',
                ], 201);
            } else {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al crear el cliente',
                ], 400);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id_cliente)
    {
        $cliente = Cliente::with('municipio')->with('municipio.departamento')->find($id_cliente);

        //Validar si existe el cliente
        if (isset($cliente)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Cliente encontrado',
                'datos' => $cliente,
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Cliente no encontrado',
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
        $rules = [
            'nombre_cliente' => 'string|max:50',
            'municipio_cliente' => 'integer',
            'direccion_cliente' => 'string|max:50',
            'dui_cliente' => 'max:10',
            'nit_cliente' => 'max:20',
            'nrc_cliente' => 'string|max:20',
            'distintivo_cliente' => 'string|max:50',
            'estado_cliente' => 'boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => $validator->errors()->all(),
            ], 400);
        }

        //Validar si existe el cliente con el mismo distintivo
        $clientes_ = Cliente::where('id_cliente', '!=', $cliente->id_cliente)->where('distintivo_cliente', $request->distintivo_cliente)->first();
        if (isset($clientes_)) {
            return response()->json([
                'respuesta' => false,
                'distintivo_exist' => true,
            ], 400);
        }

        if ($request->validate($rules)) {
            $cliente->update($request->all());
            if (isset($cliente)) {
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Cliente actualizado correctamente',
                ], 200);
            } else {
                return response()->json([
                    'respuesta' => false,
                    'mensaje' => 'Error al actualizar el cliente',
                ], 400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        return response()->json([
            'respuesta' => false,
            'mensaje' => 'No se pueden eliminar clientes',
        ]);
    }

    //Lista de identificadores de clientes.
    public function getListaClientesIdentificadores()
    {
        $clientes = Cliente::where('estado_cliente', true)->select('id_cliente', 'distintivo_cliente')->get();
        if (isset($clientes)) {
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Lista de clientes',
                'datos' => $clientes,
            ], 200);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al obtener la lista de clientes',
            ], 400);
        }
    }

    public function desactivar_cliente(Request $request, $id_cliente)
    {
        $cliente = Cliente::find($id_cliente);
        if (!isset($cliente)) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Cliente inexistente',
            ], 400);
        } else {
            if ($cliente->estado_cliente == 1) {
                $cliente->update(['estado_cliente' => false]);
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Cliente desactivado correctamente',
                ], 200);
            } else {
                $cliente->update(['estado_cliente' => true]);
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Cliente activado correctamente',
                ], 200);
            }
        }
    }
}
