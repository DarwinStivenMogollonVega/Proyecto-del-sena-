<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pedido;
use App\Models\Factura;

$pedidoId = 1;
$pedido = Pedido::find($pedidoId);
if (! $pedido) {
    echo "Pedido {$pedidoId} no encontrado\n";
    exit(1);
}

$ultimoNumero = Factura::max('factura_id') ?? 0;
$numeroFactura = 'F' . str_pad($ultimoNumero + 1, 6, '0', STR_PAD_LEFT);

$data = [
    'pedido_id' => $pedido->getKey(),
    'usuario_id' => $pedido->usuario_id ?? auth()->id() ?? 1,
    'numero_factura' => $numeroFactura,
    'fecha_emision' => date('Y-m-d H:i:s'),
    'estado_pedido' => $pedido->estado,
    'subtotal' => 42000,
    'impuestos' => 8000,
    'total' => 50000,
    'nombre_cliente' => $pedido->nombre,
    'correo_cliente' => $pedido->email,
    'direccion_cliente' => $pedido->direccion,
    'identificacion_cliente' => $pedido->numero_documento ?? '',
];

try {
    $factura = Factura::create($data);
    echo "Factura creada:\n";
    echo json_encode($factura->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    exit(0);
} catch (Throwable $e) {
    echo "Error creando factura: " . $e->getMessage() . "\n";
    exit(1);
}
