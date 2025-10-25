@extends('layouts.dashboard')

@section('title', 'Nueva Tarea')

@section('content')
<div class="max-w-2xl mx-auto font-['Roboto'] text-gray-800">

    <div class="flex items-center mb-6">
        <a href="{{ route('works.index') }}"
           class="flex items-center text-white px-3 py-1 rounded transition-colors"
           style="background-color: var(--table-header-color);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver a la lista
        </a>
    </div>

    <form method="POST" action="{{ route('works.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium">Nombre de la tarea</label>
            <input type="text" name="nombre" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
        </div>

        <div>
            <label class="block font-medium">Ubicación</label>
            <select name="ubicacion" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
                <option value="produccion">Producción</option>
                <option value="venta">Local de Venta</option>
            </select>
        </div>

        <div>
            <label class="block font-medium">Responsable</label>
            <select name="responsable" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
                <option value="" disabled selected>Seleccionar responsable</option>
                @foreach($responsables as $usuario)
                    <option value="{{ $usuario->name }}">{{ $usuario->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Fecha</label>
            <input type="date" name="fecha" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
        </div>

        <div>
            <label class="block font-medium">Estado</label>
            <select name="estado" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
                <option value="pendiente">Pendiente</option>
                <option value="en progreso">En progreso</option>
                <option value="completada">Completada</option>
            </select>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end items-center space-x-4 pt-4">
            <a href="{{ route('works.index') }}"
               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                Cancelar
            </a>
            <button type="submit"
                    class="px-4 py-2 rounded text-white text-sm font-medium transition-colors"
                    style="background-color: var(--table-header-color);">
                Guardar tarea
            </button>
        </div>

    </form>
</div>
@endsection
