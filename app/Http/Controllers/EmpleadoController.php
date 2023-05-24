<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Empleado::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*$rules = [
            'primer_nombre'=>'required',
            'primer_apellido'=>'required'
        ];*/       
        
        //$validator = \Validator::make($request->input(),$rules);
        $validator = \Validator::make($request->all(),[
            //'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'primer_nombre' => 'required|string|max:32',
            'primer_apellido' => 'required|string|max:32',
            'id_nacionalidad' => 'required',
            'id_sexo' => 'required',
            'id_cargo' => 'required',
            'dui_empleado' => 'required|unique:empleado',
            'id_estado_familiar' => 'required',
            'fecha_nacimiento' => 'required',
            'domicilio' => 'required',
            'residencia' => 'required',
            'telefono' => 'required',
            'profesion_oficio' => 'required'
        ]);

        /*if($validator->fails()){
            return response()->json($validator->errors());
        }*/

        if($validator->fails()){
            return response()->json([
                'status'=> false,
                'message'=> $validator->errors()->all(),
                'Hola' => 'hola',
            ]);
        }

        /*$empleado = new Empleado($request->input());
        $empleado->save();*/

        $empleado = new Empleado();//Empleado::create([
            $empleado->primer_nombre = $request->primer_nombre;//,
            if($request->segundo_nombre)
            {      
                $empleado->segundo_nombre = $request->segundo_nombre;
            }
            if($request->segundo_apellido)
            {
                $empleado->segundo_apellido= $request->segundo_apellido; 
            }

            $empleado->primer_apellido= $request->primer_apellido;
            $empleado->id_sexo = $request->id_sexo;
            $empleado->fecha_nacimiento= $request->fecha_nacimiento;
            $empleado->id_estado_familiar= $request->id_estado_familiar;
            $empleado->profesion_oficio= $request->profesion_oficio;
            $empleado->domicilio= $request->domicilio;
            $empleado->residencia= $request->residencia;
            $empleado->id_nacionalidad= $request->id_nacionalidad;
            $empleado->dui_empleado= $request->dui_empleado;
            $empleado->id_cargo= $request->id_cargo;
            $empleado->telefono= $request->telefono;
            $empleado->esta_activo= true;
            $empleado->save();
        //]);
        
        //$usuario = new User();
        $miEmpleado = Empleado::where('dui_empleado',$empleado->dui_empleado)->first();
        $user = User::create([
            'id_empleado' => $miEmpleado->id_empleado,
            'name' => $request->primer_nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //$token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'status'=>true,
            'message'=>$validator->errors()->all(),
            'empleado'=>$empleado,
            'user'=>$user->email
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        //
    }
}
