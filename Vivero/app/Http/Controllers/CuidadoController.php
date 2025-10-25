<?php

namespace App\Http\Controllers;

use App\Models\Cuidado;
use App\Models\Producto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class CuidadoController extends Controller
{
    public function index(Request $request)
{
    $query = Cuidado::with('producto')->orderBy('created_at', 'desc');

    if ($request->filled('producto')) {
        $query->whereHas('producto', function ($q) use ($request) {
            $q->where('nombre', 'like', '%' . $request->producto . '%');
        });
    }

    if ($request->filled('tipo_luz')) {
        $query->where('tipo_luz', $request->tipo_luz);
    }

    $cuidados = $query->paginate(10)->withQueryString();

    return view('dashboard.care.cuidados', compact('cuidados'));
}

    public function create()
    {
        $productos = Producto::all();
        return view('dashboard.care.cuidados_edit', [
            'cuidado' => null,
            'productos' => $productos,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'frecuencia_riego' => 'required|string',
            'cantidad_agua' => 'required|string',
            'tipo_luz' => 'required|string',
            'temperatura_ideal' => 'nullable|string',
            'tipo_sustrato' => 'nullable|string',
            'frecuencia_abono' => 'nullable|string',
            'plagas_comunes' => 'nullable|string',
            'cuidados_adicionales' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('cuidados', 'public');
            $data['imagen_url'] = $path;
        }

        Cuidado::create($data);

        return redirect()->route('dashboard.cuidados')->with('success', 'Cuidado registrado exitosamente.');
    }

    public function edit($id)
    {
        $cuidado = Cuidado::findOrFail($id);
        $productos = Producto::all();

        return view('dashboard.care.cuidados_edit', compact('cuidado', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $cuidado = Cuidado::findOrFail($id);

        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'frecuencia_riego' => 'required|string',
            'cantidad_agua' => 'required|string',
            'tipo_luz' => 'required|string',
            'temperatura_ideal' => 'nullable|string',
            'tipo_sustrato' => 'nullable|string',
            'frecuencia_abono' => 'nullable|string',
            'plagas_comunes' => 'nullable|string',
            'cuidados_adicionales' => 'nullable|string',
            
        ]);
        return redirect()->route('dashboard.cuidados')->with('success', 'Cuidado actualizado correctamente.');
    }

    public function destroy($id)
    {
        $cuidado = Cuidado::findOrFail($id);

        $cuidado->delete();

        return redirect()->route('dashboard.cuidados')->with('success', 'Cuidado eliminado correctamente.');
    }

    public function generarPdf($id)
    {
        $cuidado = Cuidado::with('producto')->findOrFail($id);

        $filename = 'cuidado_' . $cuidado->id . '.pdf';
        $path = 'public/cuidados/' . $filename;

        if (Storage::exists($path)) {
            return response()->file(storage_path('app/' . $path));
        }

        $pdf = Pdf::loadView('cuidado.cuidado', compact('cuidado'));
        Storage::put($path, $pdf->output());

        return response()->file(storage_path('app/' . $path));
    }



    public function mostrarQr($id)
{
    $cuidado = Cuidado::findOrFail($id);

        $urlPdf = route('dashboard.cuidados.pdf', $cuidado->id);
        $qr = QrCode::size(250)->generate($urlPdf);

    //dd($urlPdf);


    return view('dashboard.care.qr', compact('qr', 'cuidado'));
}
}
