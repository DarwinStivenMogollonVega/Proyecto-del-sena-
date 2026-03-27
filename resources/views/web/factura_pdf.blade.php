<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura {{ $factura->numero_factura }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111827; font-size: 12px; }
        .head { border-bottom: 2px solid #111827; padding-bottom: 8px; margin-bottom: 14px; }
        .title { font-size: 18px; font-weight: 700; margin: 0; }
        .muted { color: #6b7280; }
        .grid { width: 100%; margin-bottom: 14px; }
        .grid td { vertical-align: top; width: 50%; padding: 6px; }
        .block { border: 1px solid #d1d5db; border-radius: 6px; padding: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #d1d5db; padding: 6px; }
        th { background: #f3f4f6; text-align: left; }
        .text-right { text-align: right; }
        .totals { margin-top: 10px; width: 45%; margin-left: auto; }
        .totals td { border: 1px solid #d1d5db; padding: 6px; }
        .totals tr:last-child td { font-weight: 700; background: #f9fafb; }
    </style>
</head>
<body>
    <div class="head">
        <p class="title">DiscZone - Factura electronica</p>
        <p class="muted" style="margin: 2px 0 0 0;">No. {{ $factura->numero_factura }} | Emision: {{ $factura->fecha_emision->format('d/m/Y H:i') }}</p>
    </div>

    <table class="grid">
        <tr>
            <td>
                <div class="block">
                    <strong>Cliente</strong><br>
                    Nombre: {{ $factura->cliente_nombre }}<br>
                    Correo: {{ $factura->cliente_email }}<br>
                    Direccion: {{ $factura->cliente_direccion ?: '-' }}<br>
                    Identificacion: {{ $factura->cliente_identificacion ?: '-' }}
                </div>
            </td>
            <td>
                <div class="block">
                    <strong>Pedido asociado</strong><br>
                    Pedido ID: #{{ $factura->pedido->getKey() }}<br>
                    Fecha pedido: {{ $factura->pedido->created_at->format('d/m/Y H:i') }}<br>
                    Estado: {{ ucfirst($factura->estado_pedido) }}
                </div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th class="text-right">Cantidad</th>
                <th class="text-right">Precio unitario</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factura->pedido->detalles as $detalle)
            <tr>
                <td>{{ $detalle->producto->nombre ?? 'Producto eliminado' }}</td>
                <td class="text-right">{{ $detalle->cantidad }}</td>
                <td class="text-right">${{ number_format($detalle->precio, 2) }}</td>
                <td class="text-right">${{ number_format($detalle->cantidad * $detalle->precio, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Subtotal</td>
            <td class="text-right">${{ number_format($factura->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td>Impuestos</td>
            <td class="text-right">${{ number_format($factura->impuestos, 2) }}</td>
        </tr>
        <tr>
            <td>Total final</td>
            <td class="text-right">${{ number_format($factura->total, 2) }}</td>
        </tr>
    </table>
</body>
</html>
