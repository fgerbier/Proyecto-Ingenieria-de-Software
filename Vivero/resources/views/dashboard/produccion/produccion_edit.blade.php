@extends('layouts.dashboard')

@section('title', 'Nueva Producción')

@section('content')
@php
    $pref = Auth::user()?->preference;
    $headerColor = $pref?->table_header_color ?? '#0a2b59';
    $fontClass = match($pref?->font ?? 'roboto') {
        'inter' => 'font-inter',
        'poppins' => 'font-poppins',
        'montserrat' => 'font-[Montserrat]',
        'open-sans' => "font-['Open Sans']",
        default => 'font-roboto',
    };
@endphp

<style>
    .btn-primary {
        background-color: {{ $headerColor }};
        color: white;
    }
    .btn-primary:hover {
        background-color: #0d3a6b;
    }

    .btn-back {
        background-color: transparent;
        color: {{ $headerColor }};
    }
    .btn-back:hover {
        color: #0d3a6b;
    }

    .box-border {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
    }
</style>

<div class="py-8 px-4 md:px-8 max-w-3xl mx-auto {{ $fontClass }} text-gray-800">
    <a href="{{ route('produccion.index') }}"
       class="flex items-center btn-back mb-6 text-sm font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver al resumen de producción
    </a>

    {{-- Alerta JS: producto sin insumos --}}
    <div id="alerta-insumos" class="hidden mb-4 p-4 bg-yellow-100 border border-yellow-300 text-yellow-800 rounded shadow flex items-start space-x-2">
        <i class="fa-solid fa-triangle-exclamation mt-1"></i>
        <span id="alerta-insumos-text"></span>
    </div>

    {{-- Mensaje de error --}}
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded shadow flex items-start space-x-2">
            <i class="fa-solid fa-circle-exclamation mt-1"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded shadow flex items-start space-x-2">
            <i class="fa-solid fa-check-circle mt-1"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('produccion.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-6 box-border">
        @csrf

        <div>
            <label for="producto_id" class="block mb-1 font-semibold">Producto</label>
            <select name="producto_id" id="producto_id" class="w-full border-gray-300 rounded" required>
                <option value="">Seleccione un producto</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="cantidad" class="block mb-1 font-semibold">Cantidad a producir</label>
            <input type="number" name="cantidad" id="cantidad" min="1"
                   class="w-full border-gray-300 rounded" required>
        </div>

        {{-- Detalle dinámico de insumos --}}
        <div id="detalle-insumos" class="hidden mt-6 p-4 bg-gray-50 border rounded text-sm text-gray-700">
            <h3 class="text-lg font-semibold mb-2">Insumos requeridos por unidad:</h3>
            <ul id="lista-insumos" class="list-disc pl-6 space-y-1"></ul>

            <p id="costo-total" class="mt-4 text-green-700 font-semibold hidden">
                Costo total estimado: <span id="costo-total-valor">$0</span>
            </p>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="btn-primary px-4 py-2 rounded transition-colors text-sm">
                Registrar Producción
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productos = @json($productos->mapWithKeys(fn($p) => [
            $p->id => $p->insumos->map(fn($i) => [
                'nombre' => $i->nombre,
                'cantidad' => $i->pivot->cantidad,
                'costo' => $i->costo ?? 0
            ])
        ]));

        const form = document.querySelector('form');
        const selectProducto = document.getElementById('producto_id');
        const inputCantidad = document.getElementById('cantidad');

        const alerta = document.getElementById('alerta-insumos');
        const alertaTexto = document.getElementById('alerta-insumos-text');

        const detalleInsumos = document.getElementById('detalle-insumos');
        const listaInsumos = document.getElementById('lista-insumos');

        const costoTotal = document.getElementById('costo-total');
        const costoTotalValor = document.getElementById('costo-total-valor');

        function mostrarDetalleInsumos(productoId) {
            listaInsumos.innerHTML = '';
            costoTotal.classList.add('hidden');
            costoTotalValor.textContent = '$0';

            const insumos = productos[productoId] ?? [];

            if (insumos.length > 0) {
                insumos.forEach(insumo => {
                    const li = document.createElement('li');
                    li.textContent = `${insumo.nombre}: ${insumo.cantidad} unidad(es) – $${Number(insumo.costo).toLocaleString()}`;
                    listaInsumos.appendChild(li);
                });
                detalleInsumos.classList.remove('hidden');
                calcularCostoEstimado();
            } else {
                detalleInsumos.classList.add('hidden');
            }
        }

        function calcularCostoEstimado() {
            const productoId = selectProducto.value;
            const cantidad = parseInt(inputCantidad.value);
            const insumos = productos[productoId] ?? [];

            if (!productoId || isNaN(cantidad) || cantidad < 1 || insumos.length === 0) {
                costoTotal.classList.add('hidden');
                costoTotalValor.textContent = '$0';
                return;
            }

            let total = 0;
            insumos.forEach(insumo => {
                total += insumo.cantidad * insumo.costo * cantidad;
            });

            costoTotalValor.textContent = `$${Number(total).toLocaleString()}`;
            costoTotal.classList.remove('hidden');
        }

        form.addEventListener('submit', function (e) {
            const productoId = selectProducto.value;

            if (!productoId || !productos[productoId] || productos[productoId].length === 0) {
                e.preventDefault();
                alertaTexto.textContent = '⚠️ El producto seleccionado no tiene insumos asociados. No se puede producir.';
                alerta.classList.remove('hidden');
                alerta.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                alerta.classList.add('hidden');
            }
        });

        selectProducto.addEventListener('change', function () {
            alerta.classList.add('hidden');
            mostrarDetalleInsumos(this.value);
        });

        inputCantidad.addEventListener('input', function () {
            calcularCostoEstimado();
        });
    });
</script>
@endsection
