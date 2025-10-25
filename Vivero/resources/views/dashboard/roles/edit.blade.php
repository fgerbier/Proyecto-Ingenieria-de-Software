@extends('layouts.dashboard')

@section('title', 'Editar Rol')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="py-8 px-4 md:px-8 max-w-4xl mx-auto font-['Roboto'] text-gray-800">
    <div class="flex items-center mb-6">
        <a href="{{ route('roles.index') }}"
           class="flex items-center px-4 py-2 rounded text-white text-sm shadow transition-colors"
           style="background-color: var(--table-header-color);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver al listado
        </a>
    </div>

    <div class="bg-white border border-[color:var(--table-header-color)] shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Editar Rol: <span class="text-green-700">{{ $role->name }}</span></h2>

        <form method="POST" action="{{ route('roles.update', $role->id) }}">
            @csrf
            @method('PUT')

            {{-- Nombre del rol --}}
            <div class="mb-4">
                <label for="name" class="block font-medium text-sm mb-1">Nombre del Rol</label>
                <input type="text" name="name" id="name"
                       value="{{ old('name', $role->name) }}"
                       class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            {{-- Permisos agrupados --}}
            <div class="mb-6">
                <label class="block font-medium text-sm mb-2">Permisos</label>
                @php
                    $grouped = $permissions->groupBy(function ($perm) {
                        $parts = explode(' ', $perm->name);
                        return $parts[1] ?? $parts[0];
                    });
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($grouped as $modulo => $permisosGrupo)
                        <div>
                            <div class="font-semibold text-black mb-2 capitalize">{{ $modulo }}</div>
                            <div class="space-y-1">
                                @foreach($permisosGrupo as $perm)
                                    <label class="flex items-center text-sm text-gray-700">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                                               class="mr-2 rounded border-gray-300 text-green-600 shadow-sm"
                                               {{ $role->permissions->contains('id', $perm->id) ? 'checked' : '' }}>
                                        {{ $perm->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('roles.index') }}"
                class="px-4 py-2 rounded border text-sm text-gray-700 hover:text-black transition"
                style="background-color: white; border-color: var(--table-header-color);">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-4 py-2 rounded text-white text-sm shadow"
                        style="background-color: var(--table-header-color);">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
