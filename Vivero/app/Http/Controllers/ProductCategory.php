<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductoCategoria;

class ProductCategory extends Controller
{
    public function index()
    {
        // Obtiene todos los registros de la tabla producto_categoria
        $categoria = ProductoCategoria::all();

        // Retorna la vista 'categoria.index' y le pasa los datos
        return view('categorias.home', compact('categorias'));
    }

    public function show($id)
    {
        // Obtiene un registro específico por ID
        $categoria = ProductoCategoria::findOrFail($id);

        return view('categorias.home', compact('categorias'));
    }
}
