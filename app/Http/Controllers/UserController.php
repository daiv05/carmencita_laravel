<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cargo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    public function index(){
        //Retornar todos los usuarios
        $usuarios = User::with('empleado')->get();
        $usuariosCompactos = [];
        foreach ($usuarios as $usuario){
            if (isset($usuario->empleado)){
                $cargo = Cargo::where('id_cargo', $usuario->empleado->id_cargo)->first();
                $miUsuario = ['name' => $usuario->name, 'email' => $usuario->email, 'cargo' => $cargo->nombre_cargo, 'id' => $usuario->id];
                array_push($usuariosCompactos, $miUsuario);
            }
            else{
                $cargo = 'Superuser';
                $miUsuario = ['name' =>$usuario->name, 'email' => $usuario->email, 'cargo' => $cargo, 'id' => $usuario->id];
                array_push($usuariosCompactos, $miUsuario);
            }
            
        }
        return $usuariosCompactos;
    }

    public function store(Request $request){
        //Definir las reglas de validacion
        $rules = [
            'name' => 'required|unique:users',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|min:8',
        ];
        //Crear instancia de validacion
        $validator = Validator::make($request->all(), $rules);
        // Si falla la validacion, retornar los errores
        if ($validator->fails()) {
            return response()->json([
                'response' => false,
                'message'=> $validator->errors()->all(),
            ],400);
        }
        // Validar los datos de entrada
        if ($request->validate($rules)){
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password); // Encriptar la contraseña
            $user->save();
            // Se valida que el usuario se haya guardado correctamente
            if (isset($user)){
                return response()->json([
                    'response' => true,
                    'message'=> 'Usuario creado correctamente',
                    'data' => $user,
                ],201);
            }
            // Si no se guardo correctamente, retornar un error
            else{
                return response()->json([
                    'response' => false,
                    'message'=> 'Error al crear el usuario',
                ],400);
            }
        }
        // Si los datos no son validos, retornar un error
        else{
            return response()->json([
                'response' => false,
                'message'=> 'Error en los datos ingresados',
            ],400);
        }
    }

    public function show(User $user){
        //Se valida que el usuario exista
        if (isset($user)){
            return response()->json([
                'response' => true,
                'message'=> 'Usuario encontrado',
                'data' => $user,
            ],200);
        }
        //Si no se encuentra el usuario, retornar un error
        else{
            return response()->json([
                'response' => false,
                'message'=> 'Usuario no encontrado',
            ],404);
        }
    }

    public function update(Request $request, User $user){
        try{
            if (!isset($user)){
                return response()->json([
                    'response'=> false,
                    'message'=> 'Usuario no encontrado',
                ],404);
            }

            $rules = [
                'name' => 'required',
                'email'=>[
                    'required',
                    Rule::unique('users')->ignore($user)
                ],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'=> false,
                    'usuario' => $user,
                    'message'=> $validator->errors()->all(),
                ],400);
            }

            if ($request->name != $user->name){
                $user->name = $request->name;
            }
            if ($request->email != $user->email){
                $user->email = $request->email;
            }
            //$user->save();
            $user->update();

            return response()->json([
                'status'=> true,
                'message'=> 'Usuario actualizado correctamente',
                'data' => $user,
            ],200);
            
        }
        catch (\Exception $e){
            return response()->json([
                'status'=> false,
                'message'=> 'Error al actualizar el usuario',
                'data' => $e->getMessage(),
            ],400);
        }            
    }

    public function destroy($id){
        if ($id){
            $usuario = User::find($id);
            $usuario->delete();
            return response()->json([
                'status'=> true,
                'data' => $id,
                'message'=> 'Usuario eliminado correctamente',
            ],200);
        }
        else{
            return response()->json([
                'status'=> false,
                'message'=> 'Error al eliminar el usuario',
            ],400);
        }
    }

}
