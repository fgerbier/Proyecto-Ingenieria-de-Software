@extends('layouts.dashboard')

@section('title', 'Reportar Ventas del Mes')

@section('content')
<div x-data="modalVentas" class="py-8 px-4 md:px-8 max-w-3xl mx-auto font-['Roboto'] text-gray-800">

    <a href="{{ route('dashboard.finanzas') }}" class="flex items-center text-green-700 hover:text-green-800 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
        </svg>
        Volver al Resumen Financiero
    </a>

    <h2 class="text-2xl font-semibold mb-6">Reportar Ventas Mensuales</h2>

    <form @submit.prevent="enviarReporte" class="space-y-6 bg-white p-6 rounded-lg shadow">

        {{-- Mes --}}
        <div>
            <label for="mes" class="block text-sm font-medium mb-1">Mes a Reportar</label>
            <input type="month" id="mes" x-model="mes" @change="obtenerResumenVentas"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500"
                   required>
        </div>

        {{-- Resumen dinámico --}}
        <div x-show="resumen" class="p-4 border border-gray-200 bg-gray-50 rounded text-sm text-gray-700 space-y-2">
            <p><strong>Pedidos totales:</strong> <span x-text="resumen.cantidad"></span></p>
            <p><strong>Total vendido:</strong> $<span x-text="resumen.total.toLocaleString('es-CL')"></span></p>
        </div>

        {{-- Descripción --}}
        <div>
            <label for="descripcion" class="block text-sm font-medium mb-1">Descripción</label>
            <textarea x-model="descripcion" rows="3"
                      class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500"
                      placeholder="Ej: Ingreso correspondiente a ventas de mayo"></textarea>
        </div>

        {{-- Botones de acción --}}
<div class="flex justify-end space-x-2">
    <button type="submit"
            class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
        Guardar
    </button>

    <template x-if="resumen">
       <a :href="`/finanzas/ventas/pdf?mes=${mes}`" target="_blank"
   class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition flex items-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
         stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M7 10l5 5 5-5M12 15V3"/>
    </svg>
    Descargar PDF
</a>
    </template>
</div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('modalVentas', () => ({
            mes: '',
            resumen: null,
            descripcion: '',

            async obtenerResumenVentas() {
                if (!this.mes) return;
                this.resumen = null;

                try {
                    const response = await fetch(`/api/ventas/resumen?mes=${this.mes}`);
                    if (!response.ok) throw new Error('No se pudo obtener el resumen');
                    const data = await response.json();
                    this.resumen = data;
                } catch (e) {
                    console.error('Error al obtener resumen:', e);
                    alert('No se pudo obtener el resumen de ventas del mes.');
                }
            },

            async enviarReporte() {
                if (!this.mes || !this.resumen) {
                    alert('Debes seleccionar un mes válido y esperar el resumen.');
                    return;
                }

                try {
                    const response = await fetch(`/finanzas/reportar-ventas`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            mes: this.mes,
                            descripcion: this.descripcion,
                            total: this.resumen.total,
                            cantidad: this.resumen.cantidad
                        })
                    });

                    if (response.status === 409) {
                        const data = await response.json();
                        alert(data.message);
                        return;
                    }

                    if (!response.ok) throw new Error('Respuesta no exitosa');

                    location.assign("{{ route('dashboard.finanzas') }}");

                } catch (e) {
                    console.error('Error al guardar:', e);
                    alert('Error al guardar el ingreso.');
                }
            }
        }));
    });
</script>
@endpush
