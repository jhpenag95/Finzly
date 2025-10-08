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

    // Registra un nuevo método de pago
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


    // Obtener un método de pago por ID
    public function show($id)
    {
        $metodoPago = Metodopago::Select('id_met_pag', 'nombre_mp', 'estatus_mp')
            ->where('id_met_pag', $id)
            ->first();

        if (!$metodoPago) {
            return response()->json([
                'success' => false,
                'message' => 'Método de pago no encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'metodopago' => $metodoPago
        ], 200);
    }



    // Actualizar un método de pago existente
    public function update(Request $request, $id_met_pag)
    {
        $metodoPago = Metodopago::find($id_met_pag);

        if (!$metodoPago) {
            return response()->json([
                'success' => false,
                'message' => 'Método de pago no encontrado.'
            ], 404);
        }

        $request->validate([
            'metodopago' => 'required|string|max:255',
            'estatus' => 'nullable|string',
        ]);

        $metodoPago->update([
            'id_met_pag' => $id_met_pag,
            'nombre_mp' => $request->input('metodopago'),
            'estatus_mp' => $request->input('estatus'), 
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Método de pago actualizado exitosamente.'
        ], 200);
    }

    // Eliminar un método de pago
    public function destroy($id_met_pag)
    {
        $metodoPago = Metodopago::find($id_met_pag);

        if (!$metodoPago) {
            return response()->json([
                'success' => false,
                'message' => 'Método de pago no encontrado.'
            ], 404);
        }

        $metodoPago->delete();

        return response()->json([
            'success' => true,
            'message' => 'Método de pago eliminado exitosamente.'
        ], 200);
    }
}
