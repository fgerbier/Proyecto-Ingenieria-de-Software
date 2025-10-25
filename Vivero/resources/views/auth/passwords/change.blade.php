@extends('layouts.dashboard')

@section('title', 'Cambiar Contraseña')

@section('content')
<div class="max-w-md mx-auto py-10 font-['Roboto'] text-gray-800">
    <h2 class="text-2xl font-bold mb-6 text-center">Actualizar Contraseña</h2>

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

    <form method="POST" action="{{ route('password.change') }}" class="bg-white p-6 rounded shadow space-y-4">
        @csrf

        {{-- Nueva contraseña --}}
        <div>
            <label class="block text-sm font-medium mb-1">Nueva contraseña</label>
            <input type="password" name="password" class="w-full border px-3 py-2 rounded" required>
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirmación de nueva contraseña --}}
        <div>
            <label class="block text-sm font-medium mb-1">Confirmar nueva contraseña</label>
            <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-eaccent2 text-white px-4 py-2 rounded hover:bg-green-700">
                Guardar nueva contraseña
            </button>
        </div>
    </form>
</div>
@endsection
