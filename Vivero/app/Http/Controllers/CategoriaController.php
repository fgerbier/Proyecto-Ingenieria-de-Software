<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view('dashboard/catalog/categories', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
        ]);

        Categoria::create(['nombre' => $request->nombre]);

        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function add()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view('dashboard/catalog/categories_add', compact('categorias'));
    }
    public function edit(Categoria $categoria)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view('dashboard/catalog/categories_edit', compact('categorias', 'categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        if ($categoria->nombre === 'Sin Categorizar') {
            return redirect()->route('categorias.index')->with('error', 'No puedes editar esta categoría.');
        }

        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
        ]);

        $categoria->update(['nombre' => $request->nombre]);

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada.');
    }

    public function destroy(Categoria $categoria)
    {
        if ($categoria->nombre === 'Sin Categorizar') {
            return redirect()->route('categorias.index')->with('error', 'No puedes eliminar esta categoría.');
        }

        $sinCategoria = Categoria::firstOrCreate(['nombre' => 'Sin Categorizar']);

        Producto::where('categoria_id', $categoria->id)
                ->update(['categoria_id' => $sinCategoria->id]);

        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada.');
    }
}
