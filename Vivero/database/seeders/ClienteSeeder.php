<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                'nombre' => 'Plantas Editha',
                'subdominio' => 'editha',
                'slug' => 'plantas-editha',
                'email' => 'admin@editha.com',
                'password' => 'editha',
            ],
        ];

        foreach ($clientes as $data) {
            $cliente = Cliente::firstOrCreate(
                ['nombre' => $data['nombre']],
                [
                    'subdominio' => $data['subdominio'],
                    'slug' => $data['slug'],
                    'activo' => true,
                ]
            );

            $rolAdmin = Role::updateOrCreate(
                ['name' => 'admin', 'cliente_id' => $cliente->id],
                ['guard_name' => 'web']
            );

            $rolUser = Role::updateOrCreate(
                ['name' => 'user', 'cliente_id' => $cliente->id],
                ['guard_name' => 'web']
            );

            // Clonar permisos globales
            $permisosGlobales = Permission::whereNull('cliente_id')->get();
            foreach ($permisosGlobales as $permiso) {
                $nuevo = Permission::firstOrCreate([
                    'name' => $permiso->name,
                    'guard_name' => 'web',
                    'cliente_id' => $cliente->id,
                ]);

                // Asignar manualmente
                DB::table('role_has_permissions')->insertOrIgnore([
                    'permission_id' => $nuevo->id,
                    'role_id' => $rolAdmin->id,
                    'cliente_id' => $cliente->id,
                ]);
            }

            $usuario = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => 'Admin ' . $data['nombre'],
                    'password' => Hash::make($data['password']),
                    'cliente_id' => $cliente->id,
                    'must_change_password' => true,
                ]
            );

            DB::table('model_has_roles')->updateOrInsert(
                [
                    'role_id' => $rolAdmin->id,
                    'model_type' => User::class,
                    'model_id' => $usuario->id,
                ],
                ['cliente_id' => $cliente->id]
            );
        }

        $this->command->info("✅ Clientes, usuarios admin, roles admin/user y permisos creados correctamente.");
    }
}
