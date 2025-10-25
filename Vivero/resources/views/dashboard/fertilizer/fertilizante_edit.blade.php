@extends('layouts.dashboard')

@section('title', isset($fertilizante->id) ? 'Editar fertilizante' : 'Nuevo fertilizante')

@section('content')
@php
    $pref = Auth::user()?->preference;
@endphp

<style>
    :root {
        --table-header-color: {{ $pref?->table_header_color ?? '#0a2b59' }};
    }
</style>

<div class="py-8 px-4 md:px-8 max-w-5xl mx-auto font-['Roboto'] text-gray-800">

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

    <form action="{{ isset($fertilizante->id) ? route('fertilizantes.update', $fertilizante->id) : route('fertilizantes.store') }}"
          method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
        @csrf
        @if(isset($fertilizante->id))
            @method('PUT')
        @endif

        <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">Datos del fertilizante</h2>

        {{-- Campos --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nombre --}}
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $fertilizante->nombre ?? '') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" required>
            </div>
            {{-- Tipo --}}
            <div>
                <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo <span class="text-red-500">*</span></label>
                <input type="text" name="tipo" id="tipo" value="{{ old('tipo', $fertilizante->tipo ?? '') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" required>
            </div>
            {{-- Peso --}}
            <div>
                <label for="peso" class="block text-sm font-medium text-gray-700 mb-1">Peso (kg) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="peso" id="peso" value="{{ old('peso', $fertilizante->peso ?? '') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" required>
            </div>
            {{-- Unidad de medida --}}
            <div>
                <label for="unidad_medida" class="block text-sm font-medium text-gray-700 mb-1">Unidad de Medida</label>
                <input type="text" name="unidad_medida" id="unidad_medida" value="{{ old('unidad_medida', $fertilizante->unidad_medida ?? '') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
            </div>
            {{-- Presentación --}}
            <div>
                <label for="presentacion" class="block text-sm font-medium text-gray-700 mb-1">Presentación</label>
                <input type="text" name="presentacion" id="presentacion" value="{{ old('presentacion', $fertilizante->presentacion ?? '') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
            </div>
            {{-- Precio --}}
            <div>
                <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">Precio <span class="text-red-500">*</span></label>
                <input type="number" name="precio" id="precio" value="{{ old('precio', $fertilizante->precio ?? '') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" required>
            </div>
            {{-- Stock --}}
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock <span class="text-red-500">*</span></label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', $fertilizante->stock ?? '') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" required>
            </div>
            {{-- Fecha vencimiento --}}
            <div>
                <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Vencimiento</label>
                <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" value="{{ old('fecha_vencimiento', $fertilizante->fecha_vencimiento ?? '') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        {{-- Composición --}}
        <div class="mt-4">
            <label for="composicion" class="block text-sm font-medium text-gray-700 mb-1">Composición</label>
            <textarea name="composicion" id="composicion" rows="2"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('composicion', $fertilizante->composicion ?? '') }}</textarea>
        </div>

        {{-- Descripción --}}
        <div class="mt-4">
            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('descripcion', $fertilizante->descripcion ?? '') }}</textarea>
        </div>

        {{-- Aplicación --}}
        <div class="mt-4">
            <label for="aplicacion" class="block text-sm font-medium text-gray-700 mb-1">Aplicación</label>
            <textarea name="aplicacion" id="aplicacion" rows="3"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('aplicacion', $fertilizante->aplicacion ?? '') }}</textarea>
        </div>

        {{-- Checkbox --}}
        <div class="mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="activo" value="1"
                       class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                       {{ old('activo', $fertilizante->activo ?? true) ? 'checked' : '' }}>
                <span class="ml-2 text-sm text-gray-700">Fertilizante activo</span>
            </label>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end space-x-4 pt-4">


            <button type="submit"
                class="px-4 py-2 rounded-md shadow-sm text-sm font-medium text-white flex items-center"
                style="background-color: var(--table-header-color);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    @if(isset($fertilizante->id))
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z" />
                    @else
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                        <polyline points="17 21 17 13 7 13 7 21" />
                        <polyline points="7 3 7 8 15 8" />
                    @endif
                </svg>
                {{ isset($fertilizante->id) ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>
    </form>
</div>
@endsection
