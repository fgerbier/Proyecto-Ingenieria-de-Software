@extends('layouts.dashboard')

@section('title', 'Clientes')

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

<div class="py-8 px-4 md:px-8 max-w-7xl mx-auto font-['Roboto'] text-gray-800" x-data="{ modalCliente: null }">
    {{-- Botón Agregar --}}
    <div class="flex items-center mb-6">
        <a href="{{ route('clients.create') }}"
           class="ml-auto flex items-center text-[var(--table-header-text-color)] border px-3 py-1 rounded transition-colors"
           style="background-color: var(--table-header-color); border-color: var(--table-header-color);">
            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"
                 style="color: var(--table-header-text-color);">
                <path d="M12 4v16m8-8H4" />
            </svg>
            Nuevo Cliente
        </a>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto bg-white shadow custom-border">
        <table class="min-w-full divide-y text-sm text-left bg-white">
            <thead class="custom-table-header uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-6 py-3 whitespace-nowrap">Nombre</th>
                    <th class="px-6 py-3 whitespace-nowrap">Subdominio</th>
                    <th class="px-6 py-3 whitespace-nowrap">Activo</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="font-['Roboto'] text-gray-800">
                @foreach ($clientes as $cliente)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="http://{{ $cliente->subdominio }}.localhost:8000"
                               target="_blank"
                               class="text-blue-700 underline hover:text-blue-900">
                                {{ $cliente->subdominio }}.localhost
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->activo ? 'Sí' : 'No' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex flex-wrap gap-2">
                            <button @click="modalCliente = {{ $cliente->id }}"
                                    class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1 rounded transition-colors">
                                Ver
                            </button>
                            <form action="{{ route('clients.toggle', $cliente->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="text-sm {{ $cliente->activo ? 'text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800' : 'text-green-600 hover:text-green-800 border border-green-600 hover:border-green-800' }} px-3 py-1 rounded transition-colors">
                                    {{ $cliente->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal --}}
                    <div x-show="modalCliente === {{ $cliente->id }}"
                         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                         style="display: none;">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                            <h2 class="text-xl font-semibold mb-4">Detalle del Cliente</h2>
                            <p><strong>Nombre:</strong> {{ $cliente->nombre }}</p>
                            <p><strong>Subdominio:</strong> {{ $cliente->subdominio }}</p>
                            <p><strong>Slug:</strong> {{ $cliente->slug }}</p>
                            <p><strong>Activo:</strong> {{ $cliente->activo ? 'Sí' : 'No' }}</p>

                            <div class="mt-4 text-right">
                                <button @click="modalCliente = null"
                                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
