@extends('layouts.dashboard')

@section('title', 'Listado de Permisos')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-4xl mx-auto">
    <div class="flex items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Permisos</h1>
        <a href="{{ route('permissions.create') }}"
           class="ml-auto text-green-700 hover:text-green-800 transition-colors">
            + Crear Permiso
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($permissions as $permission)
                    <tr>
                        <td class="px-6 py-4">{{ $permission->name }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('permissions.edit', $permission) }}" class="text-blue-600 hover:underline">Editar</a>
                            <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline" onclick="return confirm('¿Eliminar este permiso?')">
                                    Eliminar
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
