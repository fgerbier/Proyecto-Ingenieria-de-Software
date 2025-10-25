@extends('layouts.dashboard')

@section('title', 'Editar proveedor')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-4xl mx-auto">
    <a href="{{ route('proveedores.index') }}"
       class="inline-flex items-center text-white px-3 py-1 rounded"
       style="background-color: var(--table-header-color); transition: background-color 0.3s;">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m15 18-6-6 6-6" />
        </svg>
        Volver a la lista
    </a>

    <form method="POST" action="{{ route('proveedores.update', $proveedor->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        @include('proveedores.form-fields', ['proveedor' => $proveedor])
        
        <div class="flex justify-end space-x-4 mt-4">
            <a href="{{ route('proveedores.index') }}"
               class="px-4 py-2 border rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50 transition">
                Cancelar
            </a>
            <button type="submit"
                    class="inline-flex items-center px-6 py-2 text-white rounded"
                    style="background-color: var(--table-header-color); transition: background-color 0.3s;">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection
