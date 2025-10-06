<?php

namespace App\Http\Controllers;

use App\Models\ConceptoSaldoInicial;

use Illuminate\Http\Request;

class ConceptoSaldoInicialController extends Controller
{
    //consultar conceptos de saldo inicial
    public function index()
    {
        try {
            $conceptos = ConceptoSaldoInicial::select('id_conpsaldo', 'concepto', 'fecha_registro', 'status')
                ->where('status', 'activo')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $conceptos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los conceptos: ' . $e->getMessage()
            ], 500);
        }
    }

    //obtener concepto de saldo inicial por id
    public function show($id)
    {
        $concepto = ConceptoSaldoInicial::select('id_conpsaldo', 'concepto', 'fecha_registro', 'status')
            ->where('id_conpsaldo', $id)
            ->first();

        if (!$concepto) {
            return response()->json([
                'success' => false,
                'message' => 'Concepto no encontrado'
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'concepto' => $concepto
            ], 200);
        }
    }

    //obtener conceptos de saldo inicial
    public function index_concepto()
    {
        $concepto_saldo_inicial = ConceptoSaldoInicial::select('id_conpsaldo', 'concepto', 'fecha_registro', 'status')
            ->get();

        return response()->json([
            'success' => true,
            'concepto_saldo_inicial' => $concepto_saldo_inicial
        ], 200);
    }


    //guardar concepto de saldo inicial
    public function store(Request $request)
    {
        $id_conpsaldo = 'CSI' . substr(uniqid(), 0, 8) . rand(10, 99);
        $fecha_registro = now();
        $concepto = $request->input('concepto');

        // Verificar si el concepto ya existe
        $exists = ConceptoSaldoInicial::where('concepto', $concepto)->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'El concepto ya existe en la base de datos'
            ], 422);
        } else {

            $concepto = ConceptoSaldoInicial::create([
                'id_conpsaldo' => $id_conpsaldo,
                'concepto' => $concepto,
                'fecha_registro' => $fecha_registro
            ]);

            if (!$concepto) {
                return response()->json([
                    'success' => false
                ], 500);
            } else {
                return response()->json([
                    'success' => true
                ], 201);
            }
        }
    }

    //actualizar concepto de saldo inicial
    public function update(Request $request, $id)
    {
        $concepto = ConceptoSaldoInicial::find($id);

        if (!$concepto) {
            return response()->json([
                'success' => false
            ], 404);
        } else {
            $concepto->update([
                'concepto' => $request->input('concepto'),
                'status' => $request->input('status')
            ]);

            return response()->json([
                'success' => true
            ], 200);
        }
    }

    //eliminar concepto de saldo inicial
    public function destroy($id)
    {
        $validarExiste = ConceptoSaldoInicial::select('id_conpsaldo')
            ->where('id_conpsaldo', $id)
            ->first();

        if (!$validarExiste) {
            return response()->json([
                'success' => false
            ], 404);
        } else {
            $concepto = ConceptoSaldoInicial::find($id);
            $concepto->update([
                'status' => 'Inactivo'
            ]);

            return response()->json([
                'success' => true
            ], 200);
        }
    }
}
