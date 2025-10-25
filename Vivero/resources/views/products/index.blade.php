@extends('layouts.home')
@section('title', 'Productos || Plantas Editha')
@section('description', 'Nuestra tienda ofrece una amplia variedad de plantas de interior y exterior, ideales para cualquier espacio. Desde suculentas hasta plantas de sombra, tenemos lo que necesitas para embellecer tu hogar o jardín. Además, contamos con un equipo de expertos listos para asesorarte en el cuidado y mantenimiento de tus plantas.')
@section('content')

<!-- Banner principal -->
<div class="relative w-full h-64 md:h-96 bg-greenPrimary overflow-hidden">
    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
        <div class="text-center px-4">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">Nuestros Productos</h1>
            <p class="text-xl md:text-2xl text-white max-w-2xl mx-auto">Descubre nuestra selección de plantas para todos los espacios y niveles de cuidado</p>
        </div>
    </div>
    <img src="{{ asset('/storage/images/banner-productos.jpg') }}" alt="Variedad de plantas" class="w-full h-full object-cover">
</div>

<!-- Contenedor principal -->
<div class="container mx-auto px-4 py-12">
    <div class="flex flex-col md:flex-row gap-8">

        <!-- Aside de filtros -->
        <aside class="w-full md:w-1/4 lg:w-1/5">
            <form id='filter-form'>

            <div class="bg-white p-6 rounded-lg shadow-md sticky top-4">
                <h2 class="text-xl font-bold text-blueDark mb-6 border-b pb-2">Filtrar Productos</h2>
                <!-- Filtro por categoría -->
                <div class="mb-6">
                    <h3 class="font-semibold text-greenDark mb-2">Categorías</h3>
                    <ul class="space-y-2 list-none" id="categorias-container">
                        @foreach($categorias as $categoria)
                        <li>
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox"
                                    name="categorias[]"
                                    id="categoria_{{ $categoria->id }}"
                                    value="{{ $categoria->id }}"
                                    class="mr-2 h-4 w-4 text-greenPrimary rounded border-gray-300 focus:ring-greenPrimary transition"
                                    {{ $categoria->selected ? 'checked' : '' }}
                                    data-category-id="{{ $categoria->id }}">
                                <span class="flex items-center text-blueDark group-hover:text-greenPrimary transition-colors">

                                    {{ $categoria->nombre }}

                                </span>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Filtro por tamaño -->
                <div class="mb-6">
                    <h3 class="font-semibold text-greenDark mb-2">Tamaño máximo (cm)</h3>
                    <input type="range" id="tamano" name="tamano" min="10" max="200"
                        value="{{ $tamano ?? 200 }}"
                        class="w-full h-2 bg-greenMid rounded-lg cursor-pointer">
                    <div class="flex justify-between text-sm text-blueDark mt-1">
                        <span>10cm</span>
                        <span id="tamanoValue">{{ $tamano ?? 200 }}cm</span>
                        <span>200cm</span>
                    </div>
                </div>

                <!-- Filtro por dificultad -->
                <div class="mb-6">
                    <h3 class="font-semibold text-greenDark mb-2">Nivel de dificultad</h3>
                    <select name="dificultad" id="dificultad" class="w-full p-2 border border-greenMid rounded-lg text-blueDark">
                        <option value="">Todos los niveles</option>
                        <option value="facil" {{ $dificultad == 'baja' ? 'selected' : '' }}>Fácil</option>
                        <option value="intermedia" {{ $dificultad == 'media' ? 'selected' : '' }}>Intermedia</option>
                        <option value="experto" {{ $dificultad == 'alta' ? 'selected' : '' }}>Experto</option>
                    </select>
                </div>

                <!-- Filtro de orden -->
                <div class="mb-6">
                    <h3 class="font-semibold text-greenDark mb-2">Ordenar por</h3>
                    <select name="filter2" id="filter2" class="w-full p-2 border border-greenMid rounded-lg text-blueDark">
                        <option value="relevancia" {{ $ordenar_por == 'relevancia' ? 'selected' : '' }}>Relevancia</option>
                        <option value="precio" {{ $ordenar_por == 'precio' ? 'selected' : '' }}>Precio</option>
                        <option value="popularidad" {{ $ordenar_por == 'popularidad' ? 'selected' : '' }}>Popularidad</option>
                    </select>
                    <div class="mt-2 flex items-center">
                        <input type="radio" id="ascendente" name="filter3" value="ascendente"
                            {{ $ordenar_ascendente ? 'checked' : '' }} class="mr-2">
                        <label for="ascendente" class="text-sm text-blueDark">Ascendente</label>
                        <input type="radio" id="descendente" name="filter3" value="descendente"
                            {{ !$ordenar_ascendente ? 'checked' : '' }} class="ml-4 mr-2">
                        <label for="descendente" class="text-sm text-blueDark">Descendente</label>
                    </div>
                </div>

                <button id="aplicarFiltros" class="w-full py-2 bg-greenPrimary text-white rounded-lg hover:bg-greenDark transition-colors">
                    Aplicar Filtros
                </button>
            </div>

            </form>
        </aside>

        <!-- Sección de productos -->
        <div class="w-full md:w-3/4 lg:w-4/5">
            @if($productos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($productos as $producto)
                                    <!-- Tarjeta de producto -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow flex flex-col h-full">
                    <a href="{{ route('products.show', $producto->slug) }}" class="block">
                        <div class="h-48 overflow-hidden">
                            <img src="{{ asset('storage/images/product' . $producto->imagen_principal) }}"
                                onerror="this.onerror=null;this.src='storage/images/default-logo.png';this.className='w-3/5 h-full justify-self-center align-self-center scale-95 opacity-50 hover:scale-100 transition-transform duration-300';"
                                alt="{{ $producto->nombre }}"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        </div>
                    </a>

                    <!-- Contenido principal con botones al fondo -->
                    <div class="p-4 flex flex-col justify-between flex-grow">
                        <!-- Nombre y precio -->
                        <div>
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-semibold text-blueDark py-2">{{ $producto->nombre }}</h3>
                                <span class="text-greenPrimary font-bold py-2">{{ number_format($producto->precio, 0, ',', '.') }} CLP</span>
                            </div>

                            <div class="flex items-center mt-2">
                                <span class="text-sm text-blueDark bg-blueLight px-2 py-1 rounded mr-2">
                                    {{ $producto->nivel_dificultad }}
                                </span>
                                <span class="text-sm text-blueDark">{{ $producto->tamano }}cm</span>
                            </div>

                            <p class="text-blueDark mt-2 line-clamp-2">{{ $producto->descripcion_corta }}</p>
                        </div>

                        <!-- Botones -->
                        <div class="mt-4">
                            <a href="{{ route('products.show', $producto->slug) }}">
                                <button class="w-full py-2 bg-greenPrimary text-white rounded-lg hover:bg-greenDark transition-colors">
                                    Ver detalles
                                </button>
                            </a>

                            <div class="flex items-center justify-between mt-4 space-x-2 flex-wrap">
                                @if($producto->stock > 0)
                                    <div class="flex items-center border border-greenMid rounded-lg overflow-hidden bg-blueLight">
                                        <button type="button"
                                            class="px-2 py-1 text-greenPrimary hover:bg-greenPrimary hover:text-white transition"
                                            onclick="this.nextElementSibling.stepDown()">
                                            −
                                        </button>
                                        <input type="number"
                                            id="cantidad_{{ $producto->id }}"
                                            min="1"
                                            max="99"
                                            value="1"
                                            class="w-12 text-center bg-white text-blueDark border-0 focus:ring-0 focus:outline-none appearance-none"
                                            aria-label="Cantidad">
                                        <button type="button"
                                            class="px-2 py-1 text-greenPrimary hover:bg-greenPrimary hover:text-white transition"
                                            onclick="this.previousElementSibling.stepUp()">
                                            +
                                        </button>
                                    </div>
                                @endif

                                @auth
                                    @if($producto->stock == 0)
                                        <button
                                            class="flex-1 py-2 bg-red-500 text-white rounded-lg cursor-not-allowed"
                                            disabled>
                                            Producto sin Stock
                                        </button>
                                    @else
                                        <button
                                            class="flex-1 py-2 bg-blueLight text-blueDark rounded-lg hover:bg-blueDark hover:text-white transition-colors"
                                            onclick="agregarAlCarrito({{ $producto->id }})">
                                            Agregar al carrito
                                        </button>
                                    @endif
                                    <button
                                        class="py-2 bg-yellow-300 text-blueDark rounded-lg hover:bg-yellow-400 transition-colors"
                                        onclick="agregarACotizacion({{ $producto->id }})">
                                        <i class="fas fa-file-invoice-dollar p-2">Cotizar</i>
                                    </button>
                                @endauth

                                @guest
                                    <a href="{{ route('login') }}"
                                        class="flex-1 block text-center py-2 bg-blueLight text-blueDark rounded-lg hover:bg-blueDark hover:text-white transition-colors">
                                        Agregar al carrito
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-8">
                {{ $productos->links() }}
            </div>
            @else
            <div class="text-center py-12">
                <h3 class="text-xl font-semibold text-blueDark">No se encontraron productos</h3>
                <p class="text-blueDark mt-2">Intenta ajustar tus filtros de búsqueda</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tamanoSlider = document.getElementById('tamano');
        const tamanoValue = document.getElementById('tamanoValue');
        const aplicarFiltrosBtn = document.getElementById('aplicarFiltros');
        const filterForm = document.getElementById('filter-form'); // Agrega este ID a tu formulario

        if (tamanoSlider && tamanoValue) {
            // Establecer valor inicial
            tamanoValue.textContent = `${tamanoSlider.value}cm`;

            // Evento para cambios
            tamanoSlider.addEventListener('input', function() {
                tamanoValue.textContent = `${this.value}cm`;
            });
        }

        if (aplicarFiltrosBtn) {
            aplicarFiltrosBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Crear objeto URLSearchParams para manejar parámetros
                const params = new URLSearchParams();

                // Obtener valores de los filtros
                const getFilterValue = (name) => {
                    const element = document.querySelector(`[name="${name}"]`);
                    return element ? element.value : null;
                };

                // Agregar filtros solo si tienen valor
                const filters = {
                    tamano: getFilterValue('tamano'),
                    categorias: Array.from(document.querySelectorAll('input[name="categorias[]"]:checked'))
                                .map(input => input.value)
                                .join(','),
                    dificultad: getFilterValue('dificultad'),
                    filter2: getFilterValue('filter2'),
                    filter3: document.querySelector('input[name="filter3"]:checked')?.value
                };

                // Construir parámetros de URL
                Object.entries(filters).forEach(([key, value]) => {
                    if (value && value !== 'null') {
                        params.append(key, value);
                    }
                });

                // Redireccionar con los filtros aplicados
                const baseUrl = '{{ route("products.index") }}';
                window.location.href = `${baseUrl}?${params.toString()}`;
            });
        }

        function restoreFiltersFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);

            // Tamaño
            if (urlParams.has('tamano') && tamanoSlider) {
                tamanoSlider.value = urlParams.get('tamano');
                tamanoValue.textContent = `${urlParams.get('tamano')}cm`;
            }

            // Categorías
            if (urlParams.has('categorias')) {
                const activeCategories = urlParams.get('categorias').split(',');
                document.querySelectorAll('input[name="categorias[]"]').forEach(checkbox => {
                    checkbox.checked = activeCategories.includes(checkbox.value);
                });
            }

            // Otros filtros
            ['dificultad', 'filter2'].forEach(filter => {
                if (urlParams.has(filter)) {
                    const element = document.querySelector(`[name="${filter}"]`);
                    if (element) element.value = urlParams.get(filter);
                }
            });

            // Orden dirección
            if (urlParams.has('filter3')) {
                const radio = document.querySelector(`input[name="filter3"][value="${urlParams.get('filter3')}"]`);
                if (radio) radio.checked = true;
            }
        }

        // Ejecutar al cargar
        restoreFiltersFromUrl();
    });
    function agregarAlCarrito(productoId) {
    const cantidad = document.getElementById('cantidad_' + productoId).value;

    fetch(`/cart/ajax/agregar/${productoId}`, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
        cantidad: cantidad
    })
    })
    .then(response => {
        if (response.status === 401) {
            // No autenticado → redirige al login
            window.location.href = '{{ route('login') }}';
            return;
        }
        if (!response.ok) throw new Error('Error al agregar al carrito');
        return response.json();
    })
    .then(data => {
        if (!data) return;
        Toastify({
            text: "Producto agregado al carrito 🛒",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#10B981", // verde
        }).showToast();

        // Aquí podrías actualizar el mini-carrito si tienes uno
        // actualizarMiniCarrito(data);
    })
    .catch(error => {
        console.error(error);
        Toastify({
            text: "Ocurrió un error al agregar el producto 😓",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#EF4444", // rojo
        }).showToast();
    });
}
     function agregarACotizacion(productoId) {
        const cantidad = document.getElementById(`cantidad_${productoId}`).value;

        fetch(`/cotizacion/ajax/agregar/${productoId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ cantidad: cantidad })
        })
        .then(response => {
            if (!response.ok) throw new Error('Error en la solicitud');
            return response.json();
        })
        .then(data => {
            Toastify({
            text: data.message || 'Producto añadido a la cotización.',
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#FBBF24", // amarillo
            }).showToast();
        })
        .catch(error => {
            console.error(error);
            Toastify({
            text: 'Error al añadir a cotización',
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#EF4444", // rojo
            }).showToast();
        });
    }
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('input[name="categorias[]"]');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    checkboxes.forEach(cb => {
                        if (cb !== this) cb.checked = false;
                    });
                }
            });
        });
    });

</script>

@endsection
