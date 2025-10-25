@extends('layouts.home')

@section('title', 'Mis Compras')

@section('content')
<div class="py-10 px-4 md:px-8 w-full font-roboto_sans text-gray-800">
    <h1 class="text-3xl font-roboto_condensed font-bold mb-8 text-center text-green-800">🛒 Mis Compras</h1>

    @if ($pedidos->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded shadow-md text-center max-w-xl mx-auto">
            Aún no has realizado ninguna compra.
        </div>
    @else
        <div class="overflow-x-auto bg-white shadow-md sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-greenPrimary text-white font-roboto_condensed text-sm uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold">Fecha</th>
                        <th class="px-6 py-3 text-left font-semibold">Total</th>
                        <th class="px-6 py-3 text-left font-semibold">Estado</th>
                        <th class="px-6 py-3 text-left font-semibold">Productos</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-sm text-gray-700">
                    @foreach ($pedidos as $pedido)
                        <tr class="hover:bg-gray-50 transition border-b border-gray-200">
                            <td class="px-6 py-4">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 font-medium text-green-700">${{ number_format($pedido->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 capitalize">{{ $pedido->estado_pedido }}</td>
                            <td class="px-6 py-4">
                                <div class="rounded border border-green-200 p-4 shadow-inner bg-gray-50">
                                    <ul class="space-y-1 pl-4 list-disc">
                                        @foreach ($pedido->productos as $producto)
                                            <li class="flex justify-between">
                                                <span class="text-gray-800">{{ $producto->nombre }} (x{{ $producto->pivot->cantidad }})</span>
                                                <span class="text-green-700 font-medium">${{ number_format($producto->pivot->precio_unitario, 0, ',', '.') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
