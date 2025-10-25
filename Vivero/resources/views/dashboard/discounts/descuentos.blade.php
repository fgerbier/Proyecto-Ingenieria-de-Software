@extends('layouts.dashboard')

@section('title','Listado de Descuentos')

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

<div class="py-8 px-4 md:px-8 max-w-7xl mx-auto font-['Roboto'] text-gray-800">
    {{-- Botón Agregar --}}
    <div class="flex items-center mb-6">
        <a href="{{ route('descuentos.create') }}"
           class="ml-auto flex items-center text-white border px-3 py-1 rounded transition-colors"
           style="background-color: var(--table-header-color); border-color: var(--table-header-color);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Agregar Descuento
        </a>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto bg-white shadow custom-border">
        <table class="min-w-full divide-y divide-eaccent2 text-sm text-left bg-white">
            <thead class="custom-table-header uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-6 py-3 whitespace-nowrap">Nombre</th>
                    <th class="px-6 py-3 whitespace-nowrap">Porcentaje</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="font-['Roboto'] text-gray-800">
                @foreach($descuentos as $descuento)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $descuento->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $descuento->porcentaje }}%</td>
                        <td class="px-6 py-4 whitespace-nowrap flex flex-wrap gap-2">
                            <a href="{{ route('descuentos_edit', ['id' => $descuento->id]) }}"
                               class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1 rounded transition-colors">
                                Editar
                            </a>
                            <form action="{{ route('descuentos.destroy', $descuento->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800 px-3 py-1 rounded transition-colors"
                                        onclick="return confirm('¿Estás seguro de eliminar este descuento?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
