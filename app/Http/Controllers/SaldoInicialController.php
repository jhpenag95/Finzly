<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaldoInicialController extends Controller
{
    //
    public function saldo_inicial(){
        return view('saldo_inicial.saldo_inicial');
    }
}
