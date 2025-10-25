<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SimpleCalendarEvent;
use Carbon\Carbon;

class CalendarEventSeeder extends Seeder
{
    public function run()
    {
        // Limpia los datos previos
        SimpleCalendarEvent::truncate();

        // Eventos de ejemplo con plantin_id
        $eventos = [
            [
                'planta' => 'Tomate',
                'cantidad' => 50,
                'fecha_siembra' => now()->subDays(7)->format('Y-m-d'),
                'fecha_trasplante' => now()->addDays(7)->format('Y-m-d'), // → fecha mayor
                'plantin_id' => 1001,
            ],
            [
                'planta' => 'Lechuga',
                'cantidad' => 100,
                'fecha_siembra' => now()->subDays(10)->format('Y-m-d'),
                'fecha_trasplante' => now()->addDays(4)->format('Y-m-d'),
                'plantin_id' => 1002,
            ],
            [
                'planta' => 'Albahaca',
                'cantidad' => 80,
                'fecha_siembra' => now()->format('Y-m-d'),
                'fecha_trasplante' => null,
                'plantin_id' => 1003,
            ],
        ];
        foreach ($eventos as $evento) {
            SimpleCalendarEvent::create($evento);
        }
    }
}
