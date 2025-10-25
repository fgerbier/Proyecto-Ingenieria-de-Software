<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\InsumoDetalle;
use App\Models\Producto;
use App\Models\Finanza;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    public function index(Request $request)
{
    $query = Insumo::with(['productos', 'detalles'])->orderBy('created_at', 'desc');

    if ($request->filled('nombre')) {
        $query->where('nombre', 'like', '%' . $request->nombre . '%');
    }

    $insumos = $query->paginate(10)->withQueryString();

    return view('dashboard.supply.insumos', compact('insumos'));
}

    public function create()
    {
        $productos = Producto::orderBy('nombre')->get();
        return view('dashboard.supply.insumos_edit', [
            'insumo' => null,
            'productos' => $productos,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'productos' => 'nullable|array',
            'productos.*' => 'exists:productos,id',
            'detalles' => 'nullable|array',
            'detalles.*.nombre' => 'required_with:detalles.*.cantidad,detalles.*.costo|string|max:255',
            'detalles.*.cantidad' => 'required_with:detalles.*.nombre|integer|min:1',
            'detalles.*.costo' => 'required_with:detalles.*.nombre|integer|min:0',
        ]);

        $insumo = Insumo::create([
            'nombre' => $request->nombre,
            'cantidad' => $request->cantidad,
            'costo' => 0, // se recalcula abajo
            'descripcion' => $request->descripcion,
        ]);

        $costoTotal = 0;

        if ($request->filled('detalles')) {
            foreach ($request->detalles as $detalle) {
                if (!empty($detalle['nombre']) && isset($detalle['cantidad']) && isset($detalle['costo'])) {
                    $insumo->detalles()->create([
                        'nombre' => $detalle['nombre'],
                        'cantidad' => $detalle['cantidad'],
                        'costo_unitario' => $detalle['costo'],
                    ]);

                    $costoTotal += $detalle['cantidad'] * $detalle['costo'];
                }
            }

            $insumo->update([
                'costo' => $costoTotal / max(1, $request->cantidad),
            ]);
        }

        if ($request->filled('productos')) {
            $insumo->productos()->sync($request->productos);
        }

        if ($costoTotal > 0) {
            Finanza::create([
                'fecha' => now(),
                'tipo' => 'egreso',
                'monto' => $costoTotal,
                'categoria' => 'Compra de Insumos',
                'descripcion' => $request->nombre,
                'created_by' => auth()->id(),
            ]);
        }

        return redirect()->route('dashboard.insumos')->with('success', 'Insumo y subdetalles guardados correctamente.');
    }

    public function edit($id)
    {
        $insumo = Insumo::with('detalles', 'productos')->findOrFail($id);
        $productos = Producto::orderBy('nombre')->get();

        return view('dashboard.supply.insumos_edit', compact('insumo', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $insumo = Insumo::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:insumos,nombre,' . $insumo->id,
            'cantidad' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'productos' => 'nullable|array',
            'productos.*' => 'exists:productos,id',
            'detalles' => 'nullable|array',
            'detalles.*.nombre' => 'required_with:detalles.*.cantidad,detalles.*.costo|string|max:255',
            'detalles.*.cantidad' => 'required_with:detalles.*.nombre|integer|min:1',
            'detalles.*.costo' => 'required_with:detalles.*.nombre|integer|min:0',
        ]);

        $insumo->update([
            'nombre' => $request->nombre,
            'cantidad' => $request->cantidad,
            'descripcion' => $request->descripcion,
        ]);

        $insumo->detalles()->delete();

        $costoTotal = 0;

        if ($request->filled('detalles')) {
            foreach ($request->detalles as $detalle) {
                if (!empty($detalle['nombre']) && isset($detalle['cantidad']) && isset($detalle['costo'])) {
                    $insumo->detalles()->create([
                        'nombre' => $detalle['nombre'],
                        'cantidad' => $detalle['cantidad'],
                        'costo_unitario' => $detalle['costo'],
                    ]);

                    $costoTotal += $detalle['cantidad'] * $detalle['costo'];
                }
            }

            $insumo->update([
                'costo' => $costoTotal / max(1, $request->cantidad),
            ]);
        }

        if ($request->filled('productos')) {
            $insumo->productos()->sync($request->productos);
        }

        return redirect()->route('dashboard.insumos')->with('success', 'Insumo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $insumo = Insumo::findOrFail($id);
        $insumo->delete();

        return redirect()->route('dashboard.insumos')->with('success', 'Insumo eliminado correctamente.');
    }
}
