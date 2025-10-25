<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Transbank\Webpay\WebpayPlus\Transaction;
use App\Models\Pedido;
use App\Models\Producto;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function pay(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
            'metodo_entrega' => 'required|in:retiro,domicilio',
            'direccion_entrega' => 'required_if:metodo_entrega,domicilio|string|nullable',
        ]);

        $amount = intval($request->input('amount'));
        $sessionId = uniqid();
        $buyOrder = uniqid('ORDER_');
        $returnUrl = route('checkout.response');

        // Guardar en sesión el método y la dirección si aplica
        session([
            'metodo_entrega' => $request->input('metodo_entrega'),
            'direccion_entrega' => $request->input('metodo_entrega') === 'domicilio' && $request->has('guardar_direccion')
                ? $request->input('direccion_entrega')
                : null,
        ]);

        $transaction = new Transaction();
        $response = $transaction->create($buyOrder, $sessionId, $amount, $returnUrl);

        return redirect()->away($response->getUrl() . '?token_ws=' . $response->getToken());
    }



    public function response(Request $request)
    {
        $token = $request->input('token_ws');

        if (!$token) {
            return redirect()->route('checkout.cancel');
        }

        $transaction = new Transaction();
        $response = $transaction->commit($token);

        if ($response->isApproved()) {
            $cart = session('cart', []);
            $user = auth()->user();

            // Crear pedido con método y dirección de entrega
            $pedido = Pedido::create([
                'usuario_id' => $user->id,
                'total' => 0,
                'estado_pedido' => 'pendiente',
                'metodo_entrega' => session('metodo_entrega', 'retiro'),
                'direccion_entrega' => session('direccion_entrega'),
            ]);

            $subtotal = 0;

            foreach ($cart as $id => $item) {
                $itemSubtotal = $item['precio'] * $item['cantidad'];
                $subtotal += $itemSubtotal;

                $pedido->productos()->attach($id, [
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $itemSubtotal,
                    'nombre_producto_snapshot' => $item['nombre'],
                    'codigo_barras_snapshot' => $item['codigo_barras'] ?? null,
                    'imagen_snapshot' => $item['imagen'] ?? null,
                ]);
            }

            $impuesto = $subtotal * 0.19;
            $total = $subtotal + $impuesto;

            $pedido->update(['total' => $total]);

            // Guardar resumen para mostrar en la vista de éxito
            session()->put('resumen_compra', [
                'items' => $cart,
                'subtotal' => $subtotal,
                'impuesto' => $impuesto,
                'total' => $total,
                'codigo_autorizacion' => $response->getAuthorizationCode(),
                'pedido_id' => $pedido->id,
                'metodo_entrega' => $pedido->metodo_entrega,
                'direccion_entrega' => $pedido->direccion_entrega,
            ]);

            session()->forget(['cart', 'metodo_entrega', 'direccion_entrega']);

            return view('checkout.success', ['response' => $response]);
        }

        return redirect()->route('checkout.cancel');
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('home');
    }
}
