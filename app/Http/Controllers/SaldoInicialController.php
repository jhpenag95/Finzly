<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaldoInicial;
use App\Models\SaldoInicialHistorico;

use function Laravel\Prompts\select;

class SaldoInicialController extends Controller
{
    //
    public function saldo_inicial()
    {
        return view('saldo_inicial.saldo_inicial');
    }

    //guardar un saldo inicial
    public function store(Request $request)
    {
        // 1. VALIDAR primero
        $validated = $request->validate([
            'concepto' => 'required|exists:conceptosaldo_init,id_conpsaldo',
            'valor' => 'required|string',
            'descripcion' => 'nullable|string|max:255'
        ]);

        $descripcion = $request->input('descripcion', 'Ajuste de saldo inicial');
        $fecha_registro = now();
        $id_concepto = $validated['concepto'];

        // Limpiar y formatear el valor
        $valorLimpio = str_replace(['.', ','], ['', '.'], $validated['valor']);
        $monto = number_format((float)$valorLimpio, 2, '.', '');

        // 2. Obtener usuario autenticado
        $id_usuario = auth()->id() ?? 1; // Fallback solo para desarrollo

        \DB::beginTransaction();
        try {
            $saldo_existente = SaldoInicial::where('id_conpsaldo', $id_concepto)->first();

            if ($saldo_existente) {
                // Actualizar saldo existente
                $id_ingresos = $saldo_existente->id_ingresos;
                $saldo_anterior = $saldo_existente->monto;

                $nuevo_saldo = $saldo_anterior + $monto;

                $saldo_existente->update([
                    'monto' => $nuevo_saldo,
                    'fecha_registro' => $fecha_registro,
                    'descripcion' => $descripcion
                ]);
            } else {
                // Crear nuevo saldo
                $id_ingresos = 'SI' . substr(uniqid(), 0, 8) . rand(10, 99);
                $saldo_anterior = 0;

                SaldoInicial::create([
                    'id_ingresos' => $id_ingresos,
                    'descripcion' => $descripcion,
                    'fecha_registro' => $fecha_registro,
                    'monto' => $monto,
                    'id_usuario' => $id_usuario,
                    'id_conpsaldo' => $id_concepto
                ]);
            }

            // 4. Guardar en histórico con más información
            $id_movimiento = 'MV' . substr(uniqid(), 0, 8) . rand(10, 99);

            \DB::table('saldoinicial_historico')->insert([
                'id_movimiento' => $id_movimiento,
                'id_saldo' => $id_ingresos,
                'monto_anterior' => $saldo_anterior ?? 0, // Agregar este campo si no existe
                'monto' => $monto,
                'descripcion' => $descripcion,
                'fecha_registro' => $fecha_registro,
                'id_conpsaldo' => $id_concepto,
                'id_usuario' => $id_usuario,
                'tipo_movimiento' => $saldo_existente ? 'Ajuste' : 'Inicial',
                'status' => 'Activo',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            \DB::commit();

            return response()->json([
                'success' => true,
                'data' => [
                    'id_ingresos' => $id_ingresos,
                    'monto' => $monto
                ]
            ], 201);
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Error al guardar saldo inicial: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud'
            ], 500);
        }
    }

    //obtener el listado de saldo inicial
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

    // obtener totales agrupados por concepto
    public function totalsAllConcepts()
    {
        $totales = SaldoInicial::selectRaw('saldoinicial.id_conpsaldo, csi.concepto, SUM(saldoinicial.monto) AS total')
            ->join('conceptosaldo_init as csi', 'saldoinicial.id_conpsaldo', '=', 'csi.id_conpsaldo')
            ->groupBy('saldoinicial.id_conpsaldo', 'csi.concepto')
            ->orderBy('csi.concepto', 'asc')
            ->get();

        // formatear totales a 2 decimales
        $totales = $totales->map(function ($row) {
            $row->total = number_format((float)$row->total, 2, '.', ',');
            return $row;
        });

        return response()->json([
            'success' => true,
            'totales' => $totales
        ], 200);
    }

    //Eliminar registro de saldo inicial
    public function destroy($id)
    {

        //validar si tiene movimientos historicos
        $validarMovimientos = SaldoInicial::select('saldoinicial.id_ingresos')
            ->join('saldoinicial_historico as s', 's.id_saldo', '=', 'saldoinicial.id_ingresos')
            ->where('saldoinicial.id_ingresos', $id)
            ->first();

        if ($validarMovimientos) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar un saldo inicial con movimientos historicos'
            ], 200);
        }

        $validarExiste = SaldoInicial::select('saldoinicial.id_ingresos')
            ->where('saldoinicial.id_ingresos', $id)  
            ->first();

        if (!$validarExiste) {
            return response()->json([
                'success' => false
            ], 404);
        } else {
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
