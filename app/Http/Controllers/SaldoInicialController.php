<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaldoInicial;

class SaldoInicialController extends Controller
{
    //
    public function saldo_inicial(){
        return view('saldo_inicial.saldo_inicial');
    }

    public function store(Request $request){

        return $request->all();
        // $saldo_inicial = new SaldoInicial();
        
       
    }
}
