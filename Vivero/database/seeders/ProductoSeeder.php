<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Echando a correr factory de productos...');

        Producto::factory()
            ->count(20)
            ->create();

        $this->command->info('Productos creados exitosamente.');
    }
}
