<?php

namespace Database\Factories;

use App\Models\DetallePedido;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetallePedidoFactory extends Factory
{
    protected $model = DetallePedido::class;

    public function definition(): array
    {
        $producto = Producto::inRandomOrder()->first();
        $cantidad = $this->faker->numberBetween(1, 5);
        $subtotal = $producto->precio * $cantidad;

        return [
            'pedido_id' => null,  // Esto se asignará manualmente en el PedidoSeeder
            'producto_id' => $producto->id,
            'cantidad' => $cantidad,
            'precio_unitario' => $producto->precio,
            'subtotal' => $subtotal,
            'nombre_producto_snapshot' => $producto->nombre,
            'codigo_barras_snapshot' => $producto->codigo_barras,
            'imagen_snapshot' => $producto->imagen,
        ];
    }
}
