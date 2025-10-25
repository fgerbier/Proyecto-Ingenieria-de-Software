@extends('layouts.dashboard')

@section('title', 'Editar categoría')

@section('content')

    <div class="py-8 px-4 md:px-8 max-w-3xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('categorias.index') }}"
                class="flex items-center text-green-700 hover:text-green-800 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                Volver a la lista
            </a>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 ml-auto">
                {{ isset($categoria->id) ? 'Editar' : 'Nueva' }} categoría
            </h1>
        </div>

        <form action="{{ isset($categoria->id) ? route('categorias.update', $categoria->id) : route('categorias.store') }}"
            method="POST"
            class="space-y-6">
            @csrf
            @if(isset($categoria->id))
                @method('PUT')
            @endif

            {{-- Información Básica --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">
                    Información de la Categoría
                </h2>

                <div class="grid grid-cols-1 gap-6">
                    {{-- Nombre --}}
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $categoria->nombre ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                            required>
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">
                            Slug <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $categoria->slug ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all font-mono"
                            required>
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">
                            Descripción
                        </label>
                        <textarea id="descripcion" name="descripcion" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>
                        @error('descripcion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="flex items-center">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" id="activo" name="activo" value="1"
                            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded transition-colors"
                            {{ old('activo', $categoria->activo ?? '1') ? 'checked' : '' }}>
                        <label for="activo" class="ml-2 block text-sm text-gray-700">
                            Categoría Activa
                        </label>
                        @error('activo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('dashboard') }}"
                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                    class="group relative px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-2 -ml-1" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    {{ isset($categoria->id) ? 'Actualizar' : 'Guardar' }} categoría
                </button>
            </div>
        </form>
    </div>
@endsection
