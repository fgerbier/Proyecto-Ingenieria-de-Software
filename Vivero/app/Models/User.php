<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Cliente;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles {
        assignRole as traitAssignRole;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'must_change_password',
        'cliente_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'must_change_password' => 'boolean',
    ];

    public function preference()
    {
        return $this->hasOne(UserPreference::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function getPermissionsTeamId()
    {
        return $this->cliente_id;
    }

    /**
     * Reimplementación de assignRole respetando cliente_id.
     */
    public function assignRole(...$roles)
    {
        $roles = collect($roles)->flatten()->map(function ($role) {
            if (is_string($role)) {
                return Role::where('name', $role)
                    ->where(function ($query) {
                        $query->where('cliente_id', $this->cliente_id)
                              ->orWhereNull('cliente_id');
                    })
                    ->first();
            }
            return $role;
        })->filter();

        return $this->traitAssignRole(...$roles);
    }

    /**
     * Acceder a roles filtrados (opcional).
     */
    public function filteredRoles()
    {
        return $this->roles
            ->where('cliente_id', $this->cliente_id)
            ->values();
    }
}
