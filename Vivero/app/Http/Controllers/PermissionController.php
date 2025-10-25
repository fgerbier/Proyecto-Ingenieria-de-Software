<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $clienteId = app('clienteActual')->id;

        $permissions = Permission::where('cliente_id', $clienteId)->get();

        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $clienteId = app('clienteActual')->id;

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'cliente_id' => $clienteId,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permiso creado correctamente.');
    }

    public function edit(Permission $permission)
    {
        // Verificar que el permiso pertenece al cliente actual
        if ($permission->cliente_id !== app('clienteActual')->id) {
            abort(403, 'No autorizado.');
        }

        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        if ($permission->cliente_id !== app('clienteActual')->id) {
            abort(403, 'No autorizado.');
        }

        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', 'Permiso actualizado correctamente.');
    }

    public function destroy(Permission $permission)
    {
        if ($permission->cliente_id !== app('clienteActual')->id) {
            abort(403, 'No autorizado.');
        }

        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permiso eliminado correctamente.');
    }
}
