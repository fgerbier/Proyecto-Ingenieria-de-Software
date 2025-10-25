<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas del mes {{ $mes }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            color: #1f2937; /* text-gray-800 */
            margin: 20px;
        }

        h1 {
            font-family: 'Roboto Condensed', sans-serif;
            font-size: 20px;
            margin-bottom: 20px;
            color: #111827; /* text-gray-900 */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 11px;
        }

        th, td {
            border: 1px solid #d1d5db; /* border-gray-300 */
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #d1fae5; /* bg-green-100 */
            font-family: 'Roboto Condensed', sans-serif;
            color: #065f46; /* text-green-800 */
        }

        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .resumen {
            margin-bottom: 30px;
        }

        .resumen div {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .cantidad { color: #1e40af; } /* text-blue-800 */
        .total { color: #047857; }    /* text-green-700 */
    </style>
</head>
<body>
    <h1>Resumen de Ventas - {{ $mes }}</h1>

    <div class="resumen">
        <div class="cantidad">Total de pedidos: {{ $cantidad }}</div>
        <div class="total">Total vendido: ${{ number_format($total, 0, ',', '.') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total del Pedido</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pedidos as $index => $pedido)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y') }}</td>
                    <td>{{ $pedido->usuario->name ?? '—' }}</td>
                    <td>${{ number_format($pedido->total, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($pedido->estado ?? 'completado') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay pedidos registrados para este mes.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
