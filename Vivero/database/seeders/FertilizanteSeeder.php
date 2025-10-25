<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FertilizanteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('fertilizantes')->insert([
            [
                'nombre' => 'Compost Premium',
                'tipo' => 'Orgánico',
                'composicion' => 'Residuos vegetales, estiércol, materia orgánica',
                'descripcion' => 'Fertilizante natural ideal para todo tipo de plantas. Aumenta la retención de humedad y mejora la estructura del suelo.',
                'peso' => 2.5,
                'unidad_medida' => 'kg',
                'presentacion' => 'Bolsa',
                'aplicacion' => 'Aplicar directamente al suelo una vez al mes.',
                'precio' => 7500,
                'stock' => 120,
                'fecha_vencimiento' => '2026-12-31',
                'imagen' => 'fertilizantes/compost.jpg',
                'activo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'NutriPlant Foliar',
                'tipo' => 'Líquido',
                'composicion' => 'NPK 10-10-10, micronutrientes',
                'descripcion' => 'Solución balanceada para plantas de interior. Aumenta el verdor y el crecimiento.',
                'peso' => 0.75,
                'unidad_medida' => 'L',
                'presentacion' => 'Botella',
                'aplicacion' => 'Disolver 5ml por litro de agua y aplicar 1 vez por semana.',
                'precio' => 4900,
                'stock' => 80,
                'fecha_vencimiento' => '2025-11-30',
                'imagen' => 'fertilizantes/nutriplant.jpg',
                'activo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'GreenLawn Césped',
                'tipo' => 'Granulado',
                'composicion' => 'NPK 20-5-10',
                'descripcion' => 'Estimula el crecimiento denso y verde del césped en jardines y parques.',
                'peso' => 5,
                'unidad_medida' => 'kg',
                'presentacion' => 'Saco',
                'aplicacion' => 'Esparcir uniformemente cada 2 meses. Regar después.',
                'precio' => 10500,
                'stock' => 40,
                'fecha_vencimiento' => '2026-06-01',
                'imagen' => 'fertilizantes/greenlawn.jpg',
                'activo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
