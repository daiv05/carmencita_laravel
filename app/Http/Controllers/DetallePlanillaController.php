<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Empleado;

class DetallePlanillaController extends Controller
{
    public function store(Request $request){

    }

    public function empleado(){
        return  $this->hasOne(Empleado::class);
    }
}
