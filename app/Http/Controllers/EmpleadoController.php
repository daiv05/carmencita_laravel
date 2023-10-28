<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use PhpParser\Node\Expr\Empty_;
use App\Http\Resources\Empleado as EmpleadoResource;
use Illuminate\Support\Facades\Validator;

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

    /*
        obtener el listado de empleados
    */
    public function listaEmpleados(){
        $listaEmpleados = Empleado::with(
            ["Nacionalidad" => function($query){
                $query->select("id_nacionalidad","nombre_nacionalidad");
            }]
        )->with([
            "EstadoFamiliar" => function($query){
                $query->select("id_estado_familiar","nombre_estado_familiar");
            }
        ])
        ->with([
            "Sexo" => function($query){
                $query->select("id_sexo","nombre_sexo");
            }
        ])
        ->with([
            "Cargo"=>function($query){
                $query->select("id_cargo","nombre_cargo");
            }
        ])
        ->with(["User"=>function($query){
            $query->select("id_empleado","name");
        }])->get();
        //$listaEmpleadoUsuario = User::with("Empleado")->get();
        return new EmpleadoResource($listaEmpleados);
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
        $validator = Validator::make($request->all(),[
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
            ],400);
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

        if(isset($user)){
            $user->assignRole($miEmpleado->getRol());
        }

        //$token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status'=>true,
            'message'=>["Empleado registrado correctamente",],
            'empleado'=>$empleado,
            'user'=>$user->email
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
        return $empleado::with('cargo')->where('id_empleado',$empleado->id_empleado)->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Empleado $empleado)
    {
        try{
            //$empleado = Empleado::find($empleado)
            if(!$empleado){
                return response()->json([
                    'message'=> 'Empleado no encontrado'
                ], 404);
            }

            $validator = Validator::make($request->all(),[
                //'name' => 'required|string|max:255',
                'primer_nombre' => 'required|string|max:32',
                'primer_apellido' => 'required|string|max:32',
                'id_nacionalidad' => 'required',
                'id_sexo' => 'required',
                'id_cargo' => 'required|numeric',
                'dui_empleado' => [
                    'required',
                    Rule::unique('empleado')->ignore($empleado, 'id_empleado')
                ],
                'id_estado_familiar' => 'required',
                'fecha_nacimiento' => 'required',
                'domicilio' => 'required',
                'residencia' => 'required',
                'telefono' => 'required',
                'profesion_oficio' => 'required'
            ]);

            if($validator->fails()){
                return response()->json([
                    'status'=> false,
                    'message'=> $validator->errors()->all(),
                ],400);
            }

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
            $empleado->id_cargo= intval($request->id_cargo);
            $empleado->telefono= $request->telefono;
            //$empleado->esta_activo= true;
            $empleado->update();
            /*return response()->json([
                'message' => "Actualizado",
                'empleado'=>$empleado
            ],200);*/
            return response()->json([
                'status'=>true,
                'message'=>["Empleado actualizado correctamente"],
                'empleado'=>$empleado
            ],200);


        }catch(\Exception $e){
            return response()->json([
                'message' => "Algo salió mal."
            ],500);
        }

    }

    public function updateEstado(Empleado $empleado)
    {
        if($empleado->esta_activo)
        {
            $empleado->esta_activo = false;
        }
        else
        {
            $empleado->esta_activo = true;
        }

        $empleado->update();

        return response()->json([
            'status'=>true,
            'empleado_activo'=>$empleado->esta_activo,
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        //
    }
}
