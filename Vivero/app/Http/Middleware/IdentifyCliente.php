<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IdentifyCliente
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            app()->instance('currentClienteId', auth()->user()->cliente_id);
        }

        return $next($request);
    }
}
