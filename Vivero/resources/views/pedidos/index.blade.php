@extends('layouts.dashboard')

@section('title', 'Gestión de Pedidos')

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

<div class="max-w-7xl mx-auto px-8 py-10 font-['Roboto'] text-gray-800">
    @if (session('success'))
        <div id="success-message" class="bg-[#FFF9DB] border-l-4 border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Botón Añadir Venta --}}
    <div class="flex items-center justify-end mb-6">
        <a href="{{ route('pedidos.create') }}"
           class="flex items-center text-white px-3 py-2 rounded transition-colors"
           style="background-color: var(--table-header-color);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Añadir Venta
        </a>
    </div>

    @if ($pedidos->count())
        <div class="overflow-x-auto bg-white shadow custom-border">
            <table class="min-w-full text-sm text-left bg-white">
                <thead class="custom-table-header uppercase tracking-wider font-['Roboto_Condensed']">
                    <tr>
                        <th class="px-6 py-4 text-center">ID</th>
                        <th class="px-6 py-4 text-center">Usuario</th>
                        <th class="px-6 py-4 text-center">Total</th>
                        <th class="px-6 py-4 text-center">Estado Entrega</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="font-['Roboto'] text-gray-800">
                    @foreach ($pedidos as $pedido)
                        <tr class="hover:bg-green-50 transition-colors cursor-pointer" onclick="toggleDetalles({{ $pedido->id }}, event)">
                            <td class="px-6 py-4 text-center font-bold text-eprimary">{{ $pedido->id }}</td>
                            <td class="px-6 py-4 text-center">{{ $pedido->usuario->name }}</td>
                            <td class="px-6 py-4 text-center">${{ number_format($pedido->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                @include('pedidos.partials.estado_form', ['pedido' => $pedido])
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap justify-center gap-2">
                                    <a href="{{ route('pedidos.edit', $pedido->id) }}"
                                       class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1.5 rounded text-sm transition-colors inline-flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9" />
                                            <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                        </svg>
                                        Editar
                                    </a>

                                    <button type="button"
                                            class="text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800 px-3 py-1.5 rounded text-sm transition-colors"
                                            onclick="openDeleteModal({{ $pedido->id }}, 'Pedido #{{ $pedido->id }}')">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- Detalles del pedido --}}
                        <tr>
                            <td colspan="5" class="p-0 font-['Roboto']">
                                <div id="detalles-{{ $pedido->id }}" class="max-h-0 overflow-hidden opacity-0 transition-all duration-300 bg-efore text-sm border-t border-esecondary">
                                    <div class="p-6 space-y-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <p><strong class="text-eprimary">Método de entrega:</strong> {{ $pedido->metodo_entrega }}</p>
                                            <p><strong class="text-eprimary">Dirección:</strong> {{ $pedido->direccion_entrega ?? 'No disponible' }}</p>
                                            <p><strong class="text-eprimary">Fecha de pedido:</strong> {{ $pedido->created_at->format('d-m-Y H:i') }}</p>
                                            <p><strong class="text-eprimary">Estado de pago:</strong> {{ $pedido->estado_pago }}</p>
                                            <p><strong class="text-eprimary">Observaciones:</strong> {{ $pedido->observaciones ?? 'Sin observaciones' }}</p>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-4">
                                            <div class="flex items-center gap-2">
                                                <strong class="text-eprimary">Boleta SII:</strong>
                                                @if($pedido->boleta_final_path)
                                                    <span class="text-green-600 font-medium">Subida</span>
                                                    <a href="{{ asset('storage/' . $pedido->boleta_final_path) }}"
                                                       target="_blank"
                                                       class="text-esecondary hover:text-eaccent text-sm underline cursor-pointer">
                                                        Ver PDF
                                                    </a>
                                                @else
                                                    <span class="text-red-500 font-medium">No subida</span>
                                                @endif

                                                <button class="open-modal-upload text-eaccent hover:text-eaccent2 text-lg"
                                                        data-action="{{ route('boletas.subir', ['pedido' => $pedido->id]) }}">
                                                    📤
                                                </button>
                                            </div>
                                        </div>

                                        <div class="pt-2">
                                            <button class="open-modal-provisoria inline-block bg-yellow-100 hover:bg-yellow-200 text-eprimary font-semibold text-sm px-4 py-2 rounded shadow transition"
                                                    data-url="{{ route('boletas.provisoria', $pedido->id) }}">
                                                Ver Detalle 
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center text-lg text-gray-600 mt-10">No hay pedidos registrados.</p>
    @endif
</div>

{{-- Modales --}}
@include('pedidos.partials.modals')
@include('pedidos.partials.scripts')

<script>
    function toggleDetalles(id, event) {
        if(event.target.closest('a, button, select, input, form')) return;

        const detalles = document.getElementById(`detalles-${id}`);
        if (!detalles) return;

        const isOpen = detalles.style.maxHeight && detalles.style.maxHeight !== '0px';

        document.querySelectorAll('[id^="detalles-"]').forEach(el => {
            el.style.maxHeight = '0px';
            el.style.opacity = '0';
        });

        if (!isOpen) {
            detalles.style.maxHeight = detalles.scrollHeight + 'px';
            detalles.style.opacity = '1';
        }
    }

    function openDeleteModal(id, nombre) {
        document.getElementById('modalProductName').textContent = nombre;
        document.getElementById('deleteForm').action = `/pedidos/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }

    document.getElementById('delete-modal-close').addEventListener('click', closeDeleteModal);
</script>
@endsection
