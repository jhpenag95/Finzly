<?php

namespace App\Http\Controllers;

use App\Models\Pagos;
use App\Models\Categorias;
use Illuminate\Http\Request;

class PagosController extends Controller
{
    public function pagos()
    {
        return view('pagos.pagos');
    }

    public function store(Request $request)
    {
        $id_pagos           = 'PG' . substr(uniqid(), 0, 8) . rand(10, 99);
        $nombre_pg          = $request->input('concepto');
        $categoria_pg       = $request->input('categoria');
        $monto_pg           = number_format((float)$request->input('valor'), 2, '.', '');
        $fecha_pg           = date('paymentdate');
        $repetcion_pg       = $request->input('repeticion');
        $fecha_creacion     = $request->input('metodo_pago');
        $id_usuario         = 1;
        $id_met_pag         = 1;
        $id_estado_pg       = 1;
        $id_categoria       = 1;
        $created_at         = date('Y-m-d H:i:s'); //este campo es la fecha de creacion
        $updated_at         = date('Y-m-d H:i:s'); //este campo es la fecha de actualizacion

        $pagos = Pagos::create([
            'id_pagos'          => $id_pagos,
            'nombre_pg'         => $nombre_pg,
            'categoria_pg'      => $categoria_pg,
            'monto_pg'          => $monto_pg,
            'fecha_pg'          => $fecha_pg,
            'repetcion_pg'      => $repetcion_pg,
            'fecha_creacion'    => $fecha_creacion,
            'id_usuario'        => $id_usuario,
            'id_met_pag'        => $id_met_pag,
            'id_estado_pg'      => $id_estado_pg,
            'id_categoria'      => $id_categoria,
            'created_at'        => $created_at,
            'updated_at'        => $updated_at,
        ]);

        if (!$pagos) {
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
