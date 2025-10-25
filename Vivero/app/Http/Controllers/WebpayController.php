<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Transbank\Webpay\WebpayPlus\Transaction;
use Transbank\Webpay\Options;

class WebpayController extends Controller
{
    protected $transaction;

    public function __construct()
    {
        // ✅ Usa configuración desde config/transbank.php
        $options = new Options(
            config('transbank.commerce_code'),
            config('transbank.api_key'),
            config('transbank.environment')
        );

        $this->transaction = new Transaction($options);
    }

    public function pagar(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('checkout.index')->with('error', 'Tu carrito está vacío.');
        }

        $amount = collect($cart)->sum(fn($item) => (int)$item['precio_unitario'] * (int)$item['cantidad']);

        $buyOrder  = uniqid('order_');
        $sessionId = session()->getId();
        $returnUrl = route('webpay.respuesta');

        $response = $this->transaction->create($buyOrder, $sessionId, $amount, $returnUrl);

        session([
            'carrito_pago' => $cart,
            'buy_order' => $buyOrder,
            'monto_total' => $amount,
            'metodo_entrega' => $request->input('metodo_entrega', 'retiro'),
            'direccion_entrega' => $request->input('metodo_entrega') === 'domicilio' ? $request->input('direccion_entrega') : null,
        ]);

        return redirect($response->getUrl() . '?token_ws=' . $response->getToken());
    }

    public function respuesta(Request $request)
    {
        $token = $request->get('token_ws');

        if (!$token) {
            return redirect()->route('checkout.index')->with('error', 'Transacción cancelada.');
        }

        $result = $this->transaction->commit($token);

        if ($result->isApproved()) {
            $user = auth()->user();
            $cart = session('carrito_pago', []);
            $total = session('monto_total');

            $pedido = Pedido::create([
                'usuario_id' => $user->id,
                'total' => $total,
                'estado_pedido' => 'pendiente',
                'metodo_entrega' => session('metodo_entrega', 'retiro'),
                'direccion_entrega' => session('direccion_entrega'),
            ]);

            foreach ($cart as $item) {
                $pedido->productos()->attach($item['producto_id'], [
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['cantidad'] * $item['precio_unitario'],
                    'nombre_producto_snapshot' => $item['nombre'],
                    'codigo_barras_snapshot' => $item['codigo_barras'] ?? null,
                    'imagen_snapshot' => $item['imagen'] ?? null,
                ]);
            }

            session()->forget([
                'carrito_pago', 'buy_order', 'monto_total', 'cart',
                'metodo_entrega', 'direccion_entrega'
            ]);

            return redirect()->route('checkout.index')->with('success', 'Pago exitoso. Pedido registrado.');
        }

        return redirect()->route('checkout.index')->with('error', 'Pago rechazado.');
    }
}
