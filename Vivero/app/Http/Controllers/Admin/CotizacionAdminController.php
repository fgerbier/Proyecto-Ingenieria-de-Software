<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CotizacionAdminController extends Controller
{
    // Ver listado de cotizaciones
    public function index()
    {
        $cotizaciones = Cotizacion::where('estado', 'enviada')
                            ->with('user')
                            ->latest()
                            ->paginate(10);

        return view('dashboard.quotation.index', compact('cotizaciones'));
    }

    // Ver detalle de una cotización específica
    public function show($id)
    {
        $cotizacion = Cotizacion::with('productos', 'user')->findOrFail($id);

        return view('dashboard.quotation.index', compact('cotizacion'));
    }

    // Enviar una respuesta (correo) al cliente
    public function responder(Request $request, $id)
    {
        $request->validate([
            'mensaje' => 'required|string',
        ]);

        $cotizacion = Cotizacion::with('user')->findOrFail($id);
        $cliente = $cotizacion->user;

        // Aquí puedes usar una clase Mailable si prefieres
        Mail::raw($request->mensaje, function ($message) use ($cliente, $cotizacion) {
            $message->to($cliente->email)
                    ->subject("Respuesta a tu cotización #{$cotizacion->id}");
        });

        // Opcional: actualizar estado
        $cotizacion->estado = 'respondida';
        $cotizacion->save();

        return redirect()->route('dashboard.quotation.index')->with('success', 'Correo enviado exitosamente.');
    }
}
