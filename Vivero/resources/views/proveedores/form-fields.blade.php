@php
    $proveedor = $proveedor ?? new \App\Models\Proveedor();
@endphp

<div class="bg-white rounded-lg shadow-md p-6 space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Empresa</label>
            <input type="text" name="empresa" value="{{ old('empresa', $proveedor->empresa) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                @error('empresa')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', $proveedor->email) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
            <input
                type="tel"
                name="telefono"
                pattern="^(?=(?:.*\d){8,})[\d\s\+\-\(\)]+$"
                title="Ingrese un teléfono válido con al menos 8 números, sin letras."
                value="{{ old('telefono', $proveedor->telefono) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Tipo de Proveedor</label>
            <select name="tipo_proveedor" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                <option value="">Seleccionar</option>
                @foreach(['Sustratos', 'Productos aplicables', 'Herramientas', 'Servicios Vivero', 'Construccion', 'Plantas', 'Arboles', 'Plasticos/Cerámicas', 'Plantines', 'Varios'] as $tipo)
                    <option value="{{ $tipo }}" {{ old('tipo_proveedor', $proveedor->tipo_proveedor) == $tipo ? 'selected' : '' }}>
                        {{ $tipo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Estado</label>
            <select name="estado" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                @foreach(['Activo', 'Inactivo'] as $estado)
                    <option value="{{ $estado }}" {{ old('estado', $proveedor->estado) == $estado ? 'selected' : '' }}>
                        {{ $estado }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Dirección</label>
        <textarea name="direccion" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    placeholder="Ej: Calle 123, Depto 4B, Comuna...">{{ old('direccion', $pedido->direccion ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Notas</label>
        <textarea name="notas" rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('notas', $proveedor->notas) }}</textarea>
    </div>
</div>
