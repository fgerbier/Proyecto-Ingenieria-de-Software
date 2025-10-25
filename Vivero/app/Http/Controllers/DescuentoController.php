<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Descuento;

class DescuentoController extends Controller
{
    public function mostrarTodos()
    {
        $descuentos = Descuento::all();
        return view('dashboard.discounts.descuentos', compact('descuentos'));
    }
    public function create()
    {
        return view('dashboard.discounts.descuentos_edit');
    }
    public function store(Request $request)
    {
        $descuento = new Descuento();
        $descuento->nombre = $request->input('nombre');
        $descuento->codigo = $request->input('codigo');
        $descuento->descripcion = $request->input('descripcion');
        $descuento->porcentaje = $request->input('porcentaje');
        $descuento->monto_fijo = $request->input('monto_fijo');
        $descuento->tipo = $request->input('tipo');
        $descuento->valido_desde = $request->input('valido_desde');
        $descuento->valido_hasta = $request->input('valido_hasta');
        $descuento->activo = $request->input('activo');
        $descuento->usos_maximos = $request->input('usos_maximos');
        $descuento->usos_actuales = 0; // Inicialmente 0
        $descuento->save();

        return redirect()->route('dashboard.discounts.descuentos')->with('success', 'Descuento creado exitosamente.');
    }
    public function edit($id)
    {
        $descuento = Descuento::findOrFail($id);
        return view('dashboard.discounts.descuentos_edit', compact('descuento'));
    }
    public function update(Request $request, $id)
    {
        $descuento = Descuento::findOrFail($id);
        $descuento->nombre = $request->input('nombre');
        $descuento->codigo = $request->input('codigo');
        $descuento->descripcion = $request->input('descripcion');
        $descuento->porcentaje = $request->input('porcentaje');
        $descuento->monto_fijo = $request->input('monto_fijo');
        $descuento->tipo = $request->input('tipo');
        $descuento->valido_desde = $request->input('valido_desde');
        $descuento->valido_hasta = $request->input('valido_hasta');
        $descuento->activo = $request->input('activo');
        $descuento->usos_maximos = $request->input('usos_maximos');
        // No actualizamos usos_actuales aquí
        $descuento->save();

        return redirect()->route('dashboard.descuentos')->with('success', 'Descuento actualizado exitosamente.');
    }
    public function destroy($id)
    {
        $descuento = Descuento::findOrFail($id);
        $descuento->delete();

        return redirect()->route('dashboard.descuentos')->with('success', 'Descuento eliminado exitosamente.');
    }
}
