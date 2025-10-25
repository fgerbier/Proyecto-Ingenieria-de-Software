<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Produccion;
use Illuminate\Support\Facades\DB;

class ProduccionSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $producto = Producto::find(1);

            if (!$producto) {
                throw new \Exception('❌ El producto con ID 1 no existe.');
            }

            echo "🪴 Usando producto: {$producto->nombre}\n";

            if ($producto->insumos->isEmpty()) {
                throw new \Exception('❌ Este producto no tiene insumos asociados.');
            }

            $cantidadProducida = 10;
            $totalCosto = 0;

            foreach ($producto->insumos as $insumo) {
                $necesaria = $insumo->pivot->cantidad * $cantidadProducida;
                if ($insumo->cantidad < $necesaria) {
                    throw new \Exception("❌ Stock insuficiente para el insumo: {$insumo->nombre}");
                }
            }

            $produccion = Produccion::create([
                'producto_id' => $producto->id,
                'cantidad_producida' => $cantidadProducida,
            ]);

            foreach ($producto->insumos as $insumo) {
                $cantidadUsada = $insumo->pivot->cantidad * $cantidadProducida;

                $insumo->cantidad -= $cantidadUsada;
                $insumo->save();

                $produccion->insumos()->attach($insumo->id, [
                    'cantidad_usada' => $cantidadUsada,
                ]);

                $totalCosto += $cantidadUsada * $insumo->costo;
            }

            $producto->stock += $cantidadProducida;
            $producto->precio_costo = (int) round($totalCosto / $cantidadProducida);
            $producto->save();

            echo "✅ Producción registrada de {$cantidadProducida} unidades.\n";
        });
    }
}
