<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen Financiero</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            color: #1f2937; /* Tailwind text-gray-800 */
            margin: 20px;
        }

        h1 {
            font-family: 'Roboto Condensed', sans-serif;
            font-size: 20px;
            margin-bottom: 20px;
            color: #111827;
        }

        .resumen {
            margin-bottom: 20px;
        }

        .resumen div {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .ingresos { color: #047857; }  /* text-green-700 */
        .egresos { color: #b91c1c; }   /* text-red-700 */
        .balance { color: #1e40af; }   /* text-blue-800 */

        table {
            width: 100%;
            border-collapse: collapse;
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
            color: #065f46;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
    </style>
</head>
<body>
    <h1>Resumen Financiero</h1>

    <div class="resumen">
        <div class="ingresos">Total Ingresos: ${{ number_format($totalIngresos, 0, ',', '.') }}</div>
        <div class="egresos">Total Egresos: ${{ number_format($totalEgresos, 0, ',', '.') }}</div>
        <div class="balance">Balance: ${{ number_format($balance, 0, ',', '.') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Monto</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Registrado por</th>
            </tr>
        </thead>
        <tbody>
            @foreach($finanzas as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') }}</td>
                    <td style="color: {{ $item->tipo === 'ingreso' ? '#047857' : '#b91c1c' }}">
                        {{ ucfirst($item->tipo) }}
                    </td>
                    <td>${{ number_format($item->monto, 0, ',', '.') }}</td>
                    <td>{{ $item->categoria }}</td>
                    <td>{{ $item->descripcion ?: '—' }}</td>
                    <td>{{ $item->usuario->name ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
