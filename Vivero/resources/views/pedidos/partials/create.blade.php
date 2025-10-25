@extends('layouts.dashboard')

@section('title', isset($pedido->id) ? 'Editar Venta' : 'Nueva Venta')

@section('content')

<div class="py-8 px-4 md:px-8 max-w-5xl mx-auto">

    <div class="flex items-center mb-6">
    <a href="{{ route('pedidos.index') }}"
       class="flex items-center text-white px-3 py-1 rounded transition-colors"
       style="background-color: var(--table-header-color);">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6" />
        </svg>
        Volver a la lista
    </a>
</div>

    <form action="{{ isset($pedido->id) ? route('pedidos.update', $pedido->id) : route('pedidos.store') }}"
        method="POST" id="pedido-form" class="space-y-6">
        @csrf
        @if(isset($pedido->id))
            @method('PUT')
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">Información de la Venta</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="metodo-entrega" class="block text-sm font-medium text-gray-700 mb-1">
                        Método de Entrega <span class="text-red-500">*</span>
                    </label>
                    <select name="metodo_entrega" id="metodo-entrega"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        required>
                        <option value="retiro" {{ (old('metodo_entrega', $pedido->metodo_entrega ?? '') == 'retiro') ? 'selected' : '' }}>
                            Retiro en tienda
                        </option>
                        <option value="domicilio" {{ (old('metodo_entrega', $pedido->metodo_entrega ?? '') == 'domicilio') ? 'selected' : '' }}>
                            Entrega a domicilio
                        </option>
                    </select>
                </div>

                <div>
                    <label for="estado_pedido" class="block text-sm font-medium text-gray-700 mb-1">
                        Estado del Pedido <span class="text-red-500">*</span>
                    </label>
                    <select name="estado_pedido"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        required>
                        <option value="pendiente" {{ (old('estado_pedido', $pedido->estado_pedido ?? '') == 'pendiente') ? 'selected' : '' }}>
                            Pendiente
                        </option>
                        <option value="en_preparacion" {{ (old('estado_pedido', $pedido->estado_pedido ?? '') == 'en_preparacion') ? 'selected' : '' }}>
                            En preparación
                        </option>
                        <option value="entregado" {{ (old('estado_pedido', $pedido->estado_pedido ?? '') == 'entregado') ? 'selected' : '' }}>
                            Entregado
                        </option>
                    </select>
                </div>
            </div>

            <div id="direccion-contenedor" class="mt-6 {{ (old('metodo_entrega', $pedido->metodo_entrega ?? '') == 'domicilio') ? '' : 'hidden' }}">
                <label for="direccion_entrega" class="block text-sm font-medium text-gray-700 mb-1">Dirección de entrega</label>
                <textarea name="direccion_entrega" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    placeholder="Ej: Calle 123, Depto 4B, Comuna...">{{ old('direccion_entrega', $pedido->direccion_entrega ?? '') }}</textarea>
            </div>
        </div>


        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">Detalle del Pedido</h2>

            <div id="detalle-container" class="space-y-4">
                @if(isset($pedido) && $pedido->detalles->count() > 0)
                    @foreach($pedido->detalles as $detalle)
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end relative">
                        <div class="relative">
                            <label class="text-sm text-gray-700">Producto</label>
                            <input type="text" class="producto-nombre w-full rounded-md border border-gray-300 shadow-sm"
                                placeholder="Buscar producto..." autocomplete="off" required
                                value="{{ old('producto_nombre', $detalle->nombre_producto_snapshot) }}">
                            <input type="hidden" name="producto_id[]" class="producto-id" value="{{ old('producto_id[]', $detalle->producto_id) }}">
                            <ul class="sugerencias absolute bg-white border border-gray-300 rounded mt-1 w-full max-h-40 overflow-y-auto hidden z-10"></ul>
                        </div>

                        <div>
                            <label class="text-sm text-gray-700">Cantidad</label>
                            <input type="number" name="cantidad[]" class="cantidad-input w-full rounded-md border border-gray-300 shadow-sm"
                                min="1" value="{{ old('cantidad[]', $detalle->cantidad) }}" required>
                        </div>

                        <div>
                            <label class="text-sm text-gray-700">Precio Unitario</label>
                            <input type="number" name="precio_unitario[]" step="0.01"
                                class="precio-input w-full rounded-md border border-gray-300 shadow-sm bg-gray-100" readonly
                                value="{{ old('precio_unitario[]', $detalle->precio_unitario) }}">
                        </div>

                        <div>
                            <label class="text-sm text-gray-700">Subtotal</label>
                            <input type="number" step="0.01"
                                class="subtotal-input w-full rounded-md border border-gray-300 shadow-sm bg-gray-100" readonly
                                value="{{ old('subtotal[]', $detalle->subtotal) }}">
                        </div>

                        <button type="button"
                            class="remove-row text-red-600 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 rounded transition"
                            title="Eliminar producto" aria-label="Eliminar producto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                            </svg>
                        </button>
                    </div>
                    @endforeach
                @else
                    {{-- Si no hay detalles, mostrar una fila vacía para agregar --}}
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end relative">
                        <div class="relative">
                            <label class="text-sm text-gray-700">Producto</label>
                            <input type="text" class="producto-nombre w-full rounded-md border border-gray-300 shadow-sm"
                                placeholder="Buscar producto..." autocomplete="off" required>
                            <input type="hidden" name="producto_id[]" class="producto-id">
                            <ul class="sugerencias absolute bg-white border border-gray-300 rounded mt-1 w-full max-h-40 overflow-y-auto hidden z-10"></ul>
                        </div>

                        <div>
                            <label class="text-sm text-gray-700">Cantidad</label>
                            <input type="number" name="cantidad[]" class="cantidad-input w-full rounded-md border border-gray-300 shadow-sm"
                                min="1" value="1" required>
                        </div>

                        <div>
                            <label class="text-sm text-gray-700">Precio Unitario</label>
                            <input type="number" name="precio_unitario[]" step="0.01"
                                class="precio-input w-full rounded-md border border-gray-300 shadow-sm bg-gray-100" readonly>
                        </div>

                        <div>
                            <label class="text-sm text-gray-700">Subtotal</label>
                            <input type="number" step="0.01"
                                class="subtotal-input w-full rounded-md border border-gray-300 shadow-sm bg-gray-100" readonly>
                        </div>

                        <button type="button"
                            class="remove-row text-red-600 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 rounded transition"
                            title="Eliminar producto" aria-label="Eliminar producto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" id="add-detalle"
                    class="flex items-center text-white px-3 py-1 rounded transition-colors"
                    style="background-color: var(--table-header-color);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    Agregar producto
                </button>
            </div>

        </div>
        <div class="bg-white rounded-lg shadow-md p-6 space-y-6">
            <div>
                <label for="descuento_porcentaje" class="block text-sm font-medium text-gray-700 mb-1">Descuento (%)</label>
                <input type="number" name="descuento_porcentaje" min="0" max="100" step="0.01"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    placeholder="Ej: 10" value="{{ old('descuento_porcentaje', isset($pedido) ? round(($pedido->descuento / max($pedido->subtotal, 1)) * 100, 2) : '') }}">
                <small class="text-gray-500">Ingresa un número entre 0 y 100. Ej: 10 para 10% de descuento.</small>
            </div>
            <div>
                <label for="forma_pago" class="block text-sm font-medium text-gray-700 mb-1">Forma de Pago</label>
                <select name="forma_pago"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    required>
                    <option value="efectivo" {{ old('forma_pago', $pedido->forma_pago ?? '') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="tarjeta" {{ old('forma_pago', $pedido->forma_pago ?? '') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                    <option value="transferencia" {{ old('forma_pago', $pedido->forma_pago ?? '') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                </select>
            </div>

            <div>
                <label for="estado_pago" class="block text-sm font-medium text-gray-700 mb-1">Estado del Pago</label>
                <select name="estado_pago"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    required>
                    <option value="pendiente" {{ old('estado_pago', $pedido->estado_pago ?? '') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="pagado" {{ old('estado_pago', $pedido->estado_pago ?? '') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                </select>
            </div>

            <div>
                <label for="tipo_documento" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Documento</label>
                <select name="tipo_documento"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    required>
                    <option value="boleta" {{ old('tipo_documento', $pedido->tipo_documento ?? '') == 'boleta' ? 'selected' : '' }}>Boleta</option>
                    <option value="factura" {{ old('tipo_documento', $pedido->tipo_documento ?? '') == 'factura' ? 'selected' : '' }}>Factura</option>
                </select>
            </div>
            <div>
                <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                <textarea name="observaciones" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    placeholder="Opcional">{{ old('observaciones', $pedido->observaciones ?? '') }}</textarea>
            </div>
        </div>
        <div class="flex justify-end space-x-4">
            <a href="{{ route('pedidos.index') }}"
                class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                Cancelar
            </a>
            <button type="submit"
                class="flex items-center text-white px-3 py-1 rounded transition-colors"
                style="background-color: var(--table-header-color);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                {{ isset($pedido->id) ? 'Actualizar' : 'Guardar' }} Pedido
            </button>
        </div>
    </form>
</div>

<script>
    const productos = @json($productos);

    document.addEventListener('DOMContentLoaded', () => {
        const metodoSelect = document.getElementById('metodo-entrega');
        const direccionContenedor = document.getElementById('direccion-contenedor');

        metodoSelect.addEventListener('change', () => {
            direccionContenedor.classList.toggle('hidden', metodoSelect.value !== 'domicilio');
        });

        function configurarBuscadores() {
            document.querySelectorAll('.producto-nombre').forEach((input) => {
                const contenedor = input.closest('.relative');
                const hiddenId = contenedor.querySelector('.producto-id');
                const lista = contenedor.querySelector('.sugerencias');

                function mostrarResultados(texto) {
                    const filtrados = texto ? productos.filter(p => p.nombre.toLowerCase().includes(texto)).slice(0, 10) : productos.slice(0, 20);

                    lista.innerHTML = '';
                    filtrados.forEach(producto => {
                        const li = document.createElement('li');
                        li.textContent = producto.nombre;
                        li.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';
                        li.addEventListener('click', () => {
                            input.value = producto.nombre;
                            hiddenId.value = producto.id;
                            lista.classList.add('hidden');

                            const fila = input.closest('.grid');
                            if (fila) {
                                const precio = fila.querySelector('.precio-input');
                                const cantidad = fila.querySelector('.cantidad-input');
                                const subtotal = fila.querySelector('.subtotal-input');

                                precio.value = parseFloat(producto.precio).toFixed(2);
                                subtotal.value = (cantidad.value * producto.precio).toFixed(2);
                            }
                        });
                        lista.appendChild(li);
                    });
                    lista.classList.remove('hidden');
                }

                input.addEventListener('input', () => {
                    mostrarResultados(input.value.toLowerCase());
                });

                input.addEventListener('focus', () => {
                    mostrarResultados(input.value.toLowerCase());
                });

                input.addEventListener('blur', () => {
                    setTimeout(() => lista.classList.add('hidden'), 150);
                });
            });
        }

        function bindEvents(row) {
            row.querySelector('.cantidad-input').addEventListener('input', () => {
                const precio = parseFloat(row.querySelector('.precio-input').value || 0);
                const cantidad = parseInt(row.querySelector('.cantidad-input').value || 1);
                row.querySelector('.subtotal-input').value = (precio * cantidad).toFixed(2);
            });

            const removeBtn = row.querySelector('.remove-row');
            removeBtn.addEventListener('click', () => row.remove());

            if (document.querySelectorAll('#detalle-container .grid').length > 1) {
                removeBtn.classList.remove('hidden');
            } else {
                removeBtn.classList.add('hidden');
            }
        }

        document.querySelectorAll('#detalle-container .grid').forEach(row => {
            bindEvents(row);
        });

        configurarBuscadores();

        document.getElementById('add-detalle').addEventListener('click', () => {
            const container = document.getElementById('detalle-container');
            const firstRow = container.querySelector('.grid');
            const newRow = firstRow.cloneNode(true);

            newRow.querySelectorAll('input').forEach(input => {
                if (!input.classList.contains('producto-id')) input.value = '';
                if (input.classList.contains('cantidad-input')) input.value = 1;
            });

            container.appendChild(newRow);
            bindEvents(newRow);
            configurarBuscadores();
        });
    });
    document.getElementById('pedido-form').addEventListener('submit', function(e) {
        const productosIds = document.querySelectorAll('.producto-id');
        let valido = true;

        productosIds.forEach(id => {
            if (!id.value) {
                valido = false;
            }
        });

        if (!valido) {
            alert('Debes seleccionar los productos desde la lista desplegable. No escribas el nombre manualmente.');
            e.preventDefault();
        }
    });
</script>
@endsection