@extends('layouts.dashboard')

@section('title', 'Editar Tarea')

@section('content')
<div class="max-w-2xl mx-auto font-['Roboto'] text-gray-800">

    <form method="POST" action="{{ route('works.update', $work) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Nombre de la tarea</label>
            <input type="text" name="nombre" value="{{ old('nombre', $work->nombre) }}" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
        </div>

        <div>
            <label class="block font-medium">Ubicación</label>
            <select name="ubicacion" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
                <option value="produccion" @selected($work->ubicacion === 'produccion')>Producción</option>
                <option value="venta" @selected($work->ubicacion === 'venta')>Local de Venta</option>
            </select>
        </div>

        <div>
            <label class="block font-medium">Responsable</label>
            <select name="responsable" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
                @foreach(\App\Models\User::whereHas('roles', fn($q) => $q->where('name', '!=', 'user'))->get() as $usuario)
                    <option value="{{ $usuario->name }}" @selected($usuario->name === old('responsable', $work->responsable))>
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Fecha</label>
            <input type="date" name="fecha" value="{{ old('fecha', $work->fecha) }}" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
        </div>

        <div>
            <label class="block font-medium">Estado</label>
            <select name="estado" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
                <option value="pendiente" @selected($work->estado === 'pendiente')>Pendiente</option>
                <option value="en progreso" @selected($work->estado === 'en progreso')>En progreso</option>
                <option value="completada" @selected($work->estado === 'completada')>Completada</option>
            </select>
        </div>

        {{-- Botones de acción actualizados --}}
        <div class="pt-4 flex justify-end">
            <div class="flex gap-4 items-center">
                <a href="{{ route('works.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-4 py-2 rounded text-white text-sm font-medium transition-colors"
                        style="background-color: var(--table-header-color);">
                    Actualizar tarea
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
