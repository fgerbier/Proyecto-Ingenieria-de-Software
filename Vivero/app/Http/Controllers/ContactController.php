<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Aquí podrías enviar un correo, guardar en base de datos, etc.

        return back()->with('success', '¡Tu mensaje ha sido enviado con éxito!');
    }
}
