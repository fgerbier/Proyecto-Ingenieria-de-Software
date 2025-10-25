<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Finanza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanzaController extends Controller
{
    public function index(Request $request)
{
    $query = Finanza::query()->with('usuario');

    // Filtro por fechas
    if ($request->filled('desde')) {
        $query->whereDate('fecha', '>=', $request->desde);
    }
    if ($request->filled('hasta')) {
        $query->whereDate('fecha', '<=', $request->hasta);
    }

    // Filtro por tipo
    if ($request->filled('tipo')) {
        $query->where('tipo', $request->tipo);
    }

    // Filtro por categoría
    if ($request->filled('categoria')) {
        $query->where('categoria', 'like', '%' . $request->categoria . '%');
    }

    // Filtro por nombre del usuario
    if ($request->filled('usuario')) {
        $query->whereHas('usuario', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->usuario . '%');
        });
    }

    $finanzas = $query->latest()->get();

    $totalIngresos = $finanzas->where('tipo', 'ingreso')->sum('monto');
    $totalEgresos = $finanzas->where('tipo', 'egreso')->sum('monto');
    $balance = $totalIngresos - $totalEgresos;

    return view('dashboard.finance.finanzas', compact('finanzas', 'totalIngresos', 'totalEgresos', 'balance'));
}


    public function create()
    {
        return view('dashboard.finance.finanzas_edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:ingreso,egreso',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'categoria' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        $finanza = new Finanza();
        $finanza->tipo = $request->input('tipo');
        $finanza->monto = $request->input('monto');
        $finanza->fecha = $request->input('fecha');
        $finanza->categoria = $request->input('categoria');
        $finanza->descripcion = $request->input('descripcion');
        $finanza->created_by = Auth::id();
        $finanza->save();

        return redirect()->route('dashboard.finanzas')->with('success', 'Registro financiero creado exitosamente.');
    }

    public function edit($id)
    {
        $finanza = Finanza::findOrFail($id);
        return view('dashboard.finance.finanzas_edit', compact('finanza'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|in:ingreso,egreso',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'categoria' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        $finanza = Finanza::findOrFail($id);
        $finanza->tipo = $request->input('tipo');
        $finanza->monto = $request->input('monto');
        $finanza->fecha = $request->input('fecha');
        $finanza->categoria = $request->input('categoria');
        $finanza->descripcion = $request->input('descripcion');
        $finanza->save();

        return redirect()->route('dashboard.finanzas')->with('success', 'Registro financiero actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $finanza = Finanza::findOrFail($id);
        $finanza->delete();

        return redirect()->route('dashboard.finanzas')->with('success', 'Registro financiero eliminado exitosamente.');
    }
    public function exportarPDF(Request $request)
    {
    $finanzas = Finanza::with('usuario')->orderBy('fecha', 'desc')->get();
    $totalIngresos = $finanzas->where('tipo', 'ingreso')->sum('monto');
    $totalEgresos = $finanzas->where('tipo', 'egreso')->sum('monto');
    $balance = $totalIngresos - $totalEgresos;

    $pdf = Pdf::loadView('finance.pdf', compact('finanzas', 'totalIngresos', 'totalEgresos', 'balance'))
             ->setPaper('a4', 'landscape');

    $fecha = now()->format('Y-m-d');
    return $pdf->download("resumen_financiero_{$fecha}.pdf");
    }


public function guardarReporteVentas(Request $request)
{
    $request->validate([
        'mes' => 'required|date_format:Y-m',
        'descripcion' => 'nullable|string|max:255',
        'total' => 'required|numeric|min:0',
    ]);

    $usuarioId = auth()->id();

    try {
        $inicioMes = $request->mes . '-01 00:00:00';
        $finMes = date('Y-m-t 23:59:59', strtotime($inicioMes));

        $yaExiste = Finanza::where('tipo', 'ingreso')
            ->where('categoria', 'Ventas mensuales')
            ->whereBetween('fecha', [$inicioMes, $finMes])
            ->exists();

        if ($yaExiste) {
            return response()->json([
                'success' => false,
                'message' => 'Ya se ha registrado un ingreso por ventas para este mes.'
            ], 409);
        }

        Finanza::create([
            'tipo' => 'ingreso',
            'monto' => $request->total,
            'fecha' => now(),
            'categoria' => 'Ventas mensuales',
            'descripcion' => $request->descripcion ?: 'Ingreso por ventas del mes ' . $request->mes,
            'created_by' => $usuarioId,
        ]);

        return response()->json(['success' => true]);

    } catch (\Throwable $e) {
        Log::error('❌ Error al guardar ingreso: ' . $e->getMessage());
        return response()->json(['error' => 'Error del servidor'], 500);
    }
}

public function exportarVentasMensualesPDF(Request $request)
{
    $request->validate([
        'mes' => 'required|date_format:Y-m',
    ]);

    $inicioMes = $request->mes . '-01 00:00:00';
    $finMes = date('Y-m-t 23:59:59', strtotime($inicioMes));

    $pedidos = Pedido::whereBetween('created_at', [$inicioMes, $finMes])->with('usuario')->get();
    $total = $pedidos->sum('total');
    $cantidad = $pedidos->count();

    $data = [
        'mes' => $request->mes,
        'total' => $total,
        'cantidad' => $cantidad,
        'pedidos' => $pedidos,
    ];

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.finance.ventas_mensuales_pdf', $data);
    return $pdf->download('ventas_' . $request->mes . '.pdf');
}


}
