<?php

namespace App\Http\Controllers;

use App\Models\Fertilization;
use App\Models\Fertilizante;
use App\Models\Producto;
use Illuminate\Http\Request;

class FertilizationController extends Controller
{
    public function create(Request $request)
{
    $productos = Producto::all();
    $fertilizantes = Fertilizante::all();
    $fertilizante_id = $request->get('fertilizante_id');


    $ultimasFertilizaciones = Fertilization::with('producto', 'fertilizante')
    ->latest()
    ->take(3)
    ->get();

return view('dashboard.fertilizer.create', compact(
    'productos', 'fertilizantes', 'fertilizante_id', 'ultimasFertilizaciones'
));
}


    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'fertilizante_id' => 'required|exists:fertilizantes,id',
            'fecha_aplicacion' => 'required|date',
            'dosis_aplicada' => 'nullable|string|max:100',
            'notas' => 'nullable|string|max:1000',
        ]);

        $existe = Fertilization::where('producto_id', $request->producto_id)
        ->where('fertilizante_id', $request->fertilizante_id)
        ->whereDate('fecha_aplicacion', $request->fecha_aplicacion)
        ->exists();

    if ($existe) {
        return redirect()->back()->withInput()->with('error', 'Ya existe una fertilización registrada para este producto, fertilizante y fecha.');
    }

        Fertilization::create($request->all());

        return redirect()->route('fertilizations.create')->with('success', 'Fertilización registrada exitosamente.');
    }

    public function index()
{
    $fertilizantes = Fertilizante::with('fertilizaciones')->get();
    $productos = Producto::all(); // <--- Asegúrate de esta línea
    $fertilizaciones = Fertilization::with('fertilizante', 'producto')->latest()->get();

    return view('dashboard.fertilizer.fertilizante', compact('fertilizantes', 'productos', 'fertilizaciones'));
}

public function historial()
{
    $fertilizaciones = Fertilization::with('fertilizante', 'producto')->latest()->get();
    return view('dashboard.fertilizer.historial', compact('fertilizaciones'));
}


}




