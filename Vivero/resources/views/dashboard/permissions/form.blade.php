@extends('layouts.dashboard')

@section('title', $permission ? 'Editar Permiso' : 'Crear Permiso')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        {{ $permission ? 'Editar Permiso' : 'Crear Permiso' }}
    </h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $permission ? route('permissions.update', $permission) : route('permissions.store') }}" method="POST">
        @csrf
        @if($permission)
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Permiso</label>
            <input type="text" id="name" name="name" value="{{ old('name', $permission->name ?? '') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                   required>
        </div>

        <div class="flex justify-start">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                {{ $permission ? 'Actualizar' : 'Crear' }}
            </button>
            <a href="{{ route('permissions.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
