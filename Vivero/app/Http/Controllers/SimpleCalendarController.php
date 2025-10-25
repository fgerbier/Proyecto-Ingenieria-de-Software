<?php

namespace App\Http\Controllers;

use App\Models\SimpleCalendarEvent;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SimpleCalendarController extends Controller
{
    public function index()
    {
        $eventos = SimpleCalendarEvent::all()->flatMap(function ($evento) {
            $fechaSiembra = Carbon::parse($evento->fecha_siembra);
            $fechaTrasplante = $evento->fecha_trasplante ? Carbon::parse($evento->fecha_trasplante) : null;
            $hoy = Carbon::today();

            $diasTranscurridos = null;
            if ($fechaSiembra->lte($hoy)) {
                $diasTranscurridos = $fechaSiembra->diffInDays($hoy);
            }

            $diasRestantes = $fechaTrasplante ? $hoy->diffInDays($fechaTrasplante, false) : null;

            return collect([
                [
                    'title' => $evento->planta,
                    'start' => $fechaSiembra->toDateString(),
                    'color' => '#16a34a',
                    'extendedProps' => [
                        'tipo' => 'Siembra',
                        'planta' => $evento->planta,
                        'cantidad' => $evento->cantidad,
                        'fecha_siembra' => $fechaSiembra->toDateString(),
                        'fecha_trasplante' => $fechaTrasplante?->toDateString(),
                        'dias_transcurridos' => $diasTranscurridos,
                        'dias_restantes' => $diasRestantes,
                        'plantin_id' => $evento->plantin_id,
                    ],
                ],
                $fechaTrasplante ? [
                    'title' => $evento->planta,
                    'start' => $fechaTrasplante->toDateString(),
                    'color' => '#f59e0b',
                    'extendedProps' => [
                        'tipo' => 'Trasplante',
                        'planta' => $evento->planta,
                        'cantidad' => $evento->cantidad,
                        'fecha_siembra' => $fechaSiembra->toDateString(),
                        'fecha_trasplante' => $fechaTrasplante->toDateString(),
                        'dias_transcurridos' => $diasTranscurridos,
                        'dias_restantes' => $diasRestantes,
                        'plantin_id' => $evento->plantin_id,
                    ],
                ] : null
            ])->filter();
        });

        return view('dashboard.simple_calendar.index', compact('eventos'));
    }

    public function create()
    {
        return view('dashboard.simple_calendar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'planta' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'fecha_siembra' => 'required|date|before_or_equal:today',
            'fecha_trasplante' => 'nullable|date|after_or_equal:fecha_siembra',
            'plantin_id' => 'required|integer',
        ]);

        SimpleCalendarEvent::create([
            'planta' => $request->planta,
            'fecha_siembra' => $request->fecha_siembra,
            'cantidad' => $request->cantidad,
            'fecha_trasplante' => $request->fecha_trasplante,
            'plantin_id' => $request->plantin_id,
        ]);

        return redirect()->route('simple_calendar.index')->with('success', 'Evento registrado.');
    }

    public function alertasTransplante()
    {
        $hoy = Carbon::today();
        return SimpleCalendarEvent::whereDate('fecha_trasplante', $hoy->copy()->addDay())->get();
    }
}
