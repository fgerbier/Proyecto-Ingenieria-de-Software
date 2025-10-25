@extends('layouts.dashboard')

@section('title', $role ? 'Editar Rol' : 'Crear Rol')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-3xl mx-auto font-['Roboto'] text-gray-800">

    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
        {{ $role ? 'Editar Rol' : 'Crear Nuevo Rol' }}
    </h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $role
        ? route('roles.update', ['role' => $role->id, 'source' => $source])
        : route('roles.store', ['source' => $source]) }}"
        method="POST"
        class="bg-white rounded shadow border p-6"
        style="border-color: var(--table-header-color);"
    >
        @csrf
        @if($role)
            @method('PUT')
        @endif

        {{-- Nombre del Rol --}}
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-black mb-1">Nombre del Rol:</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $role->name ?? '') }}"
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-eaccent focus:border-eaccent px-4 py-2"
                   required>
        </div>

        {{-- Permisos --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-black mb-2">Permisos:</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($permissions as $permission)
                    <label class="inline-flex items-center text-black">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                            {{ (isset($role) && $role->permissions->contains($permission->id)) || (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) ? 'checked' : '' }}
                            class="form-checkbox text-black border-black focus:ring-black">
                        <span class="ml-2 text-sm text-black">{{ $permission->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-start items-center gap-4 mt-4">
            <button type="submit"
                    class="text-white font-semibold px-6 py-2 rounded shadow"
                    style="background-color: var(--table-header-color);">
                {{ $role ? 'Actualizar Rol' : 'Crear Rol' }}
            </button>

            <a href="{{ route('roles.index', ['source' => $source]) }}"
               class="text-sm text-gray-600 hover:text-gray-900 hover:underline">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
