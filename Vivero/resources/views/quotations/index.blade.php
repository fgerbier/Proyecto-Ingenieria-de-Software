@extends('layouts.home')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-blueDark mb-6">Mis Cotizaciones</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($cotizaciones && $cotizaciones->count() > 0)
        @foreach($cotizaciones as $cotizacion)
            <div class="bg-white rounded shadow p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">Cotización #{{ $cotizacion->id }}</h2>

                @if($cotizacion->productos->count() > 0)
                    <table class="w-full table-auto text-left">
                        <thead>
                            <tr class="bg-blueLight text-blueDark">
                                <th class="p-2">Producto</th>
                                <th class="p-2">Precio</th>
                                <th class="p-2">Cantidad</th>
                                <th class="p-2">Subtotal</th>
                                <th class="p-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cotizacion->productos as $producto)
                                <tr class="border-b">
                                    <td class="p-2">{{ $producto->nombre }}</td>
                                    <td class="p-2">{{ number_format($producto->precio, 0, ',', '.') }} CLP</td>
                                    <td class="p-2">{{ $producto->pivot->cantidad }}</td>
                                    <td class="p-2">{{ number_format($producto->precio * $producto->pivot->cantidad, 0, ',', '.') }} CLP</td>
                                    <td class="p-2">
                                        <form action="{{ route('cotizacion.eliminar', [$cotizacion->id, $producto->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-600">No hay productos en esta cotización.</p>
                @endif

                @if($cotizacion->estado === 'borrador')
                    <form action="{{ route('cotizacion.enviar', $cotizacion->id) }}" method="POST" class="mt-4">
                        @csrf
                        <button class="bg-greenPrimary text-white px-6 py-2 rounded hover:bg-greenDark">
                            Enviar Cotización
                        </button>
                    </form>
                @else
                    <p class="mt-4 text-sm text-blueDark">Estado: {{ ucfirst($cotizacion->estado) }}</p>
                @endif
            </div>
        @endforeach
    @else
        <div class="text-center text-blueDark">No has agregado cotizaciones.</div>
    @endif
</div>
@endsection
