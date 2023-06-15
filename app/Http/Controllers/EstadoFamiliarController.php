<?php

namespace App\Http\Controllers;

use App\Models\EstadoFamiliar;
use Illuminate\Http\Request;

class EstadoFamiliarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return EstadoFamiliar::all();
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
    public function show(EstadoFamiliar $estadoFamiliar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EstadoFamiliar $estadoFamiliar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EstadoFamiliar $estadoFamiliar)
    {
        //
    }
}
