<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class FixModelHasRolesClienteId extends Command
{
    protected $signature = 'fix:roles-clientes';
    protected $description = 'Corrige cliente_id en model_has_roles basándose en el cliente_id del usuario.';

    public function handle()
    {
        $registros = DB::table('model_has_roles')
            ->whereNull('cliente_id')
            ->where('model_type', User::class)
            ->get();

        $this->info("Corrigiendo {$registros->count()} registros...");

        foreach ($registros as $registro) {
            $user = User::find($registro->model_id);
            if ($user && $user->cliente_id) {
                DB::table('model_has_roles')
                    ->where('role_id', $registro->role_id)
                    ->where('model_id', $registro->model_id)
                    ->where('model_type', User::class)
                    ->whereNull('cliente_id')
                    ->update(['cliente_id' => $user->cliente_id]);

                $this->line("✅ Usuario {$user->id} actualizado con cliente_id {$user->cliente_id}");
            }
        }

        $this->info("Proceso terminado.");
        return 0;
    }
}
