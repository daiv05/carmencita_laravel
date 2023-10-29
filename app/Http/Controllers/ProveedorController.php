<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProveedorController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Lista de proveedores',
            'data' => Proveedor::all()
        ]);
    }

    public function store(Request $request)
    {
        $proveedor = Proveedor::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Proveedor creado',
            'data' => $proveedor
        ]);
    }

    public function show(string $id)
    {
        $pro = Proveedor::find($id);
        if (!$pro) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado',
                'data' => null
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Proveedor encontrado',
            'data' => Proveedor::find($id)
        ]);
    }

    public function update(Request $request, string $id)
    {
        $pro = Proveedor::find($id);
        if (!$pro) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado',
                'data' => null
            ], 404);
        }
        $pro->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Proveedor actualizado',
            'data' => $pro
        ]);
    }

    public function destroy(string $id)
    {
        $pro = Proveedor::find($id);
        if (!$pro) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado',
                'data' => null
            ], 404);
        }
        $pro->delete();
        return response()->json([
            'success' => true,
            'message' => 'Proveedor eliminado',
            'data' => $pro
        ], 200);
    }


    public function cambiar_estado_proveedor(Request $request, $id)
    {
        $proveedor = Proveedor::find($id);
        if (!isset($proveedor)) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Proveedor inexistente',
            ], 400);
        } else {
            if ($proveedor->estado_pr == 1) {
                error_log('desactivar');
                $proveedor->estado_pr = 0;
                $proveedor->save();
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Proveedor desactivado correctamente',
                ], 200);
            } else {
                $proveedor->estado_pr = 1;
                $proveedor->save();
                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Proveedor activado correctamente',
                ], 200);
            }
        }
    }
}
