<?php

namespace Database\Seeders;

use App\Models\Work;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class WorkSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        $tareasProduccion = [
            'Crecimiento de plantines',
            'Transplante de plantines a bolsa',
            'Transplante a maceta',
            'Riego diario',
            'Aplicación de fungicida',
            'Fertilización semanal',
            'Revisión de plagas',
        ];

        $tareasVenta = [
            'Preparación de fertilizantes',
            'Preparación de sustratos',
            'Poda de plantas en venta',
            'Eliminación de plantas en mal estado',
            'Reorganización de materiales',
        ];

        // Tareas de Producción
        foreach (range(1, 2) as $i) {
            Work::create([
                'nombre' => $faker->randomElement($tareasProduccion),
                'ubicacion' => 'produccion',
                'responsable' => $faker->name,
                'fecha' => $faker->dateTimeBetween('-5 days', '+5 days')->format('Y-m-d'),
                'estado' => $faker->randomElement(['pendiente', 'en progreso', 'completada']),
            ]);
        }

        // Tareas del Local de Venta
        foreach (range(1, 2) as $i) {
            Work::create([
                'nombre' => $faker->randomElement($tareasVenta),
                'ubicacion' => 'venta',
                'responsable' => $faker->name,
                'fecha' => $faker->dateTimeBetween('-5 days', '+5 days')->format('Y-m-d'),
                'estado' => $faker->randomElement(['pendiente', 'en progreso', 'completada']),
            ]);
        }
    }
}
