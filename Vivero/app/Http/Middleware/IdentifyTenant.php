<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\PermissionRegistrar;

class IdentifyTenant
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost(); // ejemplo: dan.localhost
        $subdominio = explode('.', $host)[0];

        // ⚠️ Si es el dominio central (soporte), no aplicar lógica de tenant
        if ($subdominio === 'soporte') {
            app(PermissionRegistrar::class)->setPermissionsTeamId(null);
            return $next($request);
        }

        // Permitir acceso si es localhost o dominio base sin subdominio
        if (in_array($host, ['localhost', '127.0.0.1', 'plantaseditha.me', 'soporte.plantaseditha.me', 'soporte.localhost'])) {
            return $next($request);
        }

        // Buscar el cliente por subdominio
        $cliente = Cliente::where('subdominio', $subdominio)->first();

        if (!$cliente) {
            abort(404, 'Cliente no encontrado');
        }

        // Registrar cliente actual en el contenedor
        app()->instance('clienteActual', $cliente);

        if (Auth::check()) {
            $user = Auth::user();

            // Soporte tiene acceso global sin tenant
            if ($user->hasRole('soporte')) {
                app(PermissionRegistrar::class)->setPermissionsTeamId(null);
                return $next($request);
            }

            // Validar si el usuario pertenece al cliente actual
            if ($user->cliente_id !== $cliente->id) {
                abort(403, 'No tienes acceso a este cliente');
            }

            // Establecer tenant para Spatie
            app(PermissionRegistrar::class)->setPermissionsTeamId($cliente->id);

            // Asegurar que los roles tengan cliente_id correcto
            $this->ensurePivotClienteIdCorrect($user, $cliente->id);
        }

        return $next($request);
    }

    protected function ensurePivotClienteIdCorrect($user, $clienteId)
    {
        foreach ($user->roles as $role) {
            $pivot = $role->pivot;
            if ($pivot && $pivot->cliente_id != $clienteId) {
                $user->roles()->updateExistingPivot($role->id, ['cliente_id' => $clienteId]);
            }
        }
    }
}
