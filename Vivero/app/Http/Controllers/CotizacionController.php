<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class CotizacionController extends Controller
{
    public function index()
    {
        $cotizaciones = Cotizacion::where('user_id', Auth::id())->get();
        return view('quotations.index', compact('cotizaciones'));
    }

    public function store(Request $request)
    {
        $cotizacion = Cotizacion::create([
            'user_id' => Auth::id(),
            'comentario_cliente' => $request->input('comentario'),
        ]);

        return redirect()->route('quotations.show', $cotizacion->id);
    }

    public function show($id)
    {
        $cotizacion = Cotizacion::with('productos')->findOrFail($id);
        $this->authorize('view', $cotizacion);
        return view('quotations.show', compact('cotizacion'));
    }

    public function agregarProducto(Request $request, $id)
    {
        $cotizacion = Cotizacion::findOrFail($id);
        $this->authorize('update', $cotizacion);

        $productoId = $request->input('producto_id');
        $cantidad = (int) $request->input('cantidad', 1);

        $cotizacion->productos()->syncWithoutDetaching([
            $productoId => ['cantidad' => $cantidad]
        ]);

        return back()->with('success', 'Producto añadido a la cotización.');
    }

    public function enviarCotizacion($id)
    {
        $cotizacion = Cotizacion::findOrFail($id);
        //        $this->authorize('update', $cotizacion);

        $cotizacion->update([
            'estado' => 'enviada',
            'enviada_en' => now(),
        ]);
        // dd($cotizacion);

        // Aquí se puede notificar a un empleado o registrar para revisión
        return redirect()->route('cotizacion.index')->with('success', 'Cotización enviada correctamente.');
    }

    // Para uso del panel admin
    public function responderCotizacion(Request $request, $id)
    {
        $cotizacion = Cotizacion::with('user')->findOrFail($id);
        $cotizacion->update(['estado' => 'respondida']);

        //Mail::to($cotizacion->user->email)->send(new \App\Mail\CotizacionRespondida($cotizacion, $request->mensaje));

        return back()->with('success', 'Respuesta enviada al cliente.');
    }
    public function ajaxAgregar(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1|max:99',
        ]);

        $producto = Producto::findOrFail($id);
        $user = Auth::user();

        $cotizacion = Cotizacion::firstOrCreate(
            ['user_id' => $user->id, 'estado' => 'borrador'],
            ['comentario' => null]
        );

        $pivotExists = $cotizacion->productos()->where('producto_id', $producto->id)->exists();

        if ($pivotExists) {
            $currentCantidad = $cotizacion->productos()->where('producto_id', $producto->id)->first()->pivot->cantidad;
            $nuevaCantidad = $currentCantidad + $request->cantidad;

            $cotizacion->productos()->updateExistingPivot($producto->id, ['cantidad' => $nuevaCantidad]);
        } else {
            $cotizacion->productos()->attach($producto->id, ['cantidad' => $request->cantidad]);
        }

        return response()->json(['message' => 'Producto añadido a la cotización correctamente.']);
    }
    public function eliminarCotizacion($id)
    {
        $cotizacion = Cotizacion::findOrFail($id);
        //   $this->authorize('delete', $cotizacion);

        DB::transaction(function () use ($cotizacion) {
            $cotizacion->productos()->detach();
            $cotizacion->delete();
        });

        return redirect()->route('quotations.index')->with('success', 'Cotización eliminada correctamente.');
    }
    public function eliminarProducto($cotizacionId, $productoId)
    {
        $cotizacion = Cotizacion::findOrFail($cotizacionId);
        //    $this->authorize('update', $cotizacion);

        $cotizacion->productos()->detach($productoId);

        if ($cotizacion->productos()->count() === 0) {
            $cotizacion->delete();
            return back()->with('success', 'Cotización descartada.');
        }
        return back()->with('success', 'Producto eliminado de la cotización.');
    }
}
