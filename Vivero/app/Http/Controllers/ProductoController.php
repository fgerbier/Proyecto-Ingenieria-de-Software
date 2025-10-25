<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function home(Request $request)
    {
        // Obtener filtros desde la solicitud
        $tamano = $request->input('tamano');
        $categoria = $request->input('categorias');
        $dificultad = $request->input('dificultad');
        $ordenar_por = $request->input('filter2');
        $ordenar_ascendente = $request->input('filter3') === 'ascendente';

        // Construir consulta base
        $productos = Producto::query();

        // Aplicar filtros
        if ($tamano) {
            $productos->where('tamano', '<=', $tamano);
        }
        if ($categoria) {
            $productos->where('categoria_id', $categoria);
        }

        if ($dificultad) {
            $productos->where('nivel_dificultad', $dificultad);
        }

        $productos->where('activo', true);

        // Aplicar ordenamiento
        if ($ordenar_por) {
            if ($ordenar_por == 'precio') {
                $productos->orderBy('precio', $ordenar_ascendente ? 'asc' : 'desc');
            } elseif ($ordenar_por == 'popularidad') {
                $productos->orderBy('popularidad', $ordenar_ascendente ? 'asc' : 'desc');
            } else {
                // Relevancia por defecto
                $productos->orderBy('created_at', $ordenar_ascendente ? 'asc' : 'desc');
            }
        }

        // Obtener los productos filtrados y paginados
        $productos = $productos->paginate(12); // Número de productos por página

        // Pasar los filtros a la vista para que se mantengan seleccionados
        return view('products.index', [
            'productos' => $productos,
            'tamano' => $tamano,
            'categoria' => $categoria,
            'dificultad' => $dificultad,
            'ordenar_por' => $ordenar_por,
            'ordenar_ascendente' => $ordenar_ascendente,
            'categorias' => Categoria::all(), // O las categorías que estés usando
        ]);
    }

    public function show($slug)
    {
        // Obtener el producto específico por su slug
        $producto = Producto::where('slug', $slug)->firstOrFail();

        // Obtener productos relacionados por categoría, excluyendo el producto actual
        $relacionados = Producto::where('categoria_id', $producto->categoria)
            ->where('id', '!=', $producto->id)
            ->take(3)
            ->get();

        // Pasar los datos a la vista
        return view('products.show', compact('producto', 'relacionados'));
    }

    public function filterByCategory(Request $request)
    {
        $tamano = $request->input('tamano');
        $dificultad = $request->input('dificultad');
        $ordenar_por = $request->input('filter2');
        $ordenar_ascendente = $request->input('filter3') === 'ascendente';
        $categoriaId = $request->input('categorias'); // <- este es el ID directamente

        $productos = Producto::query();

        if ($categoriaId) {
            $productos->where('categoria_id', $categoriaId); // <- esta es la clave correcta
        }

        if ($tamano) {
            $productos->where('tamano', '<=', $tamano);
        }

        if ($dificultad) {
            $productos->where('nivel_dificultad', $dificultad);
        }

        if ($ordenar_por) {
            if ($ordenar_por == 'precio') {
                $productos->orderBy('precio', $ordenar_ascendente ? 'asc' : 'desc');
            } elseif ($ordenar_por == 'popularidad') {
                $productos->orderBy('popularidad', $ordenar_ascendente ? 'asc' : 'desc');
            } else {
                $productos->orderBy('created_at', $ordenar_ascendente ? 'asc' : 'desc');
            }
        }

        $productos = $productos->paginate(12);

        return view('products.index', [
            'productos' => $productos,
            'tamano' => $tamano,
            'categoria' => Categoria::find($categoriaId), // opcional para mostrar el nombre
            'dificultad' => $dificultad,
            'ordenar_por' => $ordenar_por,
            'ordenar_ascendente' => $ordenar_ascendente,
            'categorias' => Categoria::all(),
        ]);
    }

    public function filter(Request $request, ?string $category = null, ?int $tamano = null, ?string $dificultad = null, ?string $ordenar_por = null, ?bool $ordenar_ascendente = false)
    {
        /* Validación básica de parámetros
        if ($category && !Categoria::where('nombre', $category)->exists()) {
            abort(404, 'Categoría no encontrada');
        }
            */
        $category = $request->input('categorias'); // <- Esto ahora funciona con ?categorias=Suculenta


        // Construcción de la consulta
        $productos = Producto::query()
            ->when($category, function ($query) use ($category) {
                $query->whereHas('categoria_id', function ($q) use ($category) {
                    $q->where('nombre', $category);
                });
            })
            ->when($tamano, function ($query) use ($tamano) {
                $query->where('tamano', '<=', $tamano);
            })
            ->when($dificultad, function ($query) use ($dificultad) {
                $query->where('nivel_dificultad', $dificultad);
            });

        $ordenar_por = $ordenar_por ?: 'created_at'; // Valor por defecto
        $direccion = $ordenar_ascendente ? 'asc' : 'desc';

        $productos->orderBy(
            match ($ordenar_por) {
                'precio' => 'precio',
                'popularidad' => 'popularidad',
                default => 'created_at'
            },
            $direccion
        );

        // Preparación de datos para la vista
        $categorias = Categoria::all()
            ->each(function ($cat) use ($category) {
                $cat->selected = $cat->nombre === $category;
            });

        return view('products.index', [
            'productos' => $productos->paginate(12),
            'tamano' => $tamano,
            'categoria' => $category,
            'dificultad' => $dificultad,
            'ordenar_por' => $ordenar_por,
            'ordenar_ascendente' => $ordenar_ascendente,
            'categorias' => $categorias,
            'dificultades' => Producto::distinct()->pluck('nivel_dificultad'),
        ]);
    }
    public function dashboard_show(Request $request)
    {
        $query = Producto::query();

        // Filtro por categoría si está presente
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        // Búsqueda por nombre similar si está presente
        if ($request->filled('busqueda')) {
            $searchTerm = '%' . $request->busqueda . '%';
            $query->where('nombre', 'like', $searchTerm)
                ->orWhere('descripcion', 'like', $searchTerm);
        }

        // Paginación con 10 elementos por página y conservar parámetros de búsqueda
        $productos = $query->paginate(10);

        // Obtener lista de categorías distintas
        $categorias = Categoria::all();

        return view('dashboard.catalog.catalogo', compact('productos', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $dificultades = Producto::distinct()->pluck('nivel_dificultad');
        return view('dashboard.catalog.catalogo_edit', compact('categorias', 'dificultades'));
    }

    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'cuidados' => 'nullable|string',
            'nivel_dificultad' => 'nullable|string',
            'frecuencia_riego' => 'nullable|string',
            'ubicacion_ideal' => 'nullable|string',
            'beneficios' => 'nullable|string',
            'toxica' => 'nullable|boolean',
            'origen' => 'nullable|string',
            'tamano' => 'nullable|string',
            'activo' => 'nullable|boolean',
            'categoria' => 'required|string|exists:categorias,nombre',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10000',
        ]);

        $producto = new Producto();

        // Manejo de imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $ruta = $imagen->store('public/images/productos');
            $producto->imagen = str_replace('public/', 'storage/', $ruta);
        } else {
            $producto->imagen = 'storage/images/default-logo.png';
        }

        // Obtener ID de la categoría desde el nombre
        $categoria = Categoria::where('nombre', $request->categoria)->first();

        if ($categoria) {
            $producto->fill($request->except(['imagen', 'categoria']));
            $producto->save();

            // Asociar categoría en tabla pivote
            $producto->categorias()->sync([$categoria->id]);

            return redirect()->route('dashboard.catalogo')->with('success', 'Producto creado correctamente.');
        } else {
            return back()->withErrors(['categoria' => 'La categoría seleccionada no existe.'])->withInput();
        }
    }

    public function edit($id)
    {

        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        $dificultades = Producto::distinct()->pluck('nivel_dificultad');
        return view('dashboard.catalog.catalogo_edit', compact('producto', 'categorias', 'dificultades'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'cuidados' => 'nullable|string',
            'nivel_dificultad' => 'nullable|string',
            'frecuencia_riego' => 'nullable|string',
            'ubicacion_ideal' => 'nullable|string',
            'beneficios' => 'nullable|string',
            'toxica' => 'nullable|boolean',
            'origen' => 'nullable|string',
            'tamano' => 'nullable|string',
            'activo' => 'nullable|boolean',
            'categoria' => 'required|string|exists:categorias,nombre',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10000',
        ]);

        // Manejo de imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');

            if ($producto->imagen && $producto->imagen !== 'storage/images/default-logo.png') {
                Storage::delete(str_replace('storage/', 'public/', $producto->imagen));
            }

            $ruta = $imagen->store('public/images/productos');
            $producto->imagen = str_replace('public/', 'storage/', $ruta);
        } elseif (!$producto->imagen) {
            $producto->imagen = 'storage/images/default-logo.png';
        }

        // Obtener el ID de la categoría por su nombre
        $categoria = \App\Models\Categoria::where('nombre', $request->categoria)->first();

        if (!$categoria) {
            return back()->withErrors(['categoria' => 'La categoría seleccionada no existe'])->withInput();
        }

        // Rellenar campos excepto imagen y categoria
        $producto->fill($request->except(['imagen', 'categoria']));

        // Asignar el ID numérico en lugar del nombre
        $producto->categoria_id = $categoria->id;

        $producto->save();

        return redirect()->route('dashboard.catalogo')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return redirect()->route('dashboard.catalog.catalogo')->with('success', 'Producto eliminado correctamente.');
    }
}
