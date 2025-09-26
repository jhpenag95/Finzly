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
            $conceptos = ConceptoSaldoInicial::all();

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
}
