<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta Pedido #{{ $pedido->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #4CAF50;
        }
        .company-info {
            font-size: 10px;
            color: #777;
        }
        .section-title {
            background-color: #4CAF50;
            color: #fff;
            padding: 5px;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .summary {
            margin-top: 10px;
            text-align: right;
        }
        .summary p {
            margin: 2px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Vivero Plantas Editha</h1>
        <p class="company-info">
            RUT: 12.345.678-9 | Av. Pedro Aguirre Cerda 2999, San Pedro de la Paz | +56 9 1234 5678
        </p>
    </div>

    <div>
        <div class="section-title">Datos del Pedido</div>
        <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d-m-Y H:i') }}</p>
        <p><strong>N° Pedido:</strong> {{ $pedido->id }}</p>
        <p><strong>Cliente:</strong> {{ $pedido->usuario->name }}</p>
        <p><strong>Método de entrega:</strong> {{ $pedido->metodo_entrega }}</p>
        <p><strong>Dirección:</strong> {{ $pedido->direccion ?? 'No disponible' }}</p>
    </div>

    <div>
        <div class="section-title">Productos</div>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th class="text-right">Cantidad</th>
                    <th class="text-right">Precio Unitario</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedido->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->nombre_producto_snapshot }}</td>
                        <td class="text-right">{{ $detalle->cantidad }}</td>
                        <td class="text-right">${{ number_format($detalle->precio_unitario, 0, ',', '.') }}</td>
                        <td class="text-right">${{ number_format($detalle->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<div class="summary">
    <p><strong>Subtotal:</strong> ${{ number_format($subtotal, 0, ',', '.') }}</p>
    <p><strong>Descuento ({{ number_format($descuentoPorcentaje, 2) }}%):</strong> -${{ number_format($descuentoMonto, 0, ',', '.') }}</p>
    <p><strong>Impuesto (19%):</strong> ${{ number_format($impuesto, 0, ',', '.') }}</p>
    <p><strong>Total Final:</strong> ${{ number_format($total, 0, ',', '.') }}</p>
</div>

    <div class="footer">
        Gracias por su compra<br>
        Documento generado electrónicamente - No requiere firma ni timbre
    </div>
</body>
</html>
