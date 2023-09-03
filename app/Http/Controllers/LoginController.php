<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function authorization(Request $request){
        $validate = $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        if(Auth::attempt($validate)){
            $request->session()->regenerate();
            $user = User::where('email',$request["email"])->firstOrFail();
            $token = $user->createToken("token")->plainTextToken;
            return response()->json([
                "result"=>true,
                "user"=>$user,
                "message"=>"Se ha autenticado correctamente",
                "token"=>$token,
                "roles"=>$user->getRoleNames(),
                "permisos"=>$user->getPermissionsViaRoles()
            ],200);
        }
            return response()->json(
                [
                    "result"=>false,
                    "message"=>"Email o contraseña no valido"
                ],400
            );
        
    }
     

    public function logout(Request $request){

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        auth()->user()->tokens()->delete();
        return response()->json(
            [
                "state"=>true,
                "message"=>"You'v done logout"
            ]
        );

    }

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
