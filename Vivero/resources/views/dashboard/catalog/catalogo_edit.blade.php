@extends('layouts.dashboard')

@section('title', 'Editar producto')

@section('content')

    <div class="py-8 px-4 md:px-8 max-w-5xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('dashboard.catalogo') }}"
            class="flex items-center text-white px-3 py-1 rounded transition-colors"
            style="background-color: var(--table-header-color);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                Volver a la lista
            </a>

        </div>

        <form action="{{ isset($producto->id) ? route('catalogo.update', $producto->id) : route('catalogo.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @if(isset($producto->id))
                @method('PUT')
            @endif

            {{-- Información Básica --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">
                    Información Básica
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nombre --}}
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                            required>
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nombre Científico --}}
                    <div>
                        <label for="nombre_cientifico" class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre Científico <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nombre_cientifico" name="nombre_cientifico"
                            value="{{ old('nombre_cientifico', $producto->nombre_cientifico ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all italic"
                            required>
                        @error('nombre_cientifico')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Categoría --}}
                    <div>
                        <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">
                            Categoría <span class="text-red-500">*</span>
                        </label>
                        <select id="categoria" name="categoria"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                            required>
                            <option value="">Seleccionar categoría</option>
                            @foreach($categorias ?? [] as $category)
                                <option value="{{ $category->nombre }}" {{ old('categoria', $producto->categoria ?? '') == $category->nombre ? 'selected' : '' }}>
                                    {{ $category->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Origen --}}
                    <div>
                        <label for="origen" class="block text-sm font-medium text-gray-700 mb-1">
                            Origen
                        </label>
                        <input type="text" id="origen" name="origen" value="{{ old('origen', $producto->origen ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                        @error('origen')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Código de Barras --}}
                    <div>
                        <label for="codigo_barras" class="block text-sm font-medium text-gray-700 mb-1">
                            Código de Barras
                        </label>
                        {{ $barras = mt_rand(100000000000, 999999999999) }}

                        <input class="hidden" type="hidden" id="codigo_barras_hidden" name="codigo_barras" value="{{ old('codigo_barras', $producto->codigo_barras ?? $barras) }}">
                        @error('codigo_barras')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Slug --}}
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">
                            Slug<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $producto->slug ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all font-mono"
                            required>
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Tamaño --}}
                    <div>
                        <label for="tamano" class="block text-sm font-medium text-gray-700 mb-1">
                            Tamaño (cm)
                        </label>
                        <input type="number" id="tamano" name="tamano" value="{{ old('tamano', $producto->tamano ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                            placeholder="Ej: 15-20cm">
                        @error('tamano')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Descripción --}}
                <div class="mt-4">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">
                        Descripción <span class="text-red-500">*</span>
                    </label>
                    <textarea id="descripcion" name="descripcion" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        required>{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Imagen y Estados --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Imagen --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">
                        Imagen del producto
                    </h2>

                    <div
                        class="cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-green-500 transition-colors relative group">
                        <input type="file" id="imagen" name="imagen" accept="image/*"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                            onchange="previewImage(this)">

                        <div id="image-preview-container" class="{{ isset($producto->imagen) ? 'hidden' : 'block' }}">
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

                        <div id="image-preview" class="{{ isset($producto->imagen) ? 'block' : 'hidden' }} relative">
                            <img id="preview-img"
                                src="{{ isset($producto->imagen) ? asset('storage/' . $producto->imagen) : '' }}"
                                alt="Vista previa" class="mx-auto h-48 object-contain">
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

                        @if(isset($producto->imagen))
                            <input type="hidden" name="imagen_actual" value="{{ $producto->imagen }}">
                        @endif
                    </div>
                    @error('imagen')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Inventario y Estados --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">
                        Inventario y Estados
                    </h2>

                    <div class="space-y-4">
                        {{-- Precio --}}
                        <div>
                            <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">
                                Precio <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="precio" name="precio"
                                    value="{{ old('precio', $producto->precio ?? '') }}" step="0.01" min="0"
                                    class="w-full pl-7 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                    required>
                            </div>
                            @error('precio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Stock --}}
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">
                                Stock <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock', $producto->stock ?? '') }}"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                required>
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tóxica --}}
                        <div class="flex items-center">
                            <input type="hidden" name="toxica" value="0">
                            <input type="checkbox" id="toxica" name="toxica" value="1"
                                class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded transition-colors"
                                {{ old('toxica', $producto->toxica ?? '') ? 'checked' : '' }}>
                            <label for="toxica" class="ml-2 block text-sm text-gray-700">
                                Planta Tóxica
                            </label>
                            @error('toxica')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Activo --}}
                        <div class="flex items-center">
                            <input type="hidden" name="activo" value="0">
                            <input type="checkbox" id="activo" name="activo" value="1"
                                class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded transition-colors"
                                {{ old('activo', $producto->activo ?? '1') ? 'checked' : '' }}>
                            <label for="activo" class="ml-2 block text-sm text-gray-700">
                                Producto Activo
                            </label>
                            @error('activo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cuidados y Características --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">
                    Cuidados y Características
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nivel de Dificultad --}}
                    <div>
                        <label for="nivel_dificultad" class="block text-sm font-medium text-gray-700 mb-1">
                            Nivel de Dificultad
                        </label>
                        <select id="nivel_dificultad" name="nivel_dificultad"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                            <option value="">Seleccionar dificultad</option>
                            @foreach($dificultades as $dificultad)
                                <option value="{{ $dificultad }}" {{ old('nivel_dificultad', $producto->nivel_dificultad ?? '') == $dificultad ? 'selected' : '' }}>
                                    {{ ucfirst($dificultad) }}
                                </option>
                            @endforeach
                        </select>
                        @error('nivel_dificultad')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Frecuencia de Riego --}}
                    <div>
                        <label for="frecuencia_riego" class="block text-sm font-medium text-gray-700 mb-1">
                            Frecuencia de Riego
                        </label>
                        <input type="text" id="frecuencia_riego" name="frecuencia_riego"
                            value="{{ old('frecuencia_riego', $producto->frecuencia_riego ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                            placeholder="Ej: 2 veces por semana">
                        @error('frecuencia_riego')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Ubicación Ideal --}}
                    <div>
                        <label for="ubicacion_ideal" class="block text-sm font-medium text-gray-700 mb-1">
                            Ubicación Ideal
                        </label>
                        <input type="text" id="ubicacion_ideal" name="ubicacion_ideal"
                            value="{{ old('ubicacion_ideal', $producto->ubicacion_ideal ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                            placeholder="Ej: Interior, sombra parcial">
                        @error('ubicacion_ideal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Cuidados --}}
                <div class="mt-4">
                    <label for="cuidados" class="block text-sm font-medium text-gray-700 mb-1">
                        Cuidados
                    </label>
                    <textarea id="cuidados" name="cuidados" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">{{ old('cuidados', $producto->cuidados ?? '') }}</textarea>
                    @error('cuidados')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Beneficios --}}
                <div class="mt-4">
                    <label for="beneficios" class="block text-sm font-medium text-gray-700 mb-1">
                        Beneficios
                    </label>
                    <textarea id="beneficios" name="beneficios" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">{{ old('beneficios', $producto->beneficios ?? '') }}</textarea>
                    @error('beneficios')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('dashboard.catalogo') }}"
                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                    class="group relative px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors"
                    style="background-color: var(--table-header-color);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-2 -ml-1" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    {{ isset($producto->id) ? 'Actualizar' : 'Guardar' }} producto
                </button>
            </div>
        </form>
    </div>

    {{-- JavaScript for image preview --}}
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
