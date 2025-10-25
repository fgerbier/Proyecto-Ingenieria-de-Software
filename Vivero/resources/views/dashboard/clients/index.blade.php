@extends('layouts.dashboard')

@section('title', 'Gestión de Clientes')

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

<div class="py-8 px-4 md:px-8 font-['Roboto']">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Clientes Registrados</h1>
        <a href="{{ route('clients.create') }}" class="bg-[var(--table-header-color)] text-white px-4 py-2 rounded hover:opacity-90 transition">
            <i class="fa fa-plus mr-1"></i> Crear Cliente
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left bg-white custom-border">
            <thead class="custom-table-header text-sm uppercase">
                <tr>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Subdominio</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clientes as $cliente)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium">{{ $cliente->nombre }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $cliente->subdominio }}</td>
                        <td class="px-4 py-3">
                            @if ($cliente->activo)
                                <span class="text-green-600 font-semibold">Activo</span>
                            @else
                                <span class="text-red-600 font-semibold">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <form action="{{ route('clients.toggle', $cliente) }}" method="POST" onsubmit="return confirm('¿Estás seguro de cambiar el estado de este cliente?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="px-3 py-1 border text-sm font-medium rounded border-[var(--table-header-color)] hover:bg-[var(--table-header-color)] hover:text-white transition">
                                    {{ $cliente->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-center text-gray-500">No hay clientes registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
