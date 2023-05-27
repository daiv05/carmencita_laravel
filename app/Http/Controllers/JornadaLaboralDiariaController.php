<?php

namespace App\Http\Controllers;

use App\Models\JornadaLaboralDiaria;
use Illuminate\Http\Request;

class JornadaLaboralDiariaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return JornadaLaboralDiaria::all();
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
    public function show(string $id_jornada_laboral)
    {
        $jornadaLaboral = JornadaLaboralDiaria::find($id_jornada_laboral);
        if(isset($jornadaLaboral)){
            return response()->json([
                'repuesta'=>true,
                'jornada' => $jornadaLaboral,
            ]);
        }
        else{
            return response()->json(
                [
                    'respuesta'=>false,
                ],400
            );
        }
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
