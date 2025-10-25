<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Evita aplicar scopes en consola o sin sesión iniciada
        if (!App::runningInConsole() && Auth::check()) {

            // Scope global para roles multitenant
            Role::addGlobalScope('tenant_roles', function (Builder $builder) {
                $builder->where('roles.cliente_id', Auth::user()->cliente_id);
            });

            // Scope global para permisos multitenant
            Permission::addGlobalScope('tenant_permissions', function (Builder $builder) {
                $builder->where('permissions.cliente_id', Auth::user()->cliente_id);
            });

            // Define teamId para Spatie si existe la columna
            if (Schema::hasColumn('role_has_permissions', 'cliente_id')) {
                app(\Spatie\Permission\PermissionRegistrar::class)
                    ->setPermissionsTeamId(Auth::user()->cliente_id);
            }
        }
    }
}
