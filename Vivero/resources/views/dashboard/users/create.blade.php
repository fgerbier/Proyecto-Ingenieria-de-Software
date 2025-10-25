@extends('layouts.dashboard')

@section('title', 'Nuevo Usuario')

@section('content')
@php
    $pref = Auth::user()?->preference;
@endphp

<style>
    :root {
        --table-header-color: {{ $pref?->table_header_color ?? '#0a2b59' }};
        --table-header-text-color: {{ $pref?->table_header_text_color ?? '#FFFFFF' }};
    }
</style>

<div class="py-8 px-4 md:px-8 max-w-xl mx-auto font-['Roboto'] text-gray-800">
    {{-- Botón volver --}}
    <a href="{{ route('users.index') }}"
       class="mb-6 inline-flex items-center text-white border px-3 py-1 rounded transition-colors"
       style="background-color: var(--table-header-color); border-color: var(--table-header-color);">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6" />
        </svg>
        Volver a la lista
    </a>

    {{-- Errores generales --}}
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf

        {{-- Nombre --}}
        <div>
            <label class="block text-sm font-medium mb-1">Nombre</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border px-3 py-2 rounded" required>
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Correo --}}
        <div>
            <label class="block text-sm font-medium mb-1">Correo</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border px-3 py-2 rounded" required>
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Contraseña --}}
        <div>
            <label class="block text-sm font-medium mb-1">Contraseña</label>
            <input type="password" name="password" class="w-full border px-3 py-2 rounded" required>
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirmar contraseña --}}
        <div>
            <label class="block text-sm font-medium mb-1">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded" required>
        </div>

        {{-- Rol --}}
        <div>
            <label class="block text-sm font-medium mb-1">Rol</label>
            <select name="role" class="w-full border px-3 py-2 rounded" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
            @error('role')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Botones --}}
        <div class="flex items-center justify-end space-x-4 mt-6">
            <a href="{{ route('users.index') }}"
               class="text-gray-600 hover:underline">Cancelar</a>
            <button type="submit"
                    class="text-white px-4 py-2 rounded transition-colors"
                    style="background-color: var(--table-header-color); border-color: var(--table-header-color);">
                Crear
            </button>
        </div>
    </form>
</div>
@endsection
