@extends('layouts.dashboard')

@section('title', isset($cuidado->id) ? 'Editar cuidado' : 'Nuevo cuidado')

@section('content')
@php
    $pref = Auth::user()?->preference;
@endphp

<style>
    :root {
        --table-header-color: {{ $pref?->table_header_color ?? '#0a2b59' }};
    }
</style>

<div class="py-8 px-4 md:px-8 max-w-5xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('dashboard.cuidados') }}"
           class="flex items-center text-white px-4 py-2 rounded transition-colors shadow"
           style="background-color: var(--table-header-color);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>
            Volver a la lista
        </a>
    </div>

    <form action="{{ isset($cuidado->id) ? route('dashboard.cuidados.update', $cuidado->id) : route('dashboard.cuidados.store') }}"
          method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($cuidado->id))
            @method('PUT')
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">Datos del cuidado</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Producto --}}
                <div>
                    <label for="producto_id" class="block text-sm font-medium text-gray-700 mb-1">Producto <span class="text-red-500">*</span></label>
                    <select name="producto_id" id="producto_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                        <option value="">Seleccione...</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" {{ old('producto_id', $cuidado->producto_id ?? '') == $producto->id ? 'selected' : '' }}>
                                {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('producto_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Frecuencia de Riego --}}
                <div>
                    <label for="frecuencia_riego" class="block text-sm font-medium text-gray-700 mb-1">Frecuencia de Riego <span class="text-red-500">*</span></label>
                    <input type="text" name="frecuencia_riego" id="frecuencia_riego"
                           value="{{ old('frecuencia_riego', $cuidado->frecuencia_riego ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                </div>

                {{-- Cantidad de Agua --}}
                <div>
                    <label for="cantidad_agua" class="block text-sm font-medium text-gray-700 mb-1">Cantidad de Agua <span class="text-red-500">*</span></label>
                    <input type="text" name="cantidad_agua" id="cantidad_agua"
                           value="{{ old('cantidad_agua', $cuidado->cantidad_agua ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                </div>

                {{-- Tipo de Luz --}}
                <div>
                    <label for="tipo_luz" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Luz <span class="text-red-500">*</span></label>
                    <input type="text" name="tipo_luz" id="tipo_luz"
                           value="{{ old('tipo_luz', $cuidado->tipo_luz ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                </div>

                {{-- Temperatura Ideal --}}
                <div>
                    <label for="temperatura_ideal" class="block text-sm font-medium text-gray-700 mb-1">Temperatura Ideal</label>
                    <input type="text" name="temperatura_ideal" id="temperatura_ideal"
                           value="{{ old('temperatura_ideal', $cuidado->temperatura_ideal ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                {{-- Tipo de Sustrato --}}
                <div>
                    <label for="tipo_sustrato" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Sustrato</label>
                    <input type="text" name="tipo_sustrato" id="tipo_sustrato"
                           value="{{ old('tipo_sustrato', $cuidado->tipo_sustrato ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                {{-- Frecuencia de Abono --}}
                <div>
                    <label for="frecuencia_abono" class="block text-sm font-medium text-gray-700 mb-1">Frecuencia de Abono</label>
                    <input type="text" name="frecuencia_abono" id="frecuencia_abono"
                           value="{{ old('frecuencia_abono', $cuidado->frecuencia_abono ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                {{-- Plagas Comunes --}}
                <div>
                    <label for="plagas_comunes" class="block text-sm font-medium text-gray-700 mb-1">Plagas Comunes</label>
                    <input type="text" name="plagas_comunes" id="plagas_comunes"
                           value="{{ old('plagas_comunes', $cuidado->plagas_comunes ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
            </div>

            {{-- Cuidados Adicionales --}}
            <div class="mt-4">
                <label for="cuidados_adicionales" class="block text-sm font-medium text-gray-700 mb-1">Cuidados Adicionales</label>
                <textarea name="cuidados_adicionales" id="cuidados_adicionales" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('cuidados_adicionales', $cuidado->cuidados_adicionales ?? '') }}</textarea>
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard.cuidados') }}"
               class="flex items-center text-gray-700 px-4 py-2 rounded transition-colors border border-gray-300 bg-white hover:bg-gray-100 shadow-sm">
                Cancelar
            </a>

            <button type="submit"
                    class="flex items-center text-white px-4 py-2 rounded transition-colors shadow"
                    style="background-color: var(--table-header-color);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                {{ isset($cuidado->id) ? 'Actualizar' : 'Guardar' }} cuidado
            </button>
        </div>
    </form>
</div>
@endsection
