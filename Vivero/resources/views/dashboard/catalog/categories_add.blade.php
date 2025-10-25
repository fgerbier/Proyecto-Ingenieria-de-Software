@extends('layouts.dashboard')

@section('title', 'Agregar categoría')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-md mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('categorias.index') }}"
           class="flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver a categorías
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 ml-auto">
            Nueva categoría
        </h1>
    </div>

    <form action="{{ route('categorias.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">
                Información de la categoría
            </h2>

            <div class="space-y-4">
                {{-- Nombre de la categoría --}}
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                        Nombre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
                                  transition-all"
                           required
                           placeholder="Ej: Plantas de Interior">
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug --}}
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">
                        Slug <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
                                  transition-all font-mono"
                           required
                           placeholder="Ej: plantas-interior">
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
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                     focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
                                     transition-all"
                              placeholder="Breve descripción de la categoría">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Estado --}}
                <div class="flex items-center pt-2">
                    <input type="hidden" name="activo" value="0">
                    <input type="checkbox" id="activo" name="activo" value="1"
                           class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                           checked>
                    <label for="activo" class="ml-2 block text-sm text-gray-700">
                        Categoría activa
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
               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium
                      text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2
                      focus:ring-offset-2 focus:ring-green-500 transition-colors">
                Cancelar
            </a>
            <button type="submit"
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium
                           text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2
                           focus:ring-offset-2 focus:ring-green-500 transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Guardar categoría
            </button>
        </div>
    </form>
</div>

<script>
// Puedes agregar aquí un script para auto-generar el slug desde el nombre si lo deseas
document.getElementById('nombre').addEventListener('input', function(e) {
    const slugInput = document.getElementById('slug');
    if (!slugInput.value) {  // Solo genera el slug si el campo está vacío
        const slug = e.target.value
            .toLowerCase()
            .replace(/[^\w\s]/gi, '')
            .replace(/\s+/g, '-');
        slugInput.value = slug;
    }
});
</script>
@endsection
