<?php

namespace App\Http\Controllers;

use App\Models\SaldoInicialHistorico;

use Illuminate\Http\Request;

class SaldoInicialHistoricoControlador extends Controller
{
    // obtener historial de movimientos por concepto
    public function historyByConcepto($id)
    {
        $movimientos = SaldoInicialHistorico::select('saldoinicial_historico.id_movimiento', 'csi.concepto', 'saldoinicial_historico.monto_anterior', 'saldoinicial_historico.monto', 'saldoinicial_historico.descripcion', 'saldoinicial_historico.fecha_registro', 'saldoinicial_historico.tipo_movimiento')
            ->join('conceptosaldo_init as csi', 'saldoinicial_historico.id_conpsaldo', '=', 'csi.id_conpsaldo')
            ->where('saldoinicial_historico.id_saldo', $id)
            ->orderBy('saldoinicial_historico.fecha_registro', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'historial' => $movimientos
        ], 200);
    }

    // obtener total vigente por concepto
    public function totalByConcepto($id)
    {
        $total = number_format(SaldoInicialHistorico::where('saldoinicial_historico.id_conpsaldo', $id)->sum('saldoinicial_historico.monto'), 2, '.', ',');
        return response()->json([
            'success' => true,
            'id_conpsaldo' => $id,
            'total' => $total
        ], 200);
    }

    // obtener historial de movimientos por id
    public function destroy($id)
    {
        $movimiento = SaldoInicialHistorico::find($id);

        if (!$movimiento) {
            return response()->json([
                'success' => false,
            ], 404);
        }

        $movimiento->delete();

        return response()->json([
            'success' => true,
        ], 200);
    }
}
