<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Producto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VentaSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        $producto = Producto::first();

        if (!$user || !$producto) {
            $this->command->warn('No hay usuario o producto disponible.');
            return;
        }

        DB::table('ventas')->insert([
            [
                'user_id' => $user->id,
                'producto_id' => $producto->id,
                'cantidad' => 3,
                'precio_unitario' => $producto->precio,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('Venta creada exitosamente.');
    }
}
