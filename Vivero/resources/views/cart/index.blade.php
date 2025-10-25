@extends('layouts.home')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h2 class="text-3xl font-bold mb-8 text-[#486379] text-center">Tu Carrito</h2>

    @if (session('cart') && count(session('cart')) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Lista de productos -->
            <div class="lg:col-span-2 space-y-6">
                @foreach (session('cart') as $id => $item)
                    <div class="flex flex-col sm:flex-row items-center bg-white shadow-md rounded-lg overflow-hidden p-4 gap-4">
                        <img src="{{ $item['imagen'] }}" alt="{{ $item['nombre'] }}" class="w-28 h-28 object-cover rounded-lg border">
                        <div class="flex-1 w-full">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $item['nombre'] }}</h3>
                            <p class="text-sm text-gray-500 mb-2">Precio: ${{ number_format($item['precio'], 0, ',', '.') }}</p>

                            <div class="flex flex-col sm:flex-row items-center gap-3">
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1"
                                        class="w-16 px-2 py-1 border rounded text-center">
                                    <button type="submit"
                                        class="px-3 py-1 text-white text-sm rounded"
                                        style="background-color: #70A37F;">
                                        Actualizar
                                    </button>
                                </form>
                                <form action="{{ route('cart.remove.solo', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:underline text-sm">Eliminar</button>
                                </form>
                            </div>
                        </div>
                        <div class="text-right font-semibold text-gray-800">
                            ${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach

                <!-- Descuento -->
                <div class="bg-gray-50 border rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-2 text-[#486379]">Aplicar Código de Descuento</h3>
                    <form action="{{ route('cart.aplicar-descuento') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                        @csrf
                        <input type="text" name="codigo" placeholder="Ingresa tu código"
                            class="flex-1 px-3 py-2 border rounded">
                        <button type="submit"
                            class="px-4 py-2 text-white rounded"
                            style="background-color: #79B473;">
                            Aplicar
                        </button>
                    </form>
                    @if(session('descuento_error'))
                        <p class="mt-2 text-sm text-red-600">{{ session('descuento_error') }}</p>
                    @endif
                    @if(session('descuento_aplicado'))
                        <div class="mt-4 bg-green-100 border-l-4 border-green-500 p-3 text-green-800 rounded">
                            <p class="font-bold">Descuento aplicado:</p>
                            <p>
                                Código: {{ session('descuento_aplicado.codigo') }} -
                                @if(session('descuento_aplicado.tipo') === 'porcentaje')
                                    {{ session('descuento_aplicado.valor') }}% de descuento
                                @elseif(session('descuento_aplicado.tipo') === 'monto_fijo')
                                    ${{ number_format(session('descuento_aplicado.valor'), 0, ',', '.') }} de descuento
                                @else
                                    Envío gratis
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Resumen -->
            <div class="p-6 rounded-lg shadow-md sticky top-10" >
                <h3 class="text-xl font-bold mb-4 border-b pb-2 text-[#486379]">Resumen del Pedido</h3>
                @php
                    $subtotal = array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], session('cart', [])));
                    $descuentoTotal = 0;
                    if (session('descuento_aplicado')) {
                        foreach (session('cart', []) as $item) {
                            if (isset($item['precio_con_descuento'])) {
                                $descuentoTotal += ($item['precio'] - $item['precio_con_descuento']) * $item['cantidad'];
                            }
                        }
                    }
                    $total = $subtotal - $descuentoTotal;
                @endphp

                <div class="space-y-2 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span>${{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if ($descuentoTotal > 0)
                        <div class="flex justify-between text-green-600 font-semibold">
                            <span>Descuento:</span>
                            <span>- ${{ number_format($descuentoTotal, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-lg font-bold border-t pt-2 mt-2">
                        <span>Total:</span>
                        <span>${{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <form action="{{ route('cart.vaciar') }}" method="POST" class="mt-6">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full text-white py-2 rounded hover:opacity-90">
                        Vaciar Carrito
                    </button>
                </form>

        <form action="{{ route('checkout.pay') }}" method="POST" class="mt-6 space-y-4" x-data="{ metodo: 'retiro' }">
        @csrf
        <input type="hidden" name="amount" value="{{ $total }}">

        <form action="{{ route('checkout.pay') }}" method="POST" class="mt-6 space-y-4" x-data="{ metodo: 'retiro', guardar: false }">
    @csrf
    <input type="hidden" name="amount" value="{{ $total }}">

    <!-- Método de entrega -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">¿Cómo deseas recibir tu pedido?</label>
        <div class="flex gap-4">
            <label class="inline-flex items-center">
                <input type="radio" name="metodo_entrega" value="retiro" x-model="metodo" checked class="text-green-600 focus:ring-green-500 border-gray-300">
                <span class="ml-2">Retiro en tienda</span>
            </label>
        </div>
    </div>


    <button type="submit" class="w-full text-white py-2 rounded hover:opacity-90" style="background-color: #40C239;">
        Proceder al Pago con Webpay
    </button>
</form>


            </div>
        </div>
    @else
        <div class="bg-white p-8 rounded-lg shadow text-center mt-10">
            <p class="text-gray-700 text-lg">Tu carrito está vacío.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block text-blue-600 hover:underline">Volver a la tienda</a>
        </div>
    @endif
</div>
@endsection
