@extends('layouts.dashboard')

@section('title', 'Crear Nuevo Cliente')

@section('content')
@php
    $pref = Auth::user()?->preference;
@endphp

<style>
    :root {
        --table-header-color: {{ $pref?->table_header_color ?? '#0a2b59' }};
    }
</style>

<div class="py-8 px-4 md:px-8 max-w-4xl mx-auto font-['Roboto']">
    <div class="flex items-center mb-6">
        <a href="{{ route('clients.index') }}"
            class="flex items-center text-[var(--table-header-color)] hover:text-opacity-80 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver al listado
        </a>
    </div>

    <div class="bg-white p-6 rounded shadow-md border border-[var(--table-header-color)]">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Registrar Nuevo Cliente</h2>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('clients.store') }}">
            @csrf

            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Cliente</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}"
                    class="mt-1 block w-full px-4 py-2 border rounded shadow-sm focus:ring focus:outline-none"
                    required>
            </div>

            <div class="mb-4">
                <label for="subdominio" class="block text-sm font-medium text-gray-700">Subdominio</label>
                <input type="text" id="subdominio" name="subdominio" value="{{ old('subdominio') }}"
                    class="mt-1 block w-full px-4 py-2 border rounded shadow-sm focus:ring focus:outline-none"
                    placeholder="Ej: cliente1" required>
                <p class="text-xs text-gray-500 mt-1">Se accederá como <strong>cliente1.localhost</strong></p>
            </div>

            <hr class="my-6 border-t border-gray-200">

            <h3 class="text-lg font-semibold mb-2 text-gray-700">Administrador del Cliente</h3>

            <div class="mb-4">
                <label for="admin_email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" id="admin_email" name="admin_email" value="{{ old('admin_email') }}"
                    class="mt-1 block w-full px-4 py-2 border rounded shadow-sm focus:ring focus:outline-none"
                    required>
            </div>

            <div class="mb-4">
                <label for="admin_password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" id="admin_password" name="admin_password"
                    class="mt-1 block w-full px-4 py-2 border rounded shadow-sm focus:ring focus:outline-none"
                    required>
            </div>

            <div class="mb-6">
                <label for="admin_password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                <input type="password" id="admin_password_confirmation" name="admin_password_confirmation"
                    class="mt-1 block w-full px-4 py-2 border rounded shadow-sm focus:ring focus:outline-none"
                    required>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-[var(--table-header-color)] text-white px-6 py-2 rounded hover:opacity-90 transition">
                    Guardar Cliente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
