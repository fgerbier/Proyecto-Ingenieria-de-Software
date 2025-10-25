@extends('layouts.dashboard')

@section('title', 'Listado de Roles')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="py-8 px-4 md:px-8 max-w-7xl mx-auto font-['Roboto'] text-gray-800">
    <div class="flex items-center mb-6">
        @can('crear roles')
            <a href="{{ route('roles.create', ['source' => $source]) }}"
               class="ml-auto flex items-center px-3 py-1 rounded transition-colors text-white"
               style="background-color: var(--table-header-color);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
                Agregar Rol
            </a>
        @endcan
    </div>

    <div class="bg-white shadow sm:rounded-lg overflow-hidden border border-[color:var(--table-header-color)]">
        @forelse($roles as $role)
            <div x-data="{ open: false }" class="border-b" style="border-color: var(--table-header-color);">
                {{-- Cabecera de la fila --}}
                <button @click="open = !open"
                        class="w-full text-left px-4 py-3 flex items-center justify-between transition"
                        style="background-color: white;">
                    <div class="font-semibold text-black capitalize">{{ $role->name }}</div>
                    <svg :class="{ 'rotate-180': open }" class="h-5 w-5 transform transition-transform duration-200"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </button>

                {{-- Contenido colapsable --}}
                <div x-show="open" x-transition class="px-6 pb-4 pt-2 bg-white text-sm">
                    {{-- Permisos --}}
                    <div class="mb-4">
                        <strong class="text-black">Permisos:</strong>
                        @if($role->permissions->isEmpty())
                            <p class="italic text-gray-400 mt-1">Sin permisos asignados</p>
                        @else
                            @php
                                $grouped = collect($role->permissions)->groupBy(function ($perm) {
                                    $parts = explode(' ', $perm->name);
                                    return $parts[1] ?? $parts[0];
                                });
                            @endphp
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                @foreach($grouped as $modulo => $permisos)
                                    <div>
                                        <div class="font-semibold text-black capitalize mb-1">{{ $modulo }}</div>
                                        <ul class="list-disc list-inside text-gray-700 ml-2">
                                            @foreach($permisos as $perm)
                                                <li>{{ $perm->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Acciones --}}
                    <div>
                        <strong class="text-black">Acciones:</strong>
                        <div class="mt-2 flex gap-2 flex-wrap">
                            @if(!in_array($role->name, [ 'user', 'soporte']))
                                @can('editar roles')
                                    <a href="{{ route('roles.edit', ['role' => $role->id, 'source' => $source]) }}"
                                       class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1 rounded transition-colors">
                                        Editar
                                    </a>
                                @endcan

                                @can('eliminar roles')
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('¿Estás seguro de eliminar este rol?')"
                                                class="text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800 px-3 py-1 rounded transition-colors">
                                            Eliminar
                                        </button>
                                    </form>
                                @endcan
                            @else
                                <span class="text-gray-400 italic">Protegido</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="px-6 py-4 text-gray-500 italic">No hay roles creados aún.</div>
        @endforelse
    </div>
</div>
@endsection
