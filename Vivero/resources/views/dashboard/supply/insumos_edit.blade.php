@extends('layouts.dashboard')

@section('title', isset($insumo->id) ? 'Editar Insumo' : 'Nuevo Insumo')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-4xl mx-auto font-['Roboto'] text-gray-800">
    {{-- Botón volver --}}
    <div class="mb-6">
        <a href="{{ route('dashboard.insumos') }}"
           class="inline-flex items-center text-white px-4 py-2 rounded transition-colors shadow text-sm font-medium"
           style="background-color: var(--table-header-color);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>
            Volver a la lista
        </a>
    </div>

    <form x-ref="form"
          action="{{ isset($insumo->id) ? route('insumos.update', $insumo->id) : route('insumos.store') }}"
          method="POST"
          @submit.prevent="validarFormulario"
          x-data="insumoForm()"
          x-init="initDetalles(
                @json(isset($insumo) ? $insumo->detalles : []),
                @json(isset($insumo) ? $insumo->productos->pluck('id') : [])
            )">
        
        @csrf
        @if(isset($insumo->id)) @method('PUT') @endif

        {{-- Información básica --}}
        <div class="bg-white p-6 rounded-lg shadow space-y-4">
            <h2 class="text-xl font-['Roboto_Condensed'] text-gray-900">Información del Insumo</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" id="nombre"
                           x-model="nombreInsumo"
                           value="{{ old('nombre', $insumo->nombre ?? '') }}"
                           class="mt-1 block w-full border rounded px-3 py-2"
                           required>
                </div>

                <div>
                    <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad Total</label>
                    <input type="number" name="cantidad" id="cantidad" min="0" x-model.number="cantidadTotal"
                           value="{{ old('cantidad', $insumo->cantidad ?? 0) }}"
                           class="mt-1 block w-full border rounded px-3 py-2"
                           required>
                </div>
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                          class="mt-1 block w-full border rounded px-3 py-2">{{ old('descripcion', $insumo->descripcion ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Asociar a productos</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-60 overflow-y-auto border p-3 rounded-lg">
                    @foreach ($productos as $producto)
                        <label class="flex items-center space-x-2 text-sm text-gray-800">
                            <input type="checkbox"
                                   name="productos[]"
                                   :value="{{ $producto->id }}"
                                   x-model="productosSeleccionados"
                                   class="text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <span>{{ $producto->nombre }}</span>
                        </label>
                    @endforeach
                </div>
                <p class="text-xs text-gray-500 mt-1">Selecciona los productos donde se usará este insumo.</p>
            </div>
        </div>

        {{-- Subdetalles --}}
        <div class="bg-white p-6 rounded-lg shadow mt-6 space-y-4">
            <h2 class="text-xl font-['Roboto_Condensed'] text-gray-900">Subdetalles del Insumo</h2>

            <template x-for="(detalle, index) in detalles" :key="index">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 border p-4 rounded-md">
                    <div>
                        <label class="text-sm">Nombre</label>
                        <input type="text" :name="'detalles['+index+'][nombre]'" x-model="detalle.nombre"
                               class="w-full border rounded px-2 py-1" required @keydown.enter.prevent>
                    </div>
                    <div>
                        <label class="text-sm">Cantidad</label>
                        <input type="number" :name="'detalles['+index+'][cantidad]'" x-model.number="detalle.cantidad"
                               @input="recalcularCantidad()" min="0" class="w-full border rounded px-2 py-1" required @keydown.enter.prevent>
                    </div>
                    <div>
                        <label class="text-sm">Costo</label>
                        <div class="relative">
                            <span class="absolute left-2 top-1.5 text-gray-500 text-sm">$</span>
                            <input type="number" :name="'detalles['+index+'][costo]'" x-model.number="detalle.costo"
                                   min="0" class="w-full border rounded pl-6 pr-2 py-1" required @keydown.enter.prevent>
                        </div>
                    </div>
                    <div class="flex items-end">
                        <button type="button" @click="eliminarDetalle(index)"
                                class="w-full px-3 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700"
                                title="Eliminar este subdetalle">
                            Eliminar
                        </button>
                    </div>
                </div>
            </template>

            <button type="button" @click="detalles.push({ nombre: '', cantidad: 0, costo: 0 })"
                class="inline-flex items-center text-sm text-green-600 hover:underline">
                + Añadir subdetalle
            </button>

            <template x-if="mensajeError">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative text-sm mt-2">
                    <span x-text="mensajeError"></span>
                </div>
            </template>

            <p class="text-sm text-gray-700 mt-2">
                Costo total estimado: <span class="font-semibold" x-text="calcularCostoTotal() + ' CLP'"></span>
            </p>
        </div>

        {{-- Botones --}}
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('dashboard.insumos') }}"
               class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit"
                    class="px-4 py-2 text-white rounded hover:opacity-90 transition-colors shadow text-sm font-medium"
                    style="background-color: var(--table-header-color);">
                {{ isset($insumo->id) ? 'Actualizar' : 'Guardar' }} Insumo
            </button>
        </div>
    </form>
</div>

<script>
function insumoForm() {
    return {
        cantidadTotal: {{ old('cantidad', $insumo->cantidad ?? 0) }},
        nombreInsumo: '{{ old('nombre', $insumo->nombre ?? '') }}',
        detalles: [],
        productosSeleccionados: [],
        mensajeError: '',

        initDetalles(detallesIniciales, productosIniciales) {
            this.detalles = detallesIniciales.length ? detallesIniciales : [];
            this.productosSeleccionados = productosIniciales.length ? productosIniciales : [];

            if (!this.detalles.length && this.cantidadTotal >= 1) {
                this.agregarDetalleInicial();
            }
        },

        agregarDetalleInicial() {
            let sugerencia = 'Unidad';
            const nombre = this.nombreInsumo.toLowerCase();
            if (nombre.includes('fertilizante')) sugerencia = 'Saco de 25 kg';
            else if (nombre.includes('maceta')) sugerencia = 'Maceta plástica';
            else if (nombre.includes('sustrato')) sugerencia = 'Bolsa 5L';
            else if (nombre.includes('pala')) sugerencia = 'Pala chica';

            this.detalles.push({ nombre: sugerencia, cantidad: 0, costo: 0 });
        },

        eliminarDetalle(index) {
            this.detalles.splice(index, 1);
            this.recalcularCantidad();
        },

        recalcularCantidad() {
            const suma = this.detalles.reduce((acc, d) => acc + (parseInt(d.cantidad) || 0), 0);
            this.mensajeError = suma > this.cantidadTotal
                ? 'La suma de subcantidades no puede superar la cantidad total.'
                : '';
            if (this.detalles.length === 0 && this.cantidadTotal >= 1) {
                this.agregarDetalleInicial();
            }
        },

        calcularCostoTotal() {
            return this.detalles.reduce((acc, d) => acc + ((parseInt(d.costo) || 0) * (parseInt(d.cantidad) || 0)), 0);
        },

        validarFormulario() {
            if (this.cantidadTotal <= 0) {
                this.mensajeError = 'La cantidad total debe ser mayor que cero.';
                return;
            }

            if (this.detalles.length === 0) {
                this.mensajeError = 'Debes agregar al menos un subdetalle.';
                return;
            }

            let subdetalleValido = this.detalles.some(d =>
                d.nombre && d.cantidad > 0 && d.costo >= 0
            );

            if (!subdetalleValido) {
                this.mensajeError = 'Debes completar al menos un subdetalle correctamente.';
                return;
            }

            if (!document.querySelector('input[name="_token"]')) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = '_token';
                input.value = '{{ csrf_token() }}';
                this.$refs.form.appendChild(input);
            }
            if (this.mensajeError) return;

            this.$refs.form.submit();
        }
    };
}
</script>
@endsection
