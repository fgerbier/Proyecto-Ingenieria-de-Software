<!----Esta vista aun no esta implementada, home tiene una parte con categorias asique lo guardaré para luego --->

@foreach($categorias as $categoria)
<li>
    <a href="{{ route('producto.filterByCategory', ['category' => $categoria->nombre]) }}"
        class="flex items-center text-blueDark hover:text-greenPrimary transition-colors">
        <span class="mr-2">•</span>
        {{ $categoria->nombre }}
    </a>
</li>
@endforeach