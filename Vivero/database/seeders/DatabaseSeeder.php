<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            ClienteSeeder::class,
            CategoriaSeeder::class,
            DescuentoSeeder::class,
            ProductoSeeder::class,
            PedidoSeeder::class,
            FertilizanteSeeder::class,
            OrdenProduccionSeeder::class,
            CuidadoSeeder::class,
            FinanzaSeeder::class,
            InsumoSeeder::class,
            ProveedorSeeder::class,
            WorkSeeder::class,
            WorkSeeder::class,
            SoporteSeeder::class,
            ProduccionSeeder::class,
            PreferencesSeeder::class,
            CalendarEventSeeder::class
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
