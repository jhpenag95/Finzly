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

        $id_ingresos  = 'SI' . substr(uniqid(), 0, 8) . rand(10, 99);
        $descripcion = 'Pruebas';
        $fecha_registro = now();
        $id_concepto = $request->input('concepto');
        $monto = number_format((float)$request->input('valor'), 2, '.', '');

        $saldo_inicial = SaldoInicial::create([
            'id_ingresos' => $id_ingresos,
            'descripcion' => $descripcion,  
            'fecha_registro' => $fecha_registro,
            'monto' => $monto,
            'id_usuario' => 1,
            'id_conpsaldo' => $id_concepto
        ]);

        if (!$saldo_inicial) {
            return response()->json([
                'success' => false
            ], 500);
        } else {
            return response()->json([
                'success' => true,
            ], 201);
        }
    }
}
