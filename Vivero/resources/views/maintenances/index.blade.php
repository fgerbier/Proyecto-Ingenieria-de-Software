@extends('layouts.dashboard')

@section('title', 'Reportes de Mantención')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<style>
    :root {
        --table-header-color: {{ Auth::user()?->preference?->table_header_color ?? '#0a2b59' }};
        --table-header-text-color: {{ Auth::user()?->preference?->table_header_text_color ?? '#ffffff' }};
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

    .action-button {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .edit-btn {
        color: #2563eb;
        border: 1px solid #2563eb;
    }

    .edit-btn:hover {
        background-color: #eff6ff;
    }

    .delete-btn {
        color: #dc2626;
        border: 1px solid #dc2626;
    }

    .delete-btn:hover {
        background-color: #fef2f2;
    }
</style>

<div class="max-w-7xl mx-auto font-['Roboto'] text-gray-800">
    <div class="rounded-lg shadow-sm p-6">
        <div class="mb-4 flex justify-end">
            @can('gestionar infraestructura')
                <a href="{{ route('maintenance.create') }}"
                   class="px-4 py-2 rounded shadow text-white text-sm font-medium transition-colors"
                   style="background-color: var(--table-header-color);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo Reporte
                </a>
            @endcan
        </div>

        <div class="overflow-x-auto custom-border bg-white">
            <table class="min-w-full table-auto text-sm text-left text-gray-800">
                <thead class="custom-table-header uppercase tracking-wider font-['Roboto_Condensed']">
                    <tr>
                        <th class="px-4 py-3">Título</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Costo</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y font-['Roboto']">
                    @foreach($maintenances as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $item->title }}</td>
                            <td class="px-4 py-2">{{ ucfirst($item->status) }}</td>
                            <td class="px-4 py-2">{{ $item->updated_at->format('d-m-Y H:i') }}</td>
                            <td class="px-4 py-2">${{ number_format($item->cost, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                @can('gestionar infraestructura')
                                    <a href="{{ route('maintenance.edit', $item->id) }}"
                                       class="action-button edit-btn">
                                        Editar
                                    </a>
                                    <button type="button"
                                            onclick="openDeleteModal({{ $item->id }}, '{{ $item->title }}')"
                                            class="action-button delete-btn">
                                        Eliminar
                                    </button>
                                @else
                                    <span class="text-gray-500 italic text-sm">Solo lectura</span>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 px-4 py-2">
                {{ $maintenances->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Modal de eliminación --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md font-['Roboto']">
        <h2 class="text-lg font-bold text-gray-800 mb-4 font-['Roboto_Condensed']">¿Eliminar reporte?</h2>
        <p class="text-gray-700 mb-4">¿Deseas eliminar el reporte <span id="modalTitle" class="font-semibold"></span>?</p>
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-3">
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-4 py-2 text-white rounded hover:opacity-90"
                        style="background-color: var(--table-header-color);">
                    Eliminar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(id, title) {
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('deleteForm').action = `/maintenance/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }
</script>
@endsection
