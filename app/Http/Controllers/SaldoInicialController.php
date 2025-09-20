<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaldoInicialController extends Controller
{
    //
    public function saldo_inicial(){
        return view('saldo_inicial.saldo_inicial');
    }

    public function store(Request $request){

        return $request->all();
        // $request->validate([
        //     'inversiones_data' => 'required|string',
        //     'cuenta_corriente_data' => 'required|string',
        //     'cuenta_ahorros_data' => 'required|string',
        //     'inversiones_data' => 'required|string',

        //     'criptomonedas_data' => 'required|string',
        //     'tarjetas_prepago_data' => 'required|string',
        //     'otros_activos_data' => 'required|string',

        //     'id_usuario' => 'required|exists:users,id',
        //     'efectivo' => 'required|numeric|min:0',
        //     'cuenta_corriente' => 'required|numeric|min:0',
        //     'cuenta_ahorros' => 'required|numeric|min:0',
        //     'inversiones' => 'required|numeric|min:0',
        //     'criptomonedas' => 'required|numeric|min:0',
        //     'tarjetas_prepago' => 'required|numeric|min:0',
        //     'otros_activos' => 'required|numeric|min:0',
        // ]);
    }
}
