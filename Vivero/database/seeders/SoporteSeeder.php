<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SoporteSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario soporte
        $soporte = User::firstOrCreate(
            ['email' => 'admin@dan.cl'],
            [
                'name' => 'Dan Ocampo',
                'password' => Hash::make('12345678'),
                'cliente_id' => null,
            ]
        );

        // Crear rol soporte
        $rolSoporte = Role::firstOrCreate([
            'name' => 'soporte',
            'guard_name' => 'web',
            'cliente_id' => null
        ]);

        // Obtener todos los permisos globales
        $permisos = Permission::whereNull('cliente_id')->pluck('name')->toArray();

        // Asignar todos los permisos al rol soporte usando Spatie
        $rolSoporte->syncPermissions($permisos);

        // Asignar el rol al usuario soporte (Spatie-style)
        $soporte->syncRoles([$rolSoporte]);

        $this->command->info("✅ Usuario soporte y todos los permisos globales asignados correctamente.");
    }
}
