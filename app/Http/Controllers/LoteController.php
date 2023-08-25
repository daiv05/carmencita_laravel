<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaginacioLoteRecurso;
use Illuminate\Http\Request;
use App\Models\Lote;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PaginacionLoteRecursos;

class LoteController extends Controller
{
    //
    public function index(){
        //$lote = Lote::find(1);
        //return Lote::with("producto")->paginate(15);
        return PaginacioLoteRecurso::collection(Lote::paginate(10));
    }
}
