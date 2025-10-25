@extends('layouts.dashboard')

@section('title', 'Cotizaciones Recibidas')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 md:px-8">
    <div class="bg-white rounded-lg shadow-md p-6 space-y-6">
        @forelse($cotizaciones as $cotizacion)
            <div class="border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="mb-2 text-sm text-gray-700">
                    <p><strong>Usuario:</strong> {{ $cotizacion->user->name }} ({{ $cotizacion->user->email }})</p>
                    <p><strong>Fecha:</strong> {{ $cotizacion->created_at->format('d-m-Y H:i') }}</p>
                </div>

                <div class="mt-3">
                    <h2 class="font-medium text-gray-800 mb-1">Productos solicitados:</h2>
                    <ul class="list-disc list-inside text-gray-700 text-sm space-y-1">
                        @foreach($cotizacion->productos as $producto)
                            <li>
                                {{ $producto->nombre ?? 'Producto eliminado' }} –
                                {{ $producto->pivot->cantidad }} unidad(es) –
                                ${{ number_format($producto->precio, 0, ',', '.') }} c/u
                            </li>
                        @endforeach
                    </ul>
                </div>

                <form action="{{ route('dashboard.cotizaciones.responder', $cotizacion->id) }}" method="POST" class="mt-4 space-y-2">
                    @csrf
                    <label for="respuesta-{{ $cotizacion->id }}" class="block text-sm font-medium text-gray-700">
                        Respuesta al cliente
                    </label>
                    <textarea id="respuesta-{{ $cotizacion->id }}" name="respuesta" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all resize-y"
                        placeholder="Mensaje para el cliente"></textarea>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path d="M22 2L11 13"></path>
                            <path d="M22 2L15 22L11 13L2 9L22 2Z"></path>
                        </svg>
                        Enviar Respuesta
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-600 text-sm">No hay cotizaciones.</p>
        @endforelse
    </div>
</div>
@endsection
