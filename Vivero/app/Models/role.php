<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class Role extends SpatieRole
{
    protected $fillable = [
        'name',
        'guard_name',
        'cliente_id',
        'description',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function scopeForTenant(Builder $query, $tenantId = null): Builder
    {
        if (Auth::check() && Auth::user()->hasRole('soporte')) {
            return $query; // soporte puede ver todos los roles
        }

        $tenantId = $tenantId ?? (Auth::check() ? Auth::user()->cliente_id : null);

        return $query->where('cliente_id', $tenantId);
    }

    protected static function booted()
    {
        static::addGlobalScope('tenant', function ($builder) {
            $clienteId = null;
            if (app()->bound('clienteActual')) {
                $clienteId = app('clienteActual')->id;
            }

            if ($clienteId) {
                $builder->where('roles.cliente_id', $clienteId);
            }
        });
    }


    public function isGlobal(): bool
    {
        return $this->name === 'soporte' || is_null($this->cliente_id);
    }

    public function givePermissionTo(...$permissions)
    {
        $permissions = collect($permissions)->flatten()->map(function ($permission) {
            if (is_string($permission)) {
                return \App\Models\Permission::where('name', $permission)
                    ->where('cliente_id', $this->cliente_id)
                    ->first();
            }
            return $permission;
        })->filter()->unique();

        foreach ($permissions as $permission) {
            $pivotData = ['permission_id' => $permission->id, 'role_id' => $this->id];

            if (\Illuminate\Support\Facades\Schema::hasColumn('role_has_permissions', 'cliente_id')) {
                $pivotData['cliente_id'] = $this->cliente_id;
            }

            \DB::table('role_has_permissions')->updateOrInsert(
                ['permission_id' => $permission->id, 'role_id' => $this->id],
                $pivotData
            );
        }

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return $this;
    }
}