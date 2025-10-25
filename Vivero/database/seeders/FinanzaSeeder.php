<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Finanza;
use App\Models\User;
use Illuminate\Support\Carbon;

class FinanzaSeeder extends Seeder
{
    public function run(): void
    {
        // Asegurarse de tener al menos un usuario
        $usuario = User::first();
        if (!$usuario) {
            $this->command->warn('⚠️ No hay usuarios. Ejecuta primero UserSeeder o crea uno manualmente.');
            return;
        }

        $registros = [
            [
                'tipo' => 'ingreso',
                'monto' => 250000,
                'fecha' => Carbon::now()->subDays(5),
                'categoria' => 'Ventas',
                'descripcion' => 'Venta mayorista de fertilizantes',
            ],
            [
                'tipo' => 'egreso',
                'monto' => 95000,
                'fecha' => Carbon::now()->subDays(4),
                'categoria' => 'Compra de insumos',
                'descripcion' => 'Insumos para vivero',
            ],
            [
                'tipo' => 'egreso',
                'monto' => 120000,
                'fecha' => Carbon::now()->subDays(3),
                'categoria' => 'Pago de sueldos',
                'descripcion' => 'Sueldos de operarios',
            ],
            [
                'tipo' => 'ingreso',
                'monto' => 125000,
                'fecha' => Carbon::now()->subDays(2),
                'categoria' => 'Ventas',
                'descripcion' => 'Venta directa en sala de ventas',
            ],
            [
                'tipo' => 'egreso',
                'monto' => 18000,
                'fecha' => Carbon::now()->subDay(),
                'categoria' => 'Transporte',
                'descripcion' => 'Envío a cliente rural',
            ],
        ];

        foreach ($registros as $dato) {
            Finanza::create(array_merge($dato, ['created_by' => $usuario->id]));
        }

        $this->command->info('✅ Finanzas insertadas correctamente.');
    }
}
