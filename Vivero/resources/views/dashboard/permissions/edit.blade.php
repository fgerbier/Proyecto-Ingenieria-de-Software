@extends('layouts.dashboard')

@section('title', 'Editar Permiso')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <h1 class="text-2xl font-bold text-eprimary mb-6">Editar permiso</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('permissions.update', $permission) }}" method="POST" class="bg-white shadow rounded px-6 py-8">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre del permiso</label>
            <input type="text" name="name" id="name"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-eaccent focus:border-eaccent"
                   value="{{ old('name', $permission->name) }}" required>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('permissions.index') }}"
               class="mr-4 text-gray-600 hover:underline">Cancelar</a>
            <button type="submit"
                    class="bg-eprimary text-white px-4 py-2 rounded hover:bg-eprimary-600 transition">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection
