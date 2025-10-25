<form action="{{ route('pedidos.update', $pedido->id) }}" method="POST" class="flex items-center gap-2" onclick="event.stopPropagation();">
    @csrf
    @method('PUT')

    @php $estados = $pedido->estadosPermitidos(); @endphp

    @if (!empty($estados))
        <select name="estado_pedido"
                class="rounded border border-efore-400 px-2 py-1 text-sm bg-white text-eprimary focus:ring-2 focus:ring-eaccent2-500">
            @foreach ($estados as $valor => $texto)
                <option value="{{ $valor }}" @selected($pedido->estado_pedido === $valor)>{{ $texto }}</option>
            @endforeach
        </select>
    @else
        <span class="text-red-500 text-sm">Método de entrega no reconocido</span>
    @endif

    <button type="submit"
            class="bg-eaccent2 hover:bg-eaccent2-400 text-eprimary font-semibold px-3 py-1 rounded shadow transition text-sm">
        Guardar
    </button>
</form>
