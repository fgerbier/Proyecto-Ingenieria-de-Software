@extends('layouts.dashboard')

@section('title', 'Agregar Evento de Siembra')

@section('content')
<div class="py-8 px-4 md:px-8 font-['Roboto'] text-gray-800">

    {{-- Botón Volver arriba --}}
    <div class="mb-4">
        <a href="{{ route('simple_calendar.index') }}"
           class="inline-flex items-center px-4 py-2 rounded text-white text-sm"
           style="background-color: var(--table-header-color)">
            <i class="fas fa-arrow-left mr-2"></i> Volver
        </a>
    </div>

    {{-- Mensajes de validación --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded shadow">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('simple_calendar.store') }}" method="POST"
          class="bg-white p-6 rounded shadow border border-[color:var(--table-header-color)]">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-medium">Nombre de la Planta</label>
            <input type="text" name="planta" required
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                placeholder="Ej: Tomate cherry">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Cantidad</label>
            <input type="number" name="cantidad" required
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                   placeholder="Ej: 30">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">ID del Plantín</label>
            <input type="number" name="plantin_id" required
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                   placeholder="Ej: 1001">
        </div>

        {{-- Fechas lado a lado --}}
        <div class="mb-4 md:flex md:space-x-4">
            <div class="md:w-1/2 mb-4 md:mb-0">
                <label class="block mb-1 font-medium">Fecha de Siembra</label>
                <input type="date" name="fecha_siembra" required
                       max="{{ now()->toDateString() }}"
                       class="w-full border rounded px-3 py-1.5 focus:outline-none focus:ring text-sm">
            </div>

            <div class="md:w-1/2">
                <label class="block mb-1 font-medium">Fecha Estimada de Trasplante</label>
                <input type="date" name="fecha_trasplante"
                       class="w-full border rounded px-3 py-1.5 focus:outline-none focus:ring text-sm">
            </div>
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('simple_calendar.index') }}"
               class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-sm">
                Cancelar
            </a>

            <button type="submit"
                    class="px-6 py-2 rounded text-white text-sm"
                    style="background-color: var(--table-header-color)">
                Guardar
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const siembraInput = document.querySelector('input[name="fecha_siembra"]');
        const trasplanteInput = document.querySelector('input[name="fecha_trasplante"]');

        // Restringir fechas máximas de siembra a hoy
        const today = new Date().toISOString().split('T')[0];
        siembraInput.setAttribute('max', today);

        // Cuando se cambia la fecha de siembra, ajustar mínimo de trasplante
        siembraInput.addEventListener('change', function () {
            trasplanteInput.min = this.value;
        });
    });
</script>
@endpush
