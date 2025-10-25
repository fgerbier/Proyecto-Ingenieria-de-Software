<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class MaintenanceReportController extends Controller
{
    public function index()
    {
        if (Gate::denies('gestionar infraestructura')) {
            abort(403);
        }

        $maintenances = MaintenanceReport::latest()->paginate(10);
        return view('maintenances.index', compact('maintenances'));
    }

    public function create()
    {
        Gate::authorize('gestionar infraestructura');
        return view('maintenances.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('gestionar infraestructura');

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pendiente,en progreso,finalizado',
            'cost' => 'nullable|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('maintenance_images', 'public');
        }

        MaintenanceReport::create($data);

        return redirect()->route('maintenance.index')->with('success', 'Reporte creado con éxito.');
    }

    public function edit(MaintenanceReport $maintenance)
    {
        Gate::authorize('gestionar infraestructura');
        return view('maintenances.edit', compact('maintenance'));
    }

    public function update(Request $request, MaintenanceReport $maintenance)
    {
        Gate::authorize('gestionar infraestructura');

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pendiente,en progreso,finalizado',
            'cost' => 'nullable|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($maintenance->image) {
                Storage::disk('public')->delete($maintenance->image);
            }
            $data['image'] = $request->file('image')->store('maintenance_images', 'public');
        }

        $maintenance->update($data);

        return redirect()->route('maintenance.index')->with('success', 'Reporte actualizado con éxito.');
    }

    public function destroy(MaintenanceReport $maintenance)
    {
        Gate::authorize('gestionar infraestructura');

        if ($maintenance->image) {
            Storage::disk('public')->delete($maintenance->image);
        }

        $maintenance->delete();

        return redirect()->route('maintenance.index')->with('success', 'Reporte eliminado con éxito.');
    }
}
