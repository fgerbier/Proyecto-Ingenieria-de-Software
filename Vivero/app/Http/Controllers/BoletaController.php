<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class BoletaController extends Controller
{
    /**
     * Mostrar boleta provisoria (pantalla simple).
     */
    public function generar($pedidoId)
    {
        $pedido = Pedido::with('detalles', 'usuario')->findOrFail($pedidoId);

        $subtotal = $pedido->detalles->sum('subtotal');
        $descuentoMonto = $pedido->descuento ?? 0;
        $descuentoPorcentaje = $subtotal > 0 ? ($descuentoMonto / $subtotal) * 100 : 0;
        $impuesto = ($subtotal - $descuentoMonto) * 0.19;
        $totalFinal = $subtotal - $descuentoMonto + $impuesto;

        return view('boletas.provisoria', compact('pedido', 'subtotal', 'descuentoMonto', 'descuentoPorcentaje', 'impuesto', 'totalFinal'));
    }

    /**
     * Generar y descargar PDF.
     */
    public function generarPDF($pedidoId)
    {
        $pedido = Pedido::with('detalles', 'usuario')->findOrFail($pedidoId);

        $subtotal = $pedido->detalles->sum('subtotal');

        $descuentoMonto = $pedido->descuento ?? 0;

        // Calcular el porcentaje de descuento dinámicamente (cuidado con división por cero)
        $descuentoPorcentaje = $subtotal > 0 ? ($descuentoMonto / $subtotal) * 100 : 0;

        $subtotalDesc = $subtotal - $descuentoMonto;

        $impuesto = $subtotalDesc * 0.19;

        $total = $subtotalDesc + $impuesto;

        $pdf = PDF::loadView('boletas.pdf', compact('pedido', 'subtotal', 'descuentoPorcentaje', 'descuentoMonto', 'impuesto', 'total'));

        return $pdf->download("boleta_pedido_{$pedido->id}.pdf");
    }

    /**
     * Guardar boleta PDF subida por el usuario.
     */
    public function guardar(Request $request, $pedidoId)
    {
        $request->validate([
            'boleta' => 'required|mimes:pdf|max:2048',
        ]);

        $pedido = Pedido::findOrFail($pedidoId);

        $file = $request->file('boleta');
        $path = $file->store('boletas', 'public');

        $pedido->boleta_final_path = $path;
        $pedido->save();

        return redirect()->back()->with('success', 'Boleta subida correctamente.');
    }

    /**
     * Generar boleta provisoria desde otra vista.
     */
    public function generarProvisoria($pedidoId)
{
    $pedido = Pedido::with('detalles', 'usuario')->findOrFail($pedidoId);

    $subtotal = $pedido->detalles->sum('subtotal');
    $descuentoPorcentaje = 10.0; // O el porcentaje real que tengas guardado
    $descuentoMonto = $subtotal * ($descuentoPorcentaje / 100);
    $subtotalDesc = $subtotal - $descuentoMonto;
    $impuesto = $subtotalDesc * 0.19;
    $total = $subtotalDesc + $impuesto;

    return view('boletas.boleta', compact(
        'pedido',
        'subtotal',
        'descuentoPorcentaje',
        'descuentoMonto',
        'impuesto',
        'total'
    ));
}
}
