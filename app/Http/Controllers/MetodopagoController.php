<?php

namespace App\Http\Controllers;

use App\Models\Metodopago;
use Illuminate\Http\Request;

class MetodopagoController extends Controller
{
    // Muestra el formulario para crear un método de pago
    public function create()
    {
        return view('metodopago.create');
    }

    // Muestra la lista de métodos de pago
    public function metodos_pago()
    {
        return view('metodopago.metodopago');
    }

    //
    public function store(Request $request)
    {
        $request->validate([
            'metodo_pago' => 'required|string|max:255',
            'estatus' => 'nullable|string',
        ]);

        $nombreMetodo = trim($request->input('metodo_pago'));
        $estatus = $request->input('estatus', 'Activo'); // valor por defecto si no se envía
        $idMetodoPago = 'MP' . substr(uniqid(), 0, 8) . rand(10, 99);

        // Validar si ya existe (ignorando mayúsculas/minúsculas)
        $existe = Metodopago::whereRaw('LOWER(nombre_mp) = ?', [strtolower($nombreMetodo)])->exists();

        if ($existe) {
            return response()->json([
                'success' => false,
                'message' => 'El método de pago ya existe.'
            ], 409);
        }

        // Crear el nuevo registro
        Metodopago::create([
            'id_met_pag' => $idMetodoPago,
            'nombre_mp' => $nombreMetodo,
            'estatus_mp' => $estatus,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Método de pago registrado exitosamente.'
        ], 201);
    }

    // Obtener todos los métodos de pago
    public function index()
    {
        $metodosPago = Metodopago::all();
        return response()->json(['metodopago' => $metodosPago]);
    }
}
