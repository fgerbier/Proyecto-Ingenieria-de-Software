@extends('layouts.dashboard')

@section('title', 'Gestión de Tareas del Vivero')

@section('content')
<div class="font-['Roboto'] text-gray-800">
    <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <form method="GET" action="{{ route('works.index') }}" class="flex flex-wrap gap-2 items-center w-full md:max-w-xl">
            <input type="text" name="responsable" value="{{ request('responsable') }}"
                   placeholder="Buscar por responsable..."
                   class="px-4 py-2 border rounded shadow text-sm w-full md:w-auto" />

            <select name="estado" class="px-4 py-2 border rounded shadow text-sm w-full md:w-auto">
                <option value="">Todos los estados</option>
                <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="en progreso" {{ request('estado') === 'en progreso' ? 'selected' : '' }}>En progreso</option>
                <option value="completada" {{ request('estado') === 'completada' ? 'selected' : '' }}>Completada</option>
            </select>

            <button type="submit"
                    class="text-white px-3 py-2 rounded text-sm transition-colors"
                    style="background-color: var(--table-header-color);">
                Buscar
            </button>

            @if(request('responsable') || request('estado'))
            <a href="{{ route('works.index') }}"
               class="text-sm text-gray-600 hover:text-gray-800 underline">
                Limpiar
            </a>
            @endif
        </form>

        @can('gestionar tareas')
        <a href="{{ route('works.create') }}"
           class="flex items-center text-white px-3 py-2 rounded transition-colors"
           style="background-color: var(--table-header-color);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Nueva tarea
        </a>
        @endcan
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Producción --}}
        <div>
            <h3 class="text-xl font-semibold mb-2">🌱 Producción</h3>
            <div class="space-y-3">
                @foreach ($works->where('ubicacion', 'produccion')->filter(function ($t) {
                    $responsable = request('responsable');
                    $estado = request('estado');
                    return (!$responsable || str_contains(strtolower($t->responsable), strtolower($responsable))) &&
                           (!$estado || $t->estado === $estado);
                }) as $tarea)
                    <div class="bg-white shadow rounded p-4 border-l-4 border-green-500">
                        <div class="font-semibold">{{ $tarea->nombre }}</div>
                        <div class="text-sm text-gray-600 mb-2">
                            Responsable: {{ $tarea->responsable }}<br>
                            Fecha: {{ \Carbon\Carbon::parse($tarea->fecha)->format('d/m/Y') }}
                        </div>

                        @can('gestionar tareas')
                        <div class="flex flex-wrap items-center gap-4 mb-2">
                            <form action="{{ route('works.updateStatus', $tarea->id) }}" method="POST" class="flex flex-wrap items-center gap-4">
                                @csrf
                                @method('PATCH')
                                @foreach(['pendiente', 'en progreso', 'completada'] as $estado)
                                    @php
                                        $color = match($estado) {
                                            'pendiente' => 'text-gray-600',
                                            'en progreso' => 'text-yellow-700',
                                            'completada' => 'text-green-700',
                                        };
                                    @endphp
                                    <label class="inline-flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" name="estado" value="{{ $estado }}"
                                               onchange="this.form.submit()" {{ $tarea->estado === $estado ? 'checked' : '' }}
                                               class="form-radio h-4 w-4 text-green-600">
                                        <span class="text-sm {{ $color }}">{{ ucfirst($estado) }}</span>
                                    </label>
                                @endforeach
                            </form>

                            <a href="{{ route('works.edit', $tarea->id) }}"
                               class="text-indigo-600 hover:text-indigo-800 border border-indigo-600 hover:border-indigo-800 px-2 py-1 rounded transition-colors"
                               title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                </svg>
                            </a>
                        </div>
                        @endcan
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Venta --}}
        <div>
            <h3 class="text-xl font-semibold mb-2">🛒 Local de Venta</h3>
            <div class="space-y-3">
                @foreach ($works->where('ubicacion', 'venta')->filter(function ($t) {
                    $responsable = request('responsable');
                    $estado = request('estado');
                    return (!$responsable || str_contains(strtolower($t->responsable), strtolower($responsable))) &&
                           (!$estado || $t->estado === $estado);
                }) as $tarea)
                    <div class="bg-white shadow rounded p-4 border-l-4 border-yellow-500">
                        <div class="font-semibold">{{ $tarea->nombre }}</div>
                        <div class="text-sm text-gray-600 mb-2">
                            Responsable: {{ $tarea->responsable }}<br>
                            Fecha: {{ \Carbon\Carbon::parse($tarea->fecha)->format('d/m/Y') }}
                        </div>

                        @can('gestionar tareas')
                        <div class="flex flex-wrap items-center gap-4 mb-2">
                            <form action="{{ route('works.updateStatus', $tarea->id) }}" method="POST" class="flex flex-wrap items-center gap-4">
                                @csrf
                                @method('PATCH')
                                @foreach(['pendiente', 'en progreso', 'completada'] as $estado)
                                    @php
                                        $color = match($estado) {
                                            'pendiente' => 'text-gray-600',
                                            'en progreso' => 'text-yellow-700',
                                            'completada' => 'text-green-700',
                                        };
                                    @endphp
                                    <label class="inline-flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" name="estado" value="{{ $estado }}"
                                               onchange="this.form.submit()" {{ $tarea->estado === $estado ? 'checked' : '' }}
                                               class="form-radio h-4 w-4 text-green-600">
                                        <span class="text-sm {{ $color }}">{{ ucfirst($estado) }}</span>
                                    </label>
                                @endforeach
                            </form>

                            <a href="{{ route('works.edit', $tarea->id) }}"
                               class="text-indigo-600 hover:text-indigo-800 border border-indigo-600 hover:border-indigo-800 px-2 py-1 rounded transition-colors"
                               title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                </svg>
                            </a>
                        </div>
                        @endcan
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
