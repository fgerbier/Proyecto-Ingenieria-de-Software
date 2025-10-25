<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('tenant', function ($builder) {
            $clienteId = null;

            if (auth()->check()) {
                $clienteId = auth()->user()->cliente_id;
            }

            if ($clienteId) {
                $builder->where('permissions.cliente_id', $clienteId); // ✅ correcto
            }
        });
    }
}
