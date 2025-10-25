<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (Auth::check()) {
            // Esto asegura que los permisos estén disponibles incluso al usar middleware de permisos
            Auth::user()->loadMissing('roles.permissions', 'permissions');
        }
    }
}
