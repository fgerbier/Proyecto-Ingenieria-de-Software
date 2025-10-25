@extends('layouts.dashboard')

@section('title', 'Gestión de Usuarios')

@section('content')
@php
    $pref = Auth::user()?->preference;
@endphp

<style>
    :root {
        --table-header-color: {{ $pref?->table_header_color ?? '#0a2b59' }};
        --table-header-text-color: {{ $pref?->table_header_text_color ?? '#FFFFFF' }};
    }

    .custom-table-header {
        background-color: var(--table-header-color);
        color: var(--table-header-text-color) !important;
    }

    .custom-border {
        border: 2px solid var(--table-header-color);
        border-radius: 8px;
        overflow: hidden;
    }

    .custom-border thead th {
        border-bottom: 2px solid var(--table-header-color);
    }

    .custom-border tbody td {
        border-top: 1px solid #e5e7eb;
        border-left: none !important;
        border-right: none !important;
    }

    .custom-border tbody tr:last-child td {
        border-bottom: none;
    }
</style>

<div class="py-8 px-4 md:px-8 max-w-7xl mx-auto font-['Roboto'] text-gray-800">
    {{-- Encabezado con buscador y botón --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        {{-- Filtro por email --}}
        <form method="GET" action="{{ route('users.index') }}" class="flex flex-grow items-center space-x-3">
            <input type="text" name="email" value="{{ request('email') }}"
                   class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:border-green-500"
                   placeholder="Buscar por correo electrónico">
            <button type="submit"
                    class="text-white px-4 py-2 rounded border shadow transition-colors"
                    style="background-color: var(--table-header-color); border-color: var(--table-header-color);">
                Buscar
            </button>
            @if(request('email'))
                <a href="{{ route('users.index') }}"
                   class="text-gray-500 hover:underline text-sm">Limpiar</a>
            @endif
        </form>

        {{-- Botón Nuevo Usuario --}}
        @can('gestionar usuarios')
            <a href="{{ route('users.create') }}"
               class="flex items-center text-white border px-3 py-1 rounded transition-colors whitespace-nowrap"
               style="background-color: var(--table-header-color); border-color: var(--table-header-color);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Usuario
            </a>
        @endcan
    </div>

    {{-- Tabla de usuarios --}}
    <div class="overflow-x-auto bg-white shadow custom-border">
        <table class="min-w-full table-auto text-sm text-left text-gray-800 bg-white">
            <thead class="custom-table-header uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-4 py-3 whitespace-nowrap">Nombre</th>
                    <th class="px-4 py-3 whitespace-nowrap">Email</th>
                    <th class="px-4 py-3 whitespace-nowrap">Rol actual</th>
                    <th class="px-4 py-3 whitespace-nowrap">Acción</th>
                </tr>
            </thead>
            <tbody class="font-['Roboto']">
                @foreach($users as $user)
                    <tr>
                        <td class="px-4 py-3 font-medium whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $user->roles->pluck('name')->join(', ') ?: 'user' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <form action="{{ route('users.updateRole', $user) }}" method="POST" class="flex items-center space-x-2 flex-wrap">
                                @csrf
                                @method('PUT')
                                <select name="role" class="border rounded px-2 py-1 text-sm">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                        class="text-indigo-600 hover:text-indigo-800 border border-indigo-600 hover:border-indigo-800 px-3 py-1 rounded transition-colors">
                                    Asignar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
