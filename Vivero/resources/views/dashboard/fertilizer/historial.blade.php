@extends('layouts.dashboard')

@section('title','Historial de Aplicaciones')

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
    {{-- Botón Volver --}}
    <div class="flex items-center mb-6">
        <a href="{{ route('dashboard.fertilizantes') }}"
           class="flex items-center text-white px-3 py-1 rounded transition-colors"
           style="background-color: var(--table-header-color);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver a la lista
        </a>
    </div>

    {{-- Tabla de aplicaciones --}}
    @if($fertilizaciones->count())
        <div class="overflow-x-auto bg-white shadow custom-border">
            <table class="min-w-full text-sm text-left bg-white">
                <thead class="custom-table-header uppercase tracking-wider font-['Roboto_Condensed']">
                    <tr>
                        <th class="px-6 py-3">Fertilizante</th>
                        <th class="px-6 py-3">Producto</th>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Dosis</th>
                        <th class="px-6 py-3">Notas</th>
                    </tr>
                </thead>
                <tbody class="font-['Roboto'] text-gray-800">
                    @foreach($fertilizaciones as $f)
                        <tr class="hover:bg-green-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $f->fertilizante->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $f->producto->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($f->fecha_aplicacion)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $f->dosis_aplicada ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-pre-line">{{ $f->notas ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500 italic mt-4">No hay aplicaciones registradas todavía.</p>
    @endif
</div>
@endsection
