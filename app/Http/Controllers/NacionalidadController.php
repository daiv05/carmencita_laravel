<?php

namespace App\Http\Controllers;

use App\Models\Nacionalidad;
use Illuminate\Http\Request;

class NacionalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Nacionalidad::all();
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
    public function show(Nacionalidad $nacionalidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nacionalidad $nacionalidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nacionalidad $nacionalidad)
    {
        //
    }
}
