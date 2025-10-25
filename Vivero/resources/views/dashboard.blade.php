@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="bg-white shadow rounded-lg p-4 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-1">Bienvenido al Panel Administrativo</h2>
    <p class="text-sm text-gray-600">Resumen de tareas del vivero.</p>
</div>

{{-- Tarjetas resumen --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-white shadow rounded-lg p-3">
        <p class="text-xs text-gray-500">💰 Ventas del mes</p>
        <p class="text-lg font-semibold text-green-600">${{ number_format($ventasMes, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-3">
        <p class="text-xs text-gray-500">📦 Pedidos del mes</p>
        <p class="text-lg font-semibold text-blue-600">{{ $pedidosMes }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-3">
        <p class="text-xs text-gray-500">📈 Ingresos totales</p>
        <p class="text-lg font-semibold text-green-700">${{ number_format($ingresosTotales, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-3">
        <p class="text-xs text-gray-500">📉 Egresos totales</p>
        <p class="text-lg font-semibold text-red-600">${{ number_format($egresosTotales, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-3">
        <p class="text-xs text-gray-500">🧮 Balance actual</p>
        <p class="text-lg font-semibold text-indigo-600">
            ${{ number_format($ingresosTotales - $egresosTotales, 0, ',', '.') }}
        </p>
    </div>
</div>

{{-- Gráficos y próximos trasplantes --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    {{-- Gráfico de Ventas Diarias --}}
    <div class="bg-white shadow rounded-lg p-2">
        <div class="flex justify-between items-center mb-1">
            <h3 class="text-xs font-semibold text-gray-800">📊 Ventas Diarias</h3>
            <input type="month" id="mesVentasSelector"
                   class="border border-gray-300 rounded px-2 py-0.5 text-xs focus:ring-2 focus:ring-blue-500">
        </div>
        <canvas id="graficoVentas" class="w-full" style="height: 180px;"></canvas>
    </div>

    {{-- Gráfico de Ingresos vs Egresos --}}
    <div class="bg-white shadow rounded-lg p-2">
        <div class="flex justify-between items-center mb-1">
            <h3 class="text-xs font-semibold text-gray-800">🥧 Ingresos vs Egresos</h3>
            <input type="month" id="mesSelector"
                   class="border border-gray-300 rounded px-2 py-0.5 text-xs focus:ring-2 focus:ring-blue-500">
        </div>
        <canvas id="graficoTorta" class="w-full" style="height: 180px;"></canvas>
    </div>
</div>

{{-- Próximos Trasplantes --}}
<div class="bg-white shadow-sm rounded p-3 mb-6">
    <h3 class="text-base font-bold text-gray-800 mb-3">🌱 Próximos Trasplantes</h3>
    @if($trasplantesProximos->isEmpty())
        <p class="text-sm text-gray-500 italic">No hay trasplantes en los próximos días.</p>
    @else
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="text-gray-600 border-b">
                    <th class="pb-1">Planta</th>
                    <th class="pb-1">Cantidad</th>
                    <th class="pb-1">Fecha Trasplante</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @foreach ($trasplantesProximos as $evento)
                    @php
                        $fecha = \Carbon\Carbon::parse($evento->fecha_trasplante);
                        $hoy = \Carbon\Carbon::today();
                        $clase = match(true) {
                            $fecha->isToday() => 'bg-green-100 text-green-800 font-semibold',
                            $fecha->isTomorrow() => 'bg-yellow-100 text-yellow-800 font-semibold',
                            default => '',
                        };
                    @endphp
                    <tr class="border-b border-gray-100 hover:bg-green-50 transition {{ $clase }}">
                        <td class="py-2 font-medium">{{ $evento->planta }}</td>
                        <td class="py-2">{{ $evento->cantidad ?? '—' }}</td>
                        <td class="py-2">{{ $fecha->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- Tareas pendientes y en progreso --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-white shadow-sm rounded p-3">
        <h3 class="text-base font-bold text-gray-800 mb-3">🕒 Tareas Pendientes</h3>
        @if($tareasPendientes->isEmpty())
            <p class="text-sm text-gray-500 italic">No hay tareas pendientes.</p>
        @else
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-gray-600 border-b">
                        <th class="pb-1">Tarea</th>
                        <th class="pb-1">Responsable</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    @foreach ($tareasPendientes as $tarea)
                        <tr class="border-b border-gray-100 hover:bg-red-50 transition">
                            <td class="py-2 font-medium text-red-700">{{ $tarea->nombre }}</td>
                            <td class="py-2">{{ $tarea->responsable }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="bg-white shadow-sm rounded p-3">
        <h3 class="text-base font-bold text-gray-800 mb-3">🚧 Tareas en Progreso</h3>
        @if($tareasEnProgreso->isEmpty())
            <p class="text-sm text-gray-500 italic">No hay tareas en progreso.</p>
        @else
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-gray-600 border-b">
                        <th class="pb-1">Tarea</th>
                        <th class="pb-1">Responsable</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    @foreach ($tareasEnProgreso as $tarea)
                        <tr class="border-b border-gray-100 hover:bg-yellow-50 transition">
                            <td class="py-2 font-medium text-yellow-700">{{ $tarea->nombre }}</td>
                            <td class="py-2">{{ $tarea->responsable }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // === VENTAS DIARIAS ===
        const ctxVentas = document.getElementById('graficoVentas').getContext('2d');
        let chartVentas = new Chart(ctxVentas, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Ventas diarias ($)',
                    data: [],
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => '$' + value.toLocaleString('es-CL')
                        }
                    }
                },
                plugins: {
                    legend: { display: true }
                }
            }
        });

        document.getElementById('mesVentasSelector').addEventListener('change', async function () {
            const mes = this.value;
            if (!mes) return;
            try {
                const response = await fetch(`/api/ventas/por-dia?mes=${mes}`);
                const data = await response.json();

                const valores = data.valores;
                const maxValor = Math.max(...valores, 0);
                const escalaMax = Math.ceil(maxValor / 500000) * 500000 || 500000;

                chartVentas.data.labels = data.labels;
                chartVentas.data.datasets[0].data = valores;
                chartVentas.options.scales.y.max = escalaMax;
                chartVentas.options.scales.y.ticks.stepSize = 500000;
                chartVentas.update();
            } catch (error) {
                console.error('Error al cargar ventas:', error);
                alert('No se pudieron cargar las ventas del mes.');
            }
        });

        document.getElementById('mesVentasSelector').value = new Date().toISOString().slice(0, 7);
        document.getElementById('mesVentasSelector').dispatchEvent(new Event('change'));

        // === TORTA INGRESOS VS EGRESOS ===
        const ctxTorta = document.getElementById('graficoTorta').getContext('2d');
        let chartTorta = new Chart(ctxTorta, {
            type: 'pie',
            data: {
                labels: ['Ingresos', 'Egresos'],
                datasets: [{
                    data: [0, 0],
                    backgroundColor: ['#10b981', '#ef4444'],
                    borderColor: ['#047857', '#b91c1c'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        document.getElementById('mesSelector').addEventListener('change', async function () {
            const mes = this.value;
            if (!mes) return;

            try {
                const response = await fetch(`/api/finanzas/ingresos-egresos?mes=${mes}`);
                const data = await response.json();

                chartTorta.data.datasets[0].data = [data.ingresos, data.egresos];
                chartTorta.update();
            } catch (error) {
                console.error('Error al cargar datos financieros:', error);
                alert('No se pudo obtener la información financiera del mes.');
            }
        });

        document.getElementById('mesSelector').value = new Date().toISOString().slice(0, 7);
        document.getElementById('mesSelector').dispatchEvent(new Event('change'));
    });
</script>
@endpush
