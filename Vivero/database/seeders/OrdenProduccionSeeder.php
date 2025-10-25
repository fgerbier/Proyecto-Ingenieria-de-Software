<?php

namespace Database\Seeders;

use App\Models\OrdenProduccion;
use App\Models\Producto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class OrdenProduccionSeeder extends Seeder
{
    public function run(): void
    {
        // Asegúrate de tener al menos 3 productos en la tabla productos
        $productos = Producto::all();

        if ($productos->count() === 0) {
            $this->command->warn('⚠️ No hay productos en la base de datos. Crea productos antes de ejecutar este seeder.');
            return;
        }

        foreach (range(1, 5) as $i) {
            OrdenProduccion::create([
                'codigo' => 'ORD-' . strtoupper(Str::random(6)),
                'producto_id' => $productos->random()->id,
                'cantidad' => rand(20, 100),
                'fecha_inicio' => Carbon::now()->subDays(rand(0, 10)),
                'fecha_fin_estimada' => Carbon::now()->addDays(rand(5, 15)),
                'estado' => collect(['pendiente', 'en proceso', 'completada'])->random(),
                'observaciones' => fake()->sentence(),
            ]);
        }
    }
}
