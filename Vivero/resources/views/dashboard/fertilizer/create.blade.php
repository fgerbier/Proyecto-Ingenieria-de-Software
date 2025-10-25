@extends('layouts.dashboard')

@section('title', 'Registrar Fertilización')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-4xl mx-auto font-['Roboto'] text-gray-800">

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

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Últimas fertilizaciones --}}
    @if($ultimasFertilizaciones->count())
        <div class="mb-6 p-4 border border-gray-200 rounded bg-gray-50 text-sm text-gray-700">
            <p class="mb-2 font-semibold text-green-700">Últimas fertilizaciones registradas:</p>
            <ul class="list-disc list-inside">
                @foreach($ultimasFertilizaciones as $f)
                    <li>
                        {{ \Carbon\Carbon::parse($f->fecha_aplicacion)->format('d/m/Y') }}:
                        {{ $f->producto->nombre }} con {{ $f->fertilizante->nombre }} ({{ $f->dosis_aplicada ?? 'sin dosis' }})
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario --}}
    <form action="{{ route('fertilizations.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="producto_id" class="block text-sm font-medium text-gray-700 mb-1">Producto</label>
                <select name="producto_id" id="producto_id" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                    <option value="">Selecciona un producto</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="fertilizante_id" class="block text-sm font-medium text-gray-700 mb-1">Fertilizante</label>
                <select name="fertilizante_id" id="fertilizante_id" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                    <option value="">Selecciona un fertilizante</option>
                    @foreach($fertilizantes as $fertilizante)
                        <option value="{{ $fertilizante->id }}" {{ old('fertilizante_id', $fertilizante_id ?? '') == $fertilizante->id ? 'selected' : '' }}>
                            {{ $fertilizante->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="fecha_aplicacion" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Aplicación</label>
                <input type="date" name="fecha_aplicacion" id="fecha_aplicacion" required value="{{ old('fecha_aplicacion') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label for="dosis_aplicada" class="block text-sm font-medium text-gray-700 mb-1">Dosis Aplicada</label>
                <input type="text" name="dosis_aplicada" id="dosis_aplicada" value="{{ old('dosis_aplicada') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
            </div>
        </div>

        <div>
            <label for="notas" class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
            <textarea name="notas" id="notas" rows="3"
                      class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">{{ old('notas') }}</textarea>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end space-x-4 pt-4">
            <a href="{{ route('dashboard.fertilizantes') }}"
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
                Registrar Aplicación
            </button>
        </div>
    </form>
</div>
@endsection
