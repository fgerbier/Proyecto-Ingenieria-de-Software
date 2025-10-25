<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta Provisoria</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6 font-sans">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold text-green-700 mb-4 text-center">Vivero Plantas Editha</h1>
        <p class="text-center text-sm text-gray-600 mb-4">
            RUT: 12.345.678-9 | Av. Pedro Aguirre Cerda 2999, San Pedro de la Paz | +56 9 1234 5678
        </p>

        <div class="mb-4 text-sm text-gray-700">
            <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d-m-Y H:i') }}</p>
            <p><strong>N° Pedido:</strong> {{ $pedido->id }}</p>
            <p><strong>Cliente:</strong> {{ $pedido->usuario->name }}</p>
            <p><strong>Método de entrega:</strong> {{ $pedido->metodo_entrega }}</p>
            <p><strong>Dirección:</strong> {{ $pedido->direccion_entrega ?? 'No disponible' }}</p>
        </div>

        <div class="overflow-x-auto rounded-lg shadow mb-4">
            <table class="min-w-full divide-y divide-gray-300 text-sm">
                <thead class="bg-green-100">
                    <tr>
                        <th class="px-2 py-1 text-left">Producto</th>
                        <th class="px-2 py-1 text-right">Cantidad</th>
                        <th class="px-2 py-1 text-right">Precio Unitario</th>
                        <th class="px-2 py-1 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($pedido->detalles as $detalle)
                        <tr>
                            <td class="px-2 py-1">{{ $detalle->nombre_producto_snapshot }}</td>
                            <td class="px-2 py-1 text-right">{{ $detalle->cantidad }}</td>
                            <td class="px-2 py-1 text-right">${{ number_format($detalle->precio_unitario, 0, ',', '.') }}</td>
                            <td class="px-2 py-1 text-right">${{ number_format($detalle->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-right text-sm mb-4">
            <p><strong>Subtotal:</strong> ${{ number_format($subtotal, 0, ',', '.') }}</p>
            <p><strong>Descuento ({{ number_format($descuentoPorcentaje, 2) }}%):</strong> -${{ number_format($descuentoMonto, 0, ',', '.') }}</p>
            <p><strong>Impuesto (19%):</strong> ${{ number_format($impuesto, 0, ',', '.') }}</p>
            <p class="text-lg font-bold text-green-700"><strong>Total Final:</strong> ${{ number_format($total, 0, ',', '.') }}</p>

        </div>

        <div class="text-center text-gray-600 text-sm">
            <p>Gracias por su compra</p>
            <p class="text-xs">Documento generado electrónicamente - No válido como documento fiscal</p>
        </div>

        <div class="mt-6 text-center space-x-2">
        <a href="{{ route('boletas.pdf', $pedido->id) }}"
            class="inline-block bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded shadow transition"
            title="Descargar PDF">
            Descargar PDF
        </a>


        </div>
    </div>
</body>
</html>
