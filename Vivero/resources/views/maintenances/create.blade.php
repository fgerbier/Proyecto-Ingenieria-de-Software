@extends('layouts.dashboard')

@section('title', 'Nuevo Reporte de Mantención')

@section('content')
    <div class="py-8 px-4 md:px-8 max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('maintenance.index') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white rounded-md shadow-sm transition"
                style="background-color: var(--table-header-color);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
                Volver a la lista
            </a>
        </div>

        <form method="POST" action="{{ route('maintenance.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Información Básica --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">
                    Información del Reporte
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Título --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                            Título <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                            required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                            Estado <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                            required>
                            <option value="pendiente" {{ old('status') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="en progreso" {{ old('status') == 'en progreso' ? 'selected' : '' }}>En progreso</option>
                            <option value="finalizado" {{ old('status') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Descripción --}}
                <div class="mt-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        Descripción <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Costo e Imagen --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Costo --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">
                        Costo
                    </h2>

                    <div>
                        <label for="cost" class="block text-sm font-medium text-gray-700 mb-1">
                            Costo estimado
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                            <input type="number" id="cost" name="cost" value="{{ old('cost') }}" step="0.01" min="0"
                                class="w-full pl-7 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                        </div>
                        @error('cost')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Imagen --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">
                        Imagen del problema
                    </h2>

                    <div
                        class="cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-green-500 transition-colors relative group">
                        <input type="file" id="imagen" name="imagen" accept="image/*"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                            onchange="previewImage(this)">

                        <div id="image-preview-container">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"></path>
                                <line x1="16" y1="5" x2="22" y2="5"></line>
                                <line x1="19" y1="2" x2="19" y2="8"></line>
                                <circle cx="9" cy="9" r="2"></circle>
                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Haga clic para seleccionar una imagen</p>
                            <p class="text-xs text-gray-400">PNG, JPG, GIF hasta 5MB</p>
                        </div>

                        <div id="image-preview" class="hidden relative">
                            <img id="preview-img" src="" alt="Vista previa"
                                class="mx-auto h-48 object-contain bg-gray-50 p-2">
                            <button type="button" onclick="removeImage()"
                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 hidden group-hover:block transition-all z-20">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('imagen')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('maintenance.index') }}"
                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white rounded-md shadow-sm transition"
                    style="background-color: var(--table-header-color);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Guardar reporte
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview-container').classList.add('hidden');
                    document.getElementById('image-preview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            document.getElementById('imagen').value = '';
            document.getElementById('image-preview-container').classList.remove('hidden');
            document.getElementById('image-preview').classList.add('hidden');
        }
    </script>
@endsection
