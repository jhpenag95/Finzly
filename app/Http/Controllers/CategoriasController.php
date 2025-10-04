<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function categorias()
    {
        return view('categorias.categorias');
    }

    //función permite obtener todas las categorias
    public function index()
    {
        $categorias = Categorias::all();
        
        return response()->json([
            'success' => true,
            'data' => $categorias
        ], 200);
    }

    //función permite registrar
    public function store(Request $request)
    {
        $id_categoria       = 'CAT' . substr(uniqid(), 0, 8) . rand(10, 99);
        $nombre_cat         = $request->input('nombre_categoria');
        $color_cat          = $request->input('color_categoria');
        $icono_cat          = $request->input('icono_categoria');
        $created_at         = date('Y-m-d H:i:s'); //este campo es la fecha de creacion
        $updated_at         = date('Y-m-d H:i:s'); //este campo es la fecha de actualizacion

        $categoria = Categorias::create([
            'id_categoria' => $id_categoria,
            'nombre_cat' => $nombre_cat,
            'color_cat' => $color_cat,
            'icono_cat' => $icono_cat,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);

        if (!$categoria) {
            return response()->json([
                'success' => false
            ], 500);
        } else {
            return response()->json([
                'success' => true,
            ], 201);
        }
    }

    //función permite actualizar
    public function update(Request $request){
        

        $id_categoria = $request->input('id_categoria');
        $categoria = Categorias::find($id_categoria);

        if (!$categoria) {
            return response()->json([
                'success' => false
            ], 404);
        }

        $categoria->update([
            'nombre_cat' => $request->input('nombre_cat'),
            'color_cat' => $request->input('color_cat'),
            'icono_cat' => $request->input('icono_cat'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return response()->json([
            'success' => true
        ], 200);
    }

    //función permite eliminar
    public function destroy(Request $request)
    {

        $id_categoria = $request->input('id_categoria');
        $categoria = Categorias::find($id_categoria);

        if (!$categoria) {
            return response()->json([
                'success' => false
            ], 404);
        }
        $categoria->delete();
        return response()->json([
            'success' => true
        ], 200);
    }

    
}
