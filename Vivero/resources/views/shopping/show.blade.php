@extends('layouts.home')

@section('title', 'Detalle de la Compra')

@section('content')
<div class="py-10 px-4 md:px-8 w-full font-roboto_sans text-gray-800">
    <h1 class="text-3xl font-roboto_condensed font-bold mb-8 text-center text-green-800">🧾 Detalle de la Compra</h1>

    <div class="bg-white shadow-md rounded-xl p-6 max-w-3xl mx-auto mb-6 border border-gray-100">
        <p class="text-sm text-gray-700 mb-2">
            <span class="font-roboto_condensed text-gray-800 font-semibold">Fecha:</span> {{ $pedido->created_at->format('d/m/Y H:i') }}
        </p>
        <p class="text-sm text-gray-700 mb-2">
            <span class="font-roboto_condensed text-gray-800 font-semibold">Estado:</span> <span class="capitalize">{{ $pedido->estado }}</span>
        </p>
        <p class="text-sm text-gray-700">
            <span class="font-roboto_condensed text-gray-800 font-semibold">Total:</span> <span class="text-green-700 font-medium">${{ number_format($pedido->total, 0, ',', '.') }}</span>
        </p>
    </div>

    <div class="bg-white shadow-md rounded-xl p-6 max-w-3xl mx-auto border border-gray-100">
        <h2 class="text-xl font-roboto_condensed font-bold mb-4 text-green-800">🛍 Productos Comprados</h2>

        @if ($pedido->productos->isEmpty())
            <div class="text-gray-600">No se encontraron productos en este pedido.</div>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach ($pedido->productos as $producto)
                    <li class="py-4 flex justify-between items-center">
                        <div>
                            <p class="text-gray-800 font-medium">{{ $producto->nombre }}</p>
                            <p class="text-sm text-gray-500">Cantidad: {{ $producto->pivot->cantidad }}</p>
                        </div>
                        <p class="text-sm text-green-700 font-semibold">${{ number_format($producto->pivot->precio_unitario, 0, ',', '.') }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="text-center mt-8">
        <a href="{{ route('compras.index') }}" class="inline-block text-green-700 hover:text-green-900 hover:underline font-roboto_condensed">
            ← Volver a mis compras
        </a>
    </div>
</div>
@endsection
