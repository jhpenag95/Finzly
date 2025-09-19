<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagosController extends Controller
{
    public function pagos(){
        return view('pagos.pagos');
    }
}
