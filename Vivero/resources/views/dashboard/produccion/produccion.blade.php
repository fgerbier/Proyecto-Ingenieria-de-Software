@extends('layouts.dashboard')

@section('title', 'Resumen de Producción de Productos')

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
    {{-- Filtros y botones --}}
    <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <form method="GET" action="{{ route('produccion.index') }}" class="flex flex-wrap gap-2 items-end md:items-center w-full md:max-w-md">
            <input type="text" name="producto" value="{{ request('producto') }}" placeholder="Buscar por producto..."
                   class="px-4 py-2 border rounded shadow text-sm w-full md:w-auto" />

            <button type="submit"
                    class="text-white px-4 py-2 rounded hover:bg-green-700 text-sm w-full md:w-auto"
                    style="background-color: var(--table-header-color);">
                Buscar
            </button>

            @if(request('producto'))
                <a href="{{ route('produccion.index') }}"
                   class="text-sm text-gray-600 hover:text-gray-800 underline w-full md:w-auto">
                    Limpiar
                </a>
            @endif
        </form>

        <div class="flex gap-3">
            <a href="{{ route('produccion.create') }}"
               class="flex items-center text-white px-3 py-2 rounded transition-colors whitespace-nowrap"
               style="background-color: var(--table-header-color);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
                Agregar Producción
            </a>

            <button onclick="openMermasModal()"
                    class="flex items-center text-yellow-700 hover:text-yellow-800 border border-yellow-700 hover:border-yellow-800 px-3 py-1 rounded transition-colors whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6h13v6M9 5h13v4H9zM4 12h.01" />
                </svg>
                Ver Mermas
            </button>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto bg-white shadow custom-border">
        <table class="min-w-full text-sm text-left bg-white">
            <thead class="custom-table-header uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-6 py-3">Producto</th>
                    <th class="px-6 py-3">Cantidad Producida</th>
                    <th class="px-6 py-3">Insumos Utilizados</th>
                    <th class="px-6 py-3">Costo Total</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="font-['Roboto'] text-gray-800">
                @forelse ($producciones as $produccion)
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $produccion->producto->nombre }}</td>
                        <td class="px-6 py-4">{{ $produccion->cantidad_producida }}</td>
                        <td class="px-6 py-4">
                            <ul class="list-disc pl-4 text-gray-700">
                                @foreach ($produccion->insumos as $insumo)
                                    <li>
                                        {{ $insumo->nombre }}: {{ $insumo->pivot->cantidad_usada }} unidades
                                        (${{ number_format($insumo->pivot->cantidad_usada * $insumo->costo, 0, ',', '.') }})
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4 text-green-700 font-semibold">
                            ${{ number_format($produccion->insumos->sum(fn($insumo) => $insumo->pivot->cantidad_usada * $insumo->costo), 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap flex flex-wrap gap-2">
                            <a href="{{ route('produccion.edit', $produccion->id) }}"
                               class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1 rounded transition-colors">
                                Editar
                            </a>
                            <form action="{{ route('produccion.destroy', $produccion->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800 px-3 py-1 rounded transition-colors">
                                    Eliminar
                                </button>
                            </form>
                            <button type="button"
                                    onclick="openMermaModal({{ $produccion->id }}, '{{ $produccion->producto->nombre }}')"
                                    class="text-yellow-700 hover:text-yellow-800 border border-yellow-700 hover:border-yellow-800 px-3 py-1 rounded transition-colors">
                                Merma
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500 italic">
                            No hay registros de producción disponibles.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    @if ($producciones->count())
        <div class="mt-6 flex flex-col items-center text-center gap-2">
            <div class="text-sm text-gray-600">
                Mostrando {{ $producciones->firstItem() ?? 0 }} a {{ $producciones->lastItem() ?? 0 }} de {{ $producciones->total() }} resultados
            </div>
            @if ($producciones->hasPages())
                <div class="flex items-center space-x-1 text-sm text-gray-700">
                    {{-- Anterior --}}
                    @if ($producciones->onFirstPage())
                        <span class="px-3 py-2 rounded bg-gray-200 text-gray-500 cursor-not-allowed">«</span>
                    @else
                        <a href="{{ $producciones->previousPageUrl() }}" class="px-3 py-2 rounded bg-eaccent2 hover:bg-green-700 text-white">«</a>
                    @endif

                    {{-- Páginas --}}
                    @foreach ($producciones->getUrlRange(1, $producciones->lastPage()) as $page => $url)
                        @if ($page == $producciones->currentPage())
                            <span class="px-3 py-2 rounded bg-green-600 text-white font-semibold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 rounded hover:bg-green-100 text-green-700">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Siguiente --}}
                    @if ($producciones->hasMorePages())
                        <a href="{{ $producciones->nextPageUrl() }}" class="px-3 py-2 rounded bg-eaccent2 hover:bg-green-700 text-white">»</a>
                    @else
                        <span class="px-3 py-2 rounded bg-gray-200 text-gray-500 cursor-not-allowed">»</span>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>

{{-- Modal Merma --}}
<div id="mermaModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md font-['Roboto']">
        <h2 class="text-lg font-bold text-gray-800 mb-4 font-['Roboto_Condensed']">Registrar Merma</h2>
        <form id="mermaForm" method="POST" action="{{ route('produccion.mermas.store') }}">
            @csrf
            <input type="hidden" name="produccion_id" id="modalProduccionId">
            <div class="mb-4">
                <label for="cantidad" class="block font-semibold mb-1">Cantidad a descontar</label>
                <input type="number" name="cantidad" id="modalCantidad" min="1" step="1"
                       class="w-full border-gray-300 rounded shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="motivo" class="block font-semibold mb-1">Motivo</label>
                <textarea name="motivo" id="modalMotivo" rows="3"
                          class="w-full border-gray-300 rounded shadow-sm" required></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeMermaModal()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                    Guardar Merma
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Historial de Mermas --}}
<div id="mermasModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl font-['Roboto'] max-h-[80vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800 font-['Roboto_Condensed']">Historial de Mermas</h2>
            <button onclick="closeMermasModal()" class="text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>
        </div>

        @if($mermas->count())
            <table class="min-w-full text-sm text-left border border-gray-200">
                <thead class="custom-table-header uppercase tracking-wider font-['Roboto_Condensed']">
                    <tr>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Producto</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Motivo</th>
                    </tr>
                </thead>
                <tbody class="bg-white font-['Roboto'] divide-y divide-gray-100">
                    @foreach($mermas as $merma)
                        <tr>
                            <td class="px-4 py-2">{{ $merma->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-4 py-2">{{ $merma->producto->nombre ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $merma->cantidad }}</td>
                            <td class="px-4 py-2">{{ $merma->motivo }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-600">No hay registros de mermas disponibles.</p>
        @endif
    </div>
</div>

<script>
    function openMermaModal(id, nombre) {
        document.getElementById('modalProduccionId').value = id;
        document.getElementById('modalCantidad').value = '';
        document.getElementById('modalMotivo').value = '';
        document.getElementById('mermaModal').classList.remove('hidden');
        document.getElementById('mermaModal').classList.add('flex');
    }

    function closeMermaModal() {
        document.getElementById('mermaModal').classList.add('hidden');
        document.getElementById('mermaModal').classList.remove('flex');
    }

    function openMermasModal() {
        document.getElementById('mermasModal').classList.remove('hidden');
        document.getElementById('mermasModal').classList.add('flex');
    }

    function closeMermasModal() {
        document.getElementById('mermasModal').classList.add('hidden');
        document.getElementById('mermasModal').classList.remove('flex');
    }
</script>
@endsection
