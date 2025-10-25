@extends('layouts.dashboard')

@section('title', 'Categorías')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="max-w-4xl mx-auto font-['Roboto'] text-gray-800">
    <div class="rounded-lg shadow-sm p-6 bg-white">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-['Roboto_Condensed']">Listado de Categorías</h2>
            <a href="{{ route('categorias.add') }}"
                class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm">
                Nueva Categoría
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left text-gray-800 bg-white">
                <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 font-['Roboto']">
                    @foreach ($categorias as $categoria)
                        <tr>
                            <td class="px-6 py-3">{{ $categoria->id }}</td>
                            <td class="px-6 py-3">{{ $categoria->nombre }}</td>
                            <td class="px-6 py-3">
                                <div class="flex space-x-2">
                                    @if ($categoria->nombre !== 'Sin Categorizar')
                                        <a href="{{ route('categorias.edit', $categoria->id) }}"
                                            class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1 rounded">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('categorias.destroy', $categoria->id) }}"
                                            onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800 px-3 py-1 rounded">
                                                Eliminar
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 italic">Protegida</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
