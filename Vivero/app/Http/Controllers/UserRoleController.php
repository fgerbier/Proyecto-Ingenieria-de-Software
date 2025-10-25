<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all(); // Se muestra todos los roles sin restricción
        $layout = 'layouts.dashboard';

        return view('dashboard.users.index', compact('users', 'roles', 'layout'));
    }

    public function manageRoles()
    {
        $users = User::with('roles')->get();
        $roles = Role::all(); // Se muestra todos los roles sin restricción
        $layout = 'layouts.dashboard';

        return view('dashboard.users.index', compact('users', 'roles', 'layout'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Sin restricciones de asignación para el rol admin
        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'Rol asignado correctamente.');
    }
}
