<section class="w-full px-4 md:px-20 py-16 bg-blueLight">
  <div class="max-w-7xl mx-auto">
    <h2 class="text-3xl font-extrabold text-blueDark mb-10 text-center">Últimos Productos agregados</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @foreach($productos as $producto)
        <a href="{{ route('products.show', $producto->slug) }}" class="group bg-white border border-greenMid rounded-xl overflow-hidden shadow hover:shadow-lg transition-shadow duration-200">
          <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden">
            <img src="{{ $producto->imagen }}" alt="{{ $producto->nombre }}" class="object-cover w-full h-48 group-hover:scale-105 transition-transform duration-300" />
          </div>
          <div class="p-4">
            <h3 class="text-lg font-semibold text-blueDark group-hover:text-greenPrimary transition-colors duration-200">
              {{ $producto->nombre }}
            </h3>
            <p class="text-sm text-blueDark mt-1">{{ Str::limit($producto->descripcion, 60) }}</p>
            <p class="mt-2 font-bold text-greenPrimary">${{ number_format($producto->precio, 0, ',', '.') }}</p>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
