<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permisos = [
        'ver dashboard',
        'gestionar usuarios',
        'gestionar roles',
        'gestionar permisos',
        'ver reportes',
        'gestionar productos',
        'gestionar clientes',
        'gestionar pedidos',
        'gestionar fertilizantes',
        'gestionar insumos',
        'gestionar trabajadores',
        'ver calendario',
        // Permisos adicionales para que el sidebar funcione
        'ver panel soporte',
        'gestionar catálogo',
        'ver roles',
        'gestionar descuentos',
        'gestionar tareas',
        'gestionar proveedores',
        'gestionar cuidados',
        'gestionar finanzas',
        'ver mantenimiento',
        'crear roles',
        'editar roles',
        'eliminar roles',
        'gestionar produccion',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => 'web',
                'cliente_id' => null, // 👈 importante
            ]);
        }

        $this->command->info('✅ Permisos globales creados correctamente.');
    }
}
