<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Cuidado - {{ $cuidado->producto->nombre }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }

        header {
            text-align: center;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        header h1 {
            margin: 0;
            color: #4CAF50;
        }

        .logo {
            height: 60px;
            margin-bottom: 10px;
        }

        section {
            margin-bottom: 20px;
        }

        h2 {
            font-size: 14px;
            color: #4CAF50;
            margin-bottom: 8px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        td {
            padding: 6px 10px;
            border: 1px solid #ccc;
        }

        .label {
            background-color: #f5f5f5;
            font-weight: bold;
            width: 30%;
        }

        .image-preview {
            margin-top: 10px;
            text-align: center;
        }

        .image-preview img {
            max-height: 180px;
            object-fit: contain;
        }
        .logo {
            height: 60px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
        <h1>Ficha de Cuidado de Planta</h1>
        <p>{{ $cuidado->producto->nombre }}</p>
    </header>

    <section>
        <h2>Detalles de Cuidado</h2>
        <table>
            <tr>
                <td class="label">Frecuencia de riego</td>
                <td>{{ $cuidado->frecuencia_riego }}</td>
            </tr>
            <tr>
                <td class="label">Cantidad de agua</td>
                <td>{{ $cuidado->cantidad_agua }}</td>
            </tr>
            <tr>
                <td class="label">Tipo de luz</td>
                <td>{{ $cuidado->tipo_luz }}</td>
            </tr>
            <tr>
                <td class="label">Temperatura ideal</td>
                <td>{{ $cuidado->temperatura_ideal ?? 'No especificada' }}</td>
            </tr>
            <tr>
                <td class="label">Tipo de sustrato</td>
                <td>{{ $cuidado->tipo_sustrato ?? 'No especificado' }}</td>
            </tr>
            <tr>
                <td class="label">Frecuencia de abono</td>
                <td>{{ $cuidado->frecuencia_abono ?? 'No especificada' }}</td>
            </tr>
            <tr>
                <td class="label">Plagas comunes</td>
                <td>{{ $cuidado->plagas_comunes ?? 'No especificadas' }}</td>
            </tr>
        </table>
    </section>

    @if($cuidado->cuidados_adicionales)
    <section>
        <h2>Cuidados Adicionales</h2>
        <p>{!! nl2br(e($cuidado->cuidados_adicionales)) !!}</p>
    </section>
    @endif

</body>
</html>
