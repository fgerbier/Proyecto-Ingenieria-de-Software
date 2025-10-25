<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Cuidado;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CuidadoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = Producto::all();

        if ($productos->count() === 0) {
            $this->command->warn('⚠️ No hay productos en la base de datos. Crea productos antes de ejecutar este seeder.');
            return;
        }

        $this->command->info('🌱 Generando cuidados para productos...');

        foreach ($productos as $producto) {
            if ($producto->cuidado) {
                $this->command->line("🔄 El producto '{$producto->nombre}' ya tiene un cuidado, se omite.");
                continue;
            }

            Cuidado::create([
                'producto_id' => $producto->id,
                'frecuencia_riego' => collect(['Cada 2 días', 'Semanal', 'Cada 3 días'])->random(),
                'cantidad_agua' => collect(['200 ml', '500 ml', 'Hasta humedecer la tierra'])->random(),
                'tipo_luz' => collect(['Sol directo', 'Sombra parcial', 'Luz filtrada'])->random(),
                'temperatura_ideal' => collect(['18–24°C', '20–28°C', '15–22°C'])->random(),
                'tipo_sustrato' => collect(['Tierra ácida', 'Con perlita', 'Arenoso con buen drenaje'])->random(),
                'frecuencia_abono' => collect(['Cada 15 días', 'Mensual', 'Trimestral'])->random(),
                'plagas_comunes' => collect(['Pulgones', 'Araña roja', 'Mosca blanca'])->random(),
                'cuidados_adicionales' => fake()->sentence(10),
                // 'imagen_url' => null, // <- si quisieras dejarlo explícito
            ]);

            $this->command->info("✅ Cuidado creado para '{$producto->nombre}'");
        }
    }
}
