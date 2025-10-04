<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaldoInicial;

use function Laravel\Prompts\select;

class SaldoInicialController extends Controller
{
    //
    public function saldo_inicial()
    {
        return view('saldo_inicial.saldo_inicial');
    }

    public function store(Request $request)
    {

        $id_ingresos  = 'SI' . substr(uniqid(), 0, 8) . rand(10, 99);
        $descripcion = 'Pruebas';
        $fecha_registro = now();
        $id_concepto = $request->input('concepto');
        $valorLimpio = str_replace(['.', ','], ['', '.'], $request->input('valor')); //eliminar los puntos y comas del valor
        $monto = number_format((float)$valorLimpio, 2, '.', ''); //formatear el valor a 2 decimales con punto como separador de miles

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

    //obtener el total de saldo inicial
    public function index()
    {
        $saldo_inicial = SaldoInicial::select('csi.concepto', 'saldoinicial.monto', 'saldoinicial.fecha_registro', 'saldoinicial.id_conpsaldo', 'saldoinicial.id_ingresos')
            ->join('conceptosaldo_init as csi', 'saldoinicial.id_conpsaldo', '=', 'csi.id_conpsaldo')
            ->orderBy('saldoinicial.fecha_registro', 'asc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'saldo_inicial' => $saldo_inicial
        ], 200);
    }

    //obtener el total de saldo inicial
    public function total()
    {
        $total = number_format(SaldoInicial::sum('monto'), 2, '.', ',');
        return response()->json([
            'success' => true,
            'total' => $total
        ], 200);
    }

    //actualizar un saldo inicial
    public function update(Request $request, $id)
    {
        $saldo_inicial = SaldoInicial::find($id);

        if (!$saldo_inicial) {
            return response()->json([
                'success' => false
            ], 404);
        }

        $saldo_inicial->update([
            'descripcion' => $request->input('descripcion'),
            'monto' => number_format((float)$request->input('monto'), 2, '.', ''),
            'id_conpsaldo' => $request->input('id_conpsaldo'),
        ]);

        return response()->json([
            'success' => true,
        ], 200);
    }

    //Eliminar registro de saldo inicial
    public function destroy($id)
    {
        $validarExiste = SaldoInicial::select('id_ingresos')
            ->where('id_ingresos', $id)
            ->first();

        if (!$validarExiste) {
            return response()->json([
                'success' => false
            ], 404);
        }  else {
            $saldo_inicial = SaldoInicial::find($id);

            if (!$saldo_inicial) {
                return response()->json([
                    'success' => false
                ], 404);
            }

            $saldo_inicial->delete();
            
            return response()->json([
                'success' => true,
            ], 200);
        }

    }
}