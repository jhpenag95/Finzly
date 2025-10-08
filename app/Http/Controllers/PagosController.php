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

        // return $request->all();

        //Primero validamos los datos
        $validated = $request->validate([
            'id_pagos' => 'required|string|max:36',
            'nombre_pg' => 'required|string|max:255',
            'monto_pg' => 'required|numeric',
            'fecha_pg' => 'required|date',
            'repetcion_pg' => 'nullable|string|max:255',
            'fecha_creacion' => 'nullable|date',
            'fecha_actualizacion' => 'nullable|date',
            'id_usuario' => 'required|string|max:255',
            'id_met_pag' => 'nullable|string|max:255',
            'id_estado_pg' => 'nullable|string|max:255',
            'id_categoria' => 'required|string|max:255',
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date',
        ]);

        $id_pagos = 'PG' . substr(uniqid(), 0, 8) . rand(10, 99);
        $nombre_pg = $request->input('nombre_pg');



        // Limpiar y formatear el monto
        $valorLimpio = str_replace(['.', ','], ['', '.'], $validated['monto_pg']);
        $monto_pg = number_format((float)$valorLimpio, 2, '.', '');

        $fecha_pg = $request->input('fecha_pg');
        $repetcion_pg = $request->input('repetcion_pg');
        $fecha_creacion = now();
        $fecha_actualizacion = now();

        // 2. Obtener usuario autenticado
        $id_usuario = auth()->id() ?? 1; // Fallback solo para desarrollo


        $pago = Pagos::create([
            'id_pagos' => $id_pagos,
            'nombre_pg' => $nombre_pg,
            'monto_pg' => $monto_pg,
            'fecha_pg' => $fecha_pg,
            'repetcion_pg' => $repetcion_pg,
            'fecha_creacion' => $fecha_creacion,
            'fecha_actualizacion' => $fecha_actualizacion,
            'id_usuario' => $id_usuario,
            'id_met_pag' => $request->input('id_met_pag'),
            'id_estado_pg' => $request->input('id_estado_pg'),
            'id_categoria' => $request->input('id_categoria'),
            'created_at' => $request->input('created_at'),
            'updated_at' => $request->input('updated_at'),
        ]);

        return response()->json([
            'success' => true,
            'pago' => $pago
        ], 201);
    }


    // Consultar las categorias
    public function index_categorias()
    {
        $categorias = Categorias::select('id_categoria', 'nombre_cat')->get();
        return response()->json([
            'success' => true,
            'categorias' => $categorias
        ], 200);
    }
}
