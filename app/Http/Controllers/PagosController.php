<?php

namespace App\Http\Controllers;

use App\Models\Pagos;
use App\Models\Categorias;
use App\Models\Metodopago;
use Illuminate\Http\Request;

class PagosController extends Controller
{
    public function pagos()
    {
        return view('pagos.pagos');
    }


    public function store(Request $request)
    {

        //return $request->all();

        //Primero validamos los datos
        $validated = $request->validate([
            'concepto'                  => 'required|string|max:255',
            'monto'                     => 'required|numeric',
            'fecha'                     => 'nullable|date',
            'repeticion'                => 'nullable|string|max:255',
            'metodo_pago'               => 'nullable|string|max:36',
            'id_categoria'              => 'required|string|max:36',
        ]);

        $id_pagos = 'PG' . substr(uniqid(), 0, 8) . rand(10, 99);
        $concepto = $request->input('concepto');



        // Limpiar y formatear el monto
        $valorLimpio = str_replace(['.', ','], ['', '.'], $validated['monto']);
        $monto = number_format((float)$valorLimpio, 2, '.', '');

        $fecha_pg = $request->input('fecha') ?? null;
        

        $repetcion_pg = $request->input('repeticion');
        $fecha_creacion = now();
        $fecha_actualizacion = now();

        $id_estado_pg = 'ESP68e4782515';
        // 2. Obtener usuario autenticado
        $id_usuario = auth()->id() ?? 1; // Fallback solo para desarrollo


        $pago = Pagos::create([
            'id_pagos'                  => $id_pagos,
            'nombre_pg'                 => $concepto,
            'monto_pg'                  => $monto,
            'fecha_pg'                  => $fecha_pg,
            'repetcion_pg'              => $repetcion_pg,
            'fecha_creacion'            => $fecha_creacion,
            'fecha_actualizacion'       => $fecha_actualizacion,
            'id_usuario'                => $id_usuario,
            'id_met_pag'                => $request->input('metodo_pago'),
            'id_estado_pg'              => $id_estado_pg,
            'id_categoria'              => $request->input('id_categoria'),
            'created_at'                => $fecha_creacion,
            'updated_at'                => $fecha_actualizacion,
        ]);

        return response()->json([
            'success' => true,
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

    // Consultar los metodos de pago
    public function index_metodos()
    {
        $metodos = Metodopago::select('id_met_pag', 'nombre_mp')->get();
        return response()->json([
            'success' => true,
            'metodos' => $metodos
        ], 200);
    }

    // Obtener el listado de pagos
    public function index()
    {
        $pagos = Pagos::select('id_pagos', 'nombre_pg','categorias.nombre_cat', 'monto_pg', 'fecha_pg', 'repetcion_pg', 'metodopago.nombre_mp','estatuspago.nombre_sp')
        ->join('categorias', 'pagos.id_categoria', '=', 'categorias.id_categoria')
        ->join('metodopago', 'pagos.id_met_pag', '=', 'metodopago.id_met_pag')
        ->join('estatuspago', 'pagos.id_estado_pg', '=', 'estatuspago.id_estado_pg')
        ->get();

        return response()->json([
            'success' => true,
            'pagos' => $pagos
        ], 200);
    }
}
