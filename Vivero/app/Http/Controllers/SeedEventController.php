<?php

namespace App\Http\Controllers;

use App\Models\SeedEvent;
use Illuminate\Http\Request;

class SeedEventController extends Controller
{
    public function index()
    {
        $eventos = SeedEvent::all();
        return view('dashboard.calendar.index', compact('eventos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'planta' => 'required|string|max:255',
            'fecha_siembra' => 'required|date',
            'fecha_trasplante' => 'nullable|date|after_or_equal:fecha_siembra',
        ]);

        SeedEvent::create($request->all());

        return back()->with('success', 'Evento registrado correctamente.');
    }

    public function eventosJson()
    {
        $eventos = SeedEvent::all()->map(function ($evento) {
            return [
                [
                    'title' => 'Siembra de ' . $evento->planta,
                    'start' => $evento->fecha_siembra,
                    'color' => '#16a34a'
                ],
                [
                    'title' => 'Trasplante de ' . $evento->planta,
                    'start' => $evento->fecha_trasplante,
                    'color' => '#f59e0b'
                ]
            ];
        })->flatten(1);

        return response()->json($eventos);
    }
}
