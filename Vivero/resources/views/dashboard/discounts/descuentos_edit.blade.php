@extends('layouts.dashboard')

@section('title', isset($descuento->id) ? 'Editar descuento' : 'Nuevo descuento')

@section('content')

    <div class="py-8 px-4 md:px-8 max-w-5xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('dashboard.descuentos') }}"
            class="flex items-center text-white px-3 py-1 rounded transition-colors"
            style="background-color: var(--table-header-color);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                Volver a la lista
            </a>
        </div>
        <form action="{{ isset($descuento->id) ? route('descuentos.update', $descuento->id) : route('descuentos.store') }}"
            method="POST" class="space-y-6">
            @csrf
            @if(isset($descuento->id))
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
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $descuento->nombre ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                            required>
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Código --}}
                    <div>
                        <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">
                            Código <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="codigo" name="codigo" value="{{ old('codigo', $descuento->codigo ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all font-mono uppercase"
                            required>
                        @error('codigo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tipo --}}
                    <div>
                        <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">
                            Tipo de descuento <span class="text-red-500">*</span>
                        </label>
                        <select id="tipo" name="tipo"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                            required>
                            <option value="">Seleccionar tipo</option>
                            <option value="porcentaje" {{ old('tipo', $descuento->tipo ?? '') == 'porcentaje' ? 'selected' : '' }}>Porcentaje</option>
                            <option value="fijo" {{ old('tipo', $descuento->tipo ?? '') == 'fijo' ? 'selected' : '' }}>Monto fijo</option>
                        </select>
                        @error('tipo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Valor del descuento --}}
                    <div id="valor-porcentaje-group" style="{{ old('tipo', $descuento->tipo ?? '') != 'porcentaje' ? 'display: none;' : '' }}">
                        <label for="porcentaje" class="block text-sm font-medium text-gray-700 mb-1">
                            Porcentaje de descuento <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" id="porcentaje" name="porcentaje"
                                value="{{ old('porcentaje', $descuento->porcentaje ?? '') }}" step="0.01" min="0" max="100"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                {{ old('tipo', $descuento->tipo ?? '') == 'porcentaje' ? 'required' : '' }}>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">%</span>
                            </div>
                        </div>
                        @error('porcentaje')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="valor-fijo-group" style="{{ old('tipo', $descuento->tipo ?? '') != 'fijo' ? 'display: none;' : '' }}">
                        <label for="monto_fijo" class="block text-sm font-medium text-gray-700 mb-1">
                            Monto fijo <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                            <input type="number" id="monto_fijo" name="monto_fijo"
                                value="{{ old('monto_fijo', $descuento->monto_fijo ?? '') }}" step="0.01" min="0"
                                class="w-full pl-7 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                {{ old('tipo', $descuento->tipo ?? '') == 'fijo' ? 'required' : '' }}>
                        </div>
                        @error('monto_fijo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Descripción --}}
                <div class="mt-4">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">
                        Descripción
                    </label>
                    <textarea id="descripcion" name="descripcion" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">{{ old('descripcion', $descuento->descripcion ?? '') }}</textarea>
                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Vigencia y Límites --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Vigencia --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">
                        Vigencia
                    </h2>

                    <div class="space-y-4">
                        {{-- Fecha de inicio --}}
                        <div>
                            <label for="valido_desde" class="block text-sm font-medium text-gray-700 mb-1">
                                Válido desde
                            </label>
                            <input type="datetime-local" id="valido_desde" name="valido_desde"
                                value="{{ old('valido_desde', isset($descuento->valido_desde) ? $descuento->valido_desde->format('Y-m-d\TH:i') : '') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                            @error('valido_desde')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Fecha de fin --}}
                        <div>
                            <label for="valido_hasta" class="block text-sm font-medium text-gray-700 mb-1">
                                Válido hasta
                            </label>
                            <input type="datetime-local" id="valido_hasta" name="valido_hasta"
                                value="{{ old('valido_hasta', isset($descuento->valido_hasta) ? $descuento->valido_hasta->format('Y-m-d\TH:i') : '') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                            @error('valido_hasta')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Límites de uso --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">
                        Límites de uso
                    </h2>

                    <div class="space-y-4">
                        {{-- Usos máximos --}}
                        <div>
                            <label for="usos_maximos" class="block text-sm font-medium text-gray-700 mb-1">
                                Usos máximos (0 = ilimitado)
                            </label>
                            <input type="number" id="usos_maximos" name="usos_maximos"
                                value="{{ old('usos_maximos', $descuento->usos_maximos ?? 0) }}"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                            @error('usos_maximos')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Usos actuales --}}
                        <div>
                            <label for="usos_actuales" class="block text-sm font-medium text-gray-700 mb-1">
                                Usos actuales
                            </label>
                            <input type="number" id="usos_actuales" name="usos_actuales"
                                value="{{ old('usos_actuales', $descuento->usos_actuales ?? 0) }}"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                {{ isset($descuento->id) ? '' : 'readonly' }}>
                            @error('usos_actuales')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Activo --}}
                        <div class="flex items-center">
                            <input type="hidden" name="activo" value="0">
                            <input type="checkbox" id="activo" name="activo" value="1"
                                class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded transition-colors"
                                {{ old('activo', $descuento->activo ?? '1') ? 'checked' : '' }}>
                            <label for="activo" class="ml-2 block text-sm text-gray-700">
                                Descuento activo
                            </label>
                            @error('activo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('dashboard.descuentos') }}"
                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="group relative px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white"
                        style="background-color: var(--table-header-color);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-2 -ml-1" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    {{ isset($descuento->id) ? 'Actualizar' : 'Guardar' }} descuento
                </button>

            </div>
        </form>
    </div>

    {{-- JavaScript para mostrar/ocultar campos según el tipo de descuento --}}
    <script>
        document.getElementById('tipo').addEventListener('change', function() {
            const tipo = this.value;
            const porcentajeGroup = document.getElementById('valor-porcentaje-group');
            const fijoGroup = document.getElementById('valor-fijo-group');

            if (tipo === 'porcentaje') {
                porcentajeGroup.style.display = 'block';
                fijoGroup.style.display = 'none';
                document.getElementById('porcentaje').required = true;
                document.getElementById('monto_fijo').required = false;
            } else if (tipo === 'fijo') {
                porcentajeGroup.style.display = 'none';
                fijoGroup.style.display = 'block';
                document.getElementById('porcentaje').required = false;
                document.getElementById('monto_fijo').required = true;
            } else {
                porcentajeGroup.style.display = 'none';
                fijoGroup.style.display = 'none';
                document.getElementById('porcentaje').required = false;
                document.getElementById('monto_fijo').required = false;
            }
        });

        // Convertir código a mayúsculas automáticamente
        document.getElementById('codigo').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    </script>
@endsection
