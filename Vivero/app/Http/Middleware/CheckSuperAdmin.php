<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    /**
     * Verifica si el usuario autenticado tiene rol de superadmin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('home')->with('error', 'Debes iniciar sesión.');
        }

        $user = auth()->user();

        // Acceder directamente a los nombres de los roles asignados
        $roles = $user->roles->pluck('name')->toArray();

        if (!in_array('admin', $roles) && !in_array('superadmin', $roles)) {
            return redirect()->route('home')->with('error', 'Acceso no autorizado.');
        }

        return $next($request);
    }


}