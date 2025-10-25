<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $clienteId = auth()->user()->cliente_id;
        $roles = Role::with('permissions')
            ->where('cliente_id', $clienteId)
            ->get();

        $source = 'default';

        return view('dashboard.roles.index', compact('roles', 'source'));
    }

    public function create()
    {
        $clienteId = auth()->user()->cliente_id;
        $permissions = Permission::where('cliente_id', $clienteId)->get();
        $source = request()->get('source', 'default');

        return view('dashboard.roles.create', compact('permissions', 'source'))->with('role', null);
    }

    public function store(Request $request)
    {
        $clienteId = auth()->user()->cliente_id;

        $request->validate([
            'name' => 'required|unique:roles,name,NULL,id,cliente_id,' . $clienteId,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'cliente_id' => $clienteId,
        ]);

        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)
                ->where('cliente_id', $clienteId)
                ->pluck('name');

            $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index', ['source' => $request->get('source', 'default')])
            ->with('success', 'Rol creado exitosamente.');
    }

    public function edit(Role $role)
    {
        $clienteId = auth()->user()->cliente_id;

        // Permitir editar 'admin', proteger solo 'user' y 'soporte'
        if ($role->cliente_id !== $clienteId || in_array($role->name, ['user', 'soporte'])) {
            return redirect()->route('roles.index')->with('error', 'No autorizado o rol protegido.');
        }

        $permissions = Permission::where('cliente_id', $clienteId)->get();
        $source = request()->get('source', 'default');

        return view('dashboard.roles.edit', compact('role', 'permissions', 'source'));
    }

    public function update(Request $request, Role $role)
    {
        $clienteId = auth()->user()->cliente_id;

        // Permitir editar 'admin', proteger solo 'user' y 'soporte'
        if ($role->cliente_id !== $clienteId || in_array($role->name, ['user', 'soporte'])) {
            return redirect()->route('roles.index')->with('error', 'No autorizado o rol protegido.');
        }

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id . ',id,cliente_id,' . $clienteId,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $request->name]);

        $permissions = Permission::whereIn('id', $request->permissions ?? [])
            ->where('cliente_id', $clienteId)
            ->pluck('name');

        $role->syncPermissions($permissions);

        return redirect()->route('roles.index', ['source' => $request->get('source', 'default')])
            ->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(Role $role)
    {
        $clienteId = auth()->user()->cliente_id;

        if ($role->cliente_id !== $clienteId || in_array($role->name, ['user', 'soporte'])) {
            return redirect()->route('roles.index')->with('error', 'No autorizado o rol protegido.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');
    }
}
