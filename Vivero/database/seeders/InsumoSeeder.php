<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Insumo;
use App\Models\Producto;

class InsumoSeeder extends Seeder
{
    public function run(): void
    {
        // Crear insumos
        $insumos = [
            'Sustrato Universal' => [
                ['nombre' => 'Bolsa 20L', 'cantidad' => 10, 'costo_unitario' => 1500],
            ],
            'Maceta Plástica Negra' => [
                ['nombre' => 'Maceta 10cm', 'cantidad' => 20, 'costo_unitario' => 250],
            ],
            'Fertilizante NPK' => [
                ['nombre' => 'Sobre 500g', 'cantidad' => 8, 'costo_unitario' => 1000],
            ],
        ];

        foreach ($insumos as $nombre => $detalles) {
            $insumo = \App\Models\Insumo::firstOrCreate(
                ['nombre' => $nombre],
                ['cantidad' => 100, 'costo' => 0, 'descripcion' => 'Generado por Seeder']
            );

            foreach ($detalles as $detalle) {
                $insumo->detalles()->create($detalle);
            }

            $total = collect($detalles)->sum(fn($d) => $d['cantidad'] * $d['costo_unitario']);
            $insumo->update(['costo' => (int) ($total / max(1, $insumo->cantidad))]);
        }

        // Asociar al producto con ID fijo
        $producto = Producto::find(1);
        if ($producto) {
            foreach (Insumo::all() as $insumo) {
                $producto->insumos()->syncWithoutDetaching([
                    $insumo->id => ['cantidad' => rand(1, 3)]
                ]);
            }

            echo "✅ Insumos asociados a producto: {$producto->nombre}\n";
        } else {
            echo "⚠️ Producto con ID 1 no encontrado. No se asociaron insumos.\n";
        }
    }
}
