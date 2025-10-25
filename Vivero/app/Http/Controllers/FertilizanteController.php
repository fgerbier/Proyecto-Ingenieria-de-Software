<?php

namespace App\Http\Controllers;

use App\Models\Fertilizante;
use Illuminate\Http\Request;

class FertilizanteController extends Controller
{
    public function mostrarTodos(Request $request)
{
    $query = Fertilizante::query();

    if ($request->filled('nombre')) {
        $query->where('nombre', 'like', '%' . $request->nombre . '%');
    }

    if ($request->filled('tipo')) {
        $query->where('tipo', $request->tipo);
    }

    $fertilizantes = $query->paginate(10)->withQueryString();


    return view('dashboard.fertilizer.fertilizante', compact('fertilizantes'));
}



    public function create()
    {
        return view('dashboard.fertilizer.fertilizante_edit');
    }

    public function store(Request $request)
    {
        $fertilizante = new Fertilizante();
        $fertilizante->nombre = $request->input('nombre');
        $fertilizante->tipo = $request->input('tipo');
        $fertilizante->composicion = $request->input('composicion');
        $fertilizante->descripcion = $request->input('descripcion');
        $fertilizante->peso = $request->input('peso');
        $fertilizante->unidad_medida = $request->input('unidad_medida');
        $fertilizante->presentacion = $request->input('presentacion');
        $fertilizante->aplicacion = $request->input('aplicacion');
        $fertilizante->precio = $request->input('precio');
        $fertilizante->stock = $request->input('stock');
        $fertilizante->fecha_vencimiento = $request->input('fecha_vencimiento');
        $fertilizante->activo = $request->input('activo') ? true : false;

        if ($request->hasFile('imagen')) {
            $fertilizante->imagen = $request->file('imagen')->store('fertilizantes', 'public');
        }

        $fertilizante->save();

        return redirect()->route('dashboard.fertilizantes')->with('success', 'Fertilizante creado exitosamente.');
    }

    public function edit($id)
    {
        $fertilizante = Fertilizante::findOrFail($id);
        return view('dashboard.fertilizer.fertilizante_edit', compact('fertilizante'));
    }

    public function update(Request $request, $id)
    {
        $fertilizante = Fertilizante::findOrFail($id);
        $fertilizante->nombre = $request->input('nombre');
        $fertilizante->tipo = $request->input('tipo');
        $fertilizante->composicion = $request->input('composicion');
        $fertilizante->descripcion = $request->input('descripcion');
        $fertilizante->peso = $request->input('peso');
        $fertilizante->unidad_medida = $request->input('unidad_medida');
        $fertilizante->presentacion = $request->input('presentacion');
        $fertilizante->aplicacion = $request->input('aplicacion');
        $fertilizante->precio = $request->input('precio');
        $fertilizante->stock = $request->input('stock');
        $fertilizante->fecha_vencimiento = $request->input('fecha_vencimiento');
        $fertilizante->activo = $request->input('activo') ? true : false;

        if ($request->hasFile('imagen')) {
            $fertilizante->imagen = $request->file('imagen')->store('fertilizantes', 'public');
        }

        $fertilizante->save();

        return redirect()->route('dashboard.fertilizantes')->with('success', 'Fertilizante actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $fertilizante = Fertilizante::findOrFail($id);
        $fertilizante->delete();

        return redirect()->route('dashboard.fertilizantes')->with('success', 'Fertilizante eliminado exitosamente.');
    }
    public function show($id)
{
    $fertilizante = Fertilizante::with('fertilizaciones.producto')->findOrFail($id);
    return view('dashboard.fertilizer.fertilizante', compact('fertilizante'));
}
}
