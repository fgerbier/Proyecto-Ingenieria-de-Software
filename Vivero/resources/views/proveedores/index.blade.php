@extends('layouts.dashboard')

@section('title', 'Lista de Proveedores')

@section('content')
    <div class="max-w-7xl mx-auto font-['Roboto'] text-gray-800">
        @if (session('success'))
            <div id="success-message" class="bg-[#FFF9DB] border-l-4 border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-6 shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-lg shadow-sm p-6">
            <div class="flex justify-end items-center mb-4">
                <a href="{{ route('proveedores.create') }}"
                   class="flex items-center bg-[var(--table-header-color)] text-white px-4 py-2 rounded hover:bg-opacity-90 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    Añadir Proveedor
                </a>
            </div>

            <div class="overflow-x-auto rounded-xl border-2 border-[var(--table-header-color)]">
                <table class="min-w-full table-auto text-sm text-left text-gray-800 bg-white rounded-xl">
                    <thead class="custom-table-header uppercase tracking-wider font-['Roboto_Condensed']">
                        <tr>
                            <th class="px-6 py-4 text-center">ID</th>
                            <th class="px-6 py-4">Nombre</th>
                            <th class="px-6 py-4">Empresa</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Teléfono</th>
                            <th class="px-6 py-4">Tipo</th>
                            <th class="px-6 py-4">Estado</th>
                            <th class="px-6 py-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="font-['Roboto']">
                        @foreach ($proveedores as $proveedor)
                            <tr>
                                <td class="px-4 py-2 text-center">{{ $proveedor->id }}</td>
                                <td class="px-4 py-2">{{ $proveedor->nombre }}</td>
                                <td class="px-4 py-2">{{ $proveedor->empresa }}</td>
                                <td class="px-4 py-2">{{ $proveedor->email }}</td>
                                <td class="px-4 py-2">{{ $proveedor->telefono }}</td>
                                <td class="px-4 py-2">{{ $proveedor->tipo_proveedor }}</td>
                                <td class="px-4 py-2">{{ $proveedor->estado }}</td>
                                <td class="px-4 py-2">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('proveedores.edit', $proveedor) }}"
                                        class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1 rounded transition-colors">
                                            Editar
                                        </a>
                                        <button type="button"
                                                onclick="openDeleteModal({{ $proveedor->id }}, '{{ $proveedor->nombre }}', '{{ $proveedor->empresa }}')"
                                                class="text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800 px-3 py-1 rounded transition-colors">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Modal de confirmación -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md font-['Roboto']">
            <h2 class="text-lg font-bold text-gray-800 mb-4 font-['Roboto_Condensed']">¿Eliminar proveedor?</h2>
            <p class="text-gray-700 mb-4">
                ¿Estás seguro que deseas eliminar al proveedor
                <span id="modalProviderName" class="font-semibold"></span> de la empresa
                <span id="modalProviderCompany" class="font-semibold"></span>?
            </p>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal(id, nombre, empresa) {
            document.getElementById('modalProviderName').textContent = nombre;
            document.getElementById('modalProviderCompany').textContent = empresa;
            document.getElementById('deleteForm').action = `/proveedores/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }
    </script>
@endsection
