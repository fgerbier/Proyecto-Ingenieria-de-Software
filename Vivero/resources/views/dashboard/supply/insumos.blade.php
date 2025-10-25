@extends('layouts.dashboard')

@section('title','Listado de insumos')

@section('content')
@php
    $pref = Auth::user()?->preference;
@endphp

<style>
    :root {
        --table-header-color: {{ $pref?->table_header_color ?? '#0a2b59' }};
        --table-header-text-color: {{ $pref?->table_header_text_color ?? '#FFFFFF' }};
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

<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800" x-data="{ abierto: null }">
    {{-- Filtros y botón --}}
    <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <form method="GET" action="{{ route('dashboard.insumos') }}" class="flex flex-wrap gap-2 items-end md:items-center w-full md:max-w-md">
            <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="Buscar por nombre..."
                   class="px-4 py-2 border rounded shadow text-sm w-full md:w-auto" />

            <button type="submit"
                    class="text-white px-4 py-2 rounded hover:bg-green-700 text-sm w-full md:w-auto"
                    style="background-color: var(--table-header-color);">
                Buscar
            </button>

            @if(request('nombre'))
                <a href="{{ route('dashboard.insumos') }}"
                   class="text-sm text-gray-600 hover:text-gray-800 underline w-full md:w-auto">
                    Limpiar
                </a>
            @endif
        </form>

        <a href="{{ route('insumos.create') }}"
           class="ml-auto flex items-center text-white px-4 py-2 rounded transition-colors shadow text-sm font-medium"
           style="background-color: var(--table-header-color);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Agregar Insumo
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow sm:rounded-lg w-full custom-border">
        <table class="min-w-full divide-y text-sm text-left">
            <thead style="background-color: var(--table-header-color); color: var(--table-header-text-color);" class="uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-6 py-3 whitespace-nowrap">Nombre</th>
                    <th class="px-6 py-3 whitespace-nowrap">Cantidad</th>
                    <th class="px-6 py-3 whitespace-nowrap">Costo Total</th>
                    <th class="px-6 py-3 whitespace-nowrap">Descripción</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white font-['Roboto'] text-gray-800">
                @php $totalGeneral = 0; @endphp

                @forelse($insumos as $insumo)
                    @php
                        $costoTotal = $insumo->cantidad * $insumo->costo;
                        $totalGeneral += $costoTotal;
                    @endphp

                    <tr class="hover:bg-gray-100 cursor-pointer" @click="abierto === {{ $insumo->id }} ? abierto = null : abierto = {{ $insumo->id }}">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $insumo->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $insumo->cantidad }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            ${{ number_format($costoTotal, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $insumo->descripcion }}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                            <a href="{{ route('insumos.edit', $insumo->id) }}" class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1 rounded transition-colors">Editar</a>
                            <form action="{{ route('insumos.destroy', $insumo->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800 px-3 py-1 rounded transition-colors">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <tr x-show="abierto === {{ $insumo->id }}" x-collapse>
                        <td colspan="5" class="bg-gray-50 px-6 py-4">
                            {{-- Subdetalles --}}
                            @if($insumo->detalles->count())
                                <p class="font-semibold mb-2 text-sm text-gray-700">Subdetalles del insumo:</p>
                                <table class="w-full text-sm text-left mb-4">
                                    <thead>
                                        <tr class="text-gray-600 border-b border-gray-300">
                                            <th class="py-2">Nombre</th>
                                            <th class="py-2">Cantidad</th>
                                            <th class="py-2">Costo unitario</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($insumo->detalles as $detalle)
                                            <tr class="border-t">
                                                <td class="py-1">{{ $detalle->nombre }}</td>
                                                <td class="py-1">{{ $detalle->cantidad }}</td>
                                                <td class="py-1">${{ number_format($detalle->costo_unitario, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-gray-500 italic text-sm">Este insumo no tiene subdetalles.</p>
                            @endif

                            {{-- Productos asociados --}}
                            @if($insumo->productos->count())
                                <p class="font-semibold mt-4 mb-2 text-sm text-gray-700">Productos asociados:</p>
                                <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                                    @foreach($insumo->productos as $producto)
                                        <li>{{ $producto->nombre }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-500 italic text-sm mt-2">Este insumo no está asociado a ningún producto.</p>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500 italic">
                            No hay insumos registrados.
                        </td>
                    </tr>
                @endforelse

                @if($insumos->count())
                    <tr class="bg-gray-100 font-semibold text-gray-800">
                        <td colspan="2" class="px-6 py-3 text-right">Total general:</td>
                        <td class="px-6 py-3">${{ number_format($totalGeneral, 0, ',', '.') }}</td>
                        <td colspan="2"></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    @if ($insumos->count())
        <div class="mt-6 flex flex-col items-center text-center gap-2">
            <div class="text-sm text-gray-600">
                Mostrando {{ $insumos->firstItem() ?? 0 }} a {{ $insumos->lastItem() ?? 0 }} de {{ $insumos->total() }} resultados
            </div>

            @if ($insumos->hasPages())
                <div class="flex items-center space-x-1 text-sm text-gray-700">
                    {{-- Anterior --}}
                    @if ($insumos->onFirstPage())
                        <span class="px-3 py-2 rounded bg-gray-200 text-gray-500 cursor-not-allowed">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 19l-7-7 7-7"/>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $insumos->previousPageUrl() }}"
                           class="px-3 py-2 rounded bg-eaccent2 hover:bg-green-700 text-white">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Páginas --}}
                    @foreach ($insumos->getUrlRange(1, $insumos->lastPage()) as $page => $url)
                        @if ($page == $insumos->currentPage())
                            <span class="px-3 py-2 rounded bg-green-600 text-white font-semibold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 rounded hover:bg-green-100 text-green-700">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Siguiente --}}
                    @if ($insumos->hasMorePages())
                        <a href="{{ $insumos->nextPageUrl() }}"
                           class="px-3 py-2 rounded bg-eaccent2 hover:bg-green-700 text-white">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @else
                        <span class="px-3 py-2 rounded bg-gray-200 text-gray-500 cursor-not-allowed">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
