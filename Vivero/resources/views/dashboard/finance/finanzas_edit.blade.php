@extends('layouts.dashboard')

@section('title', isset($finanza->id) ? 'Editar Movimiento Financiero' : 'Nuevo Movimiento Financiero')

@section('content')
@php
    $pref = Auth::user()?->preference;
@endphp

<style>
    :root {
        --table-header-color: {{ $pref?->table_header_color ?? '#0a2b59' }};
        --table-header-text-color: {{ $pref?->table_header_text_color ?? '#ffffff' }};
    }
</style>

<div class="py-8 px-4 md:px-8 max-w-3xl mx-auto">

    {{-- Botón volver --}}
    <div class="flex items-center mb-6">
        <a href="{{ route('dashboard.finanzas') }}"
            class="inline-flex items-center px-4 py-2 bg-[var(--table-header-color)] text-white rounded-md shadow hover:opacity-90 transition-all text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M15 18l-6-6 6-6" />
            </svg>
            Volver al listado
        </a>
    </div>

    <form action="{{ isset($finanza->id) ? route('finanzas.update', $finanza->id) : route('finanzas.store') }}"
          method="POST" class="space-y-6">
        @csrf
        @if(isset($finanza->id))
            @method('PUT')
        @endif

        {{-- Formulario --}}
        <div class="bg-white rounded-lg shadow-md p-6 space-y-6">
            <h2 class="text-xl font-medium text-gray-800 mb-2 pb-2 border-b border-gray-200">Datos del movimiento</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                    <select name="tipo" id="tipo" class="form-select w-full" required>
                        <option value="ingreso" {{ old('tipo', $finanza->tipo ?? '') == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
                        <option value="egreso" {{ old('tipo', $finanza->tipo ?? '') == 'egreso' ? 'selected' : '' }}>Egreso</option>
                    </select>
                </div>

                <div>
                    <label for="monto" class="block text-sm font-medium text-gray-700">Monto</label>
                    <input type="number" step="0.01" name="monto" id="monto" class="form-input w-full"
                        value="{{ old('monto', $finanza->monto ?? '') }}" required>
                </div>

                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-input w-full"
                        value="{{ old('fecha', isset($finanza->fecha) ? $finanza->fecha : now()->toDateString()) }}" required>
                </div>

                @php
                    $categoriasPredeterminadas = config('finanzas.categorias');
                    $categoriaActual = old('categoria', $finanza->categoria ?? '');
                @endphp

                <div x-data="{ categoria: '{{ $categoriaActual }}' }">
                    <label for="categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
                    <select x-model="categoria" class="form-select w-full">
                        <option value="">Selecciona una categoría</option>
                        @foreach ($categoriasPredeterminadas as $cat)
                            <option value="{{ $cat }}" {{ $categoriaActual === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                        <option value="otro" :selected="!{{ Js::from($categoriasPredeterminadas) }}.includes(categoria)">Otra...</option>
                    </select>

                    <template x-if="categoria === 'otro'">
                        <input type="text" name="categoria" class="form-input mt-2 w-full"
                            placeholder="Especifica la categoría" value="{{ $categoriaActual }}">
                    </template>

                    <template x-if="categoria !== 'otro'">
                        <input type="hidden" name="categoria" :value="categoria">
                    </template>
                </div>
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4" class="form-textarea w-full">{{ old('descripcion', $finanza->descripcion ?? '') }}</textarea>
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard.finanzas') }}"
                class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-[var(--table-header-color)] text-white rounded-md shadow hover:opacity-90 transition-all text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
                {{ isset($finanza->id) ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>
    </form>
</div>
@endsection
