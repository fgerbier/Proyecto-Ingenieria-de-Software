<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function index()
    {
        $works = Work::orderBy('fecha', 'desc')->get();
        return view('dashboard.works.index', compact('works'));
    }

    public function create()
    {
        // Obtener todos los usuarios que no tienen el rol 'user'
        $responsables = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'user');
        })->get();

        return view('dashboard.works.create', compact('responsables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|in:produccion,venta',
            'responsable' => 'required|string|max:100',
            'fecha' => 'required|date',
            'estado' => 'required|in:pendiente,en progreso,completada',
        ]);

        Work::create($request->all());

        return redirect()->route('works.index')->with('success', 'Tarea creada correctamente.');
    }

    public function edit(Work $work)
    {
        return view('dashboard.works.edit', compact('work'));
    }

    public function update(Request $request, Work $work)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|in:produccion,venta',
            'responsable' => 'required|string|max:100',
            'fecha' => 'required|date',
            'estado' => 'required|in:pendiente,en progreso,completada',
        ]);

        $work->update($request->all());

        return redirect()->route('works.index')->with('success', 'Tarea actualizada correctamente.');
    }

    public function destroy(Work $work)
    {
        $work->delete();

        return redirect()->route('works.index')->with('success', 'Tarea eliminada correctamente.');
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,en progreso,completada',
        ]);

        $tarea = Work::findOrFail($id);
        $tarea->estado = $request->estado;
        $tarea->save();

        return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }

}
