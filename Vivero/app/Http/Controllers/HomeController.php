<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Work;
use App\Models\Pedido;
use App\Models\Finanza;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\SeedEvent;


class HomeController extends Controller
{
    // Vista pública del sitio
    public function index()
    {
        $categorias = Categoria::all();
        $productos = Producto::paginate(4);
        $ultimos = Producto::toma4ultimos();

        return view('home', compact('categorias', 'productos', 'ultimos'));
    }

    // Vista protegida del dashboard
   public function dashboard()
{
    // Tareas
        $tareasPendientes = Work::where('estado', 'pendiente')->get();
        $tareasEnProgreso = Work::where('estado', 'en progreso')->get();

        // Solo trasplantes con fecha dentro de los próximos 7 días y máximo 10 registros
        $hoy = Carbon::today();
        $sieteDias = $hoy->copy()->addDays(7);

        $trasplantesProximos = SeedEvent::whereNotNull('fecha_trasplante')
            ->whereBetween('fecha_trasplante', [$hoy, $sieteDias])
            ->orderBy('fecha_trasplante')
            ->limit(10) // 👈 límite de 10
            ->get();

        
    // Ventas mensuales
    $ventasPorMes = Pedido::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as mes, SUM(total) as total")
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();

    $labels = $ventasPorMes->pluck('mes')->toArray();
    $valores = $ventasPorMes->pluck('total')->toArray();

    // Métricas actuales del mes
    $mesActual = Carbon::now()->format('Y-m');
    $inicio = $mesActual . '-01';
    $fin = Carbon::parse($inicio)->endOfMonth()->toDateString();

    $ventasMes = Pedido::whereBetween('created_at', [$inicio, $fin])->sum('total');
    $pedidosMes = Pedido::whereBetween('created_at', [$inicio, $fin])->count();

    $ingresosTotales = Finanza::where('tipo', 'ingreso')->sum('monto');
    $egresosTotales = Finanza::where('tipo', 'egreso')->sum('monto');

    return view('dashboard', compact(
        'tareasPendientes',
        'tareasEnProgreso',
        'labels',
        'valores',
        'ventasMes',
        'pedidosMes',
        'ingresosTotales',
        'egresosTotales',
        'trasplantesProximos'
    ));
}
public function ingresosEgresosPorMes(Request $request)
{
    $request->validate([
        'mes' => 'required|date_format:Y-m',
    ]);

    $inicio = $request->mes . '-01';
    $fin = date('Y-m-t', strtotime($inicio));

    $ingresos = Finanza::where('tipo', 'ingreso')
        ->whereBetween('fecha', [$inicio, $fin])
        ->sum('monto');

    $egresos = Finanza::where('tipo', 'egreso')
        ->whereBetween('fecha', [$inicio, $fin])
        ->sum('monto');

    return response()->json([
        'ingresos' => $ingresos,
        'egresos' => $egresos
    ]);
}

public function ventasPorDia(Request $request)
{
    $request->validate([
        'mes' => 'required|date_format:Y-m'
    ]);

    $inicio = $request->mes . '-01';
    $fin = \Carbon\Carbon::parse($inicio)->endOfMonth()->toDateString();

    $ventas = Pedido::selectRaw("DATE(created_at) as dia, SUM(total) as total")
        ->whereBetween('created_at', [$inicio, $fin])
        ->groupBy('dia')
        ->orderBy('dia')
        ->get();

    $labels = $ventas->pluck('dia')->map(function ($d) {
        return \Carbon\Carbon::parse($d)->format('d');
    });

    $valores = $ventas->pluck('total');

    return response()->json([
        'labels' => $labels,
        'valores' => $valores
    ]);
}


   
}
