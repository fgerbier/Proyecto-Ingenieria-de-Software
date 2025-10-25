@extends('layouts.dashboard')

@section('title', 'Cuidados de Plantas')

@section('content')
@php
    $pref = Auth::user()?->preference;
@endphp

<style>
    :root {
        --table-header-color: {{ $pref?->table_header_color ?? '#0a2b59' }};
        --table-header-text-color: {{ $pref?->table_header_text_color ?? '#FFFFFF' }};
    }

    .custom-table-header {
        background-color: var(--table-header-color);
        color: var(--table-header-text-color) !important;
    }

    .custom-border {
        border: 2px solid var(--table-header-color);
        border-radius: 8px;
        overflow: hidden;
    }

    .custom-border thead th {
        border-bottom: 2px solid var(--table-header-color);
    }

    .custom-border tbody td {
        border-top: 1px solid #e5e7eb;
        border-left: none !important;
        border-right: none !important;
    }

    .custom-border tbody tr:last-child td {
        border-bottom: none;
    }
</style>

<div class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800 max-w-7xl mx-auto">
    {{-- Filtro y botón --}}
    <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <form method="GET" action="{{ route('dashboard.cuidados') }}" class="flex flex-wrap gap-2 items-end md:items-center w-full md:max-w-md">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por producto..."
                   class="px-4 py-2 border rounded shadow text-sm w-full md:w-auto" />

            <button type="submit"
                    class="text-white px-4 py-2 rounded hover:bg-green-700 text-sm w-full md:w-auto"
                    style="background-color: var(--table-header-color);">
                Buscar
            </button>

            @if(request('search'))
                <a href="{{ route('dashboard.cuidados.index') }}"
                   class="text-sm text-gray-600 hover:text-gray-800 underline w-full md:w-auto">
                    Limpiar
                </a>
            @endif
        </form>

        <a href="{{ route('dashboard.cuidados.create') }}"
           class="flex items-center text-white px-3 py-2 rounded transition-colors"
           style="background-color: var(--table-header-color);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Cuidado
        </a>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto bg-white shadow custom-border">
        <table class="min-w-full text-sm text-left bg-white">
            <thead class="custom-table-header uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-6 py-3 whitespace-nowrap">Producto</th>
                    <th class="px-6 py-3 whitespace-nowrap">Riego</th>
                    <th class="px-6 py-3 whitespace-nowrap">Agua</th>
                    <th class="px-6 py-3 whitespace-nowrap">Luz</th>
                    <th class="px-6 py-3 whitespace-nowrap">Abono</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                    <th class="px-6 py-3 whitespace-nowrap">Archivos</th>
                </tr>
            </thead>

            <tbody class="font-['Roboto'] text-gray-800">
                @forelse($cuidados as $cuidado)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cuidado->producto->nombre ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cuidado->frecuencia_riego }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cuidado->cantidad_agua }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cuidado->tipo_luz }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cuidado->frecuencia_abono ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ route('dashboard.cuidados.edit', $cuidado->id) }}"
                                   class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1.5 rounded text-sm transition-colors">
                                    Editar
                                </a>

                                <form action="{{ route('dashboard.cuidados.destroy', $cuidado->id) }}" method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este cuidado?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800 px-3 py-1.5 rounded text-sm transition-colors">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('dashboard.cuidados.pdf', $cuidado->id) }}" target="_blank"
                               class="text-indigo-600 hover:text-indigo-900">
                                Ver PDF
                            </a>
                            <a href="{{ route('dashboard.cuidados.qr', $cuidado->id) }}"
                               class="text-green-600 hover:text-green-900 ml-2">
                                Ver QR
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 px-6 py-6">No hay cuidados registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    @if ($cuidados->count())
        <div class="mt-6 flex flex-col items-center text-center gap-2">
            <div class="text-sm text-gray-600">
                Mostrando {{ $cuidados->firstItem() ?? 0 }} a {{ $cuidados->lastItem() ?? 0 }} de {{ $cuidados->total() }} resultados
            </div>
            @if ($cuidados->hasPages())
                <div class="flex items-center space-x-1 text-sm text-gray-700">
                    {{-- Anterior --}}
                    @if ($cuidados->onFirstPage())
                        <span class="px-3 py-2 rounded bg-gray-200 text-gray-500 cursor-not-allowed">«</span>
                    @else
                        <a href="{{ $cuidados->previousPageUrl() }}" class="px-3 py-2 rounded bg-eaccent2 hover:bg-green-700 text-white">«</a>
                    @endif

                    {{-- Páginas --}}
                    @foreach ($cuidados->getUrlRange(1, $cuidados->lastPage()) as $page => $url)
                        @if ($page == $cuidados->currentPage())
                            <span class="px-3 py-2 rounded bg-green-600 text-white font-semibold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 rounded hover:bg-green-100 text-green-700">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Siguiente --}}
                    @if ($cuidados->hasMorePages())
                        <a href="{{ $cuidados->nextPageUrl() }}" class="px-3 py-2 rounded bg-eaccent2 hover:bg-green-700 text-white">»</a>
                    @else
                        <span class="px-3 py-2 rounded bg-gray-200 text-gray-500 cursor-not-allowed">»</span>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
