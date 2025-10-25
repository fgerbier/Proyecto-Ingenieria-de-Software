<?php

namespace Database\Seeders;

use App\Models\Descuento;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DescuentoSeeder extends Seeder
{
    public function run(): void
    {
        $descuentos = [
            [
                'nombre' => 'Verano 20% OFF',
                'codigo' => 'VERANO2023',
                'descripcion' => 'Descuento especial de verano en toda la tienda',
                'porcentaje' => 20.00,
                'tipo' => Descuento::TIPO_PORCENTAJE,
                'valido_desde' => Carbon::now(),
                'valido_hasta' => Carbon::now()->addMonth(),
                'usos_maximos' => 100,
                'activo' => true
            ],
            [
                'nombre' => 'Envío Gratis',
                'codigo' => 'ENVIOGRATIS',
                'descripcion' => 'Envío gratis en compras superiores a $50',
                'tipo' => Descuento::TIPO_ENVIO_GRATIS,
                'valido_desde' => Carbon::now()->subDays(5),
                'valido_hasta' => Carbon::now()->addDays(15),
                'usos_maximos' => 200,
                'activo' => true
            ],
            [
                'nombre' => '$10 OFF Plantas Interiores',
                'codigo' => 'INTERIOR10',
                'descripcion' => 'Descuento fijo en plantas de interior',
                'monto_fijo' => 10.00,
                'tipo' => Descuento::TIPO_MONTO_FIJO,
                'valido_desde' => Carbon::now(),
                'valido_hasta' => Carbon::now()->addWeeks(2),
                'activo' => true
            ],
            [
                'nombre' => 'Black Friday 30%',
                'codigo' => 'BLACK30',
                'descripcion' => 'Descuento de Black Friday',
                'porcentaje' => 30.00,
                'tipo' => Descuento::TIPO_PORCENTAJE,
                'valido_desde' => Carbon::now()->addDays(10),
                'valido_hasta' => Carbon::now()->addDays(12),
                'usos_maximos' => 50,
                'activo' => false
            ],
            [
                'nombre' => 'Primera Compra $15 OFF',
                'codigo' => 'BIENVENIDA15',
                'descripcion' => 'Descuento para nuevos clientes',
                'monto_fijo' => 15.00,
                'tipo' => Descuento::TIPO_MONTO_FIJO,
                'valido_desde' => Carbon::now()->subMonth(),
                'valido_hasta' => null,
                'usos_maximos' => null,
                'activo' => true
            ]
        ];

        foreach ($descuentos as $descuento) {
            Descuento::updateOrCreate(
                ['codigo' => $descuento['codigo']],
                $descuento
            );
        }

        $this->command->info('5 descuentos creados o actualizados exitosamente.');
    }
}
