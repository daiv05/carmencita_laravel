<?php

namespace App\Http\Controllers;

use App\Models\Sexo;
use Illuminate\Http\Request;

class SexoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Sexo::all();
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
    public function show(Sexo $sexo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sexo $sexo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sexo $sexo)
    {
        //
    }
}
