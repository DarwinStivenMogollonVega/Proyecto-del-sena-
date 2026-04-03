<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Factura;

$id = $argv[1] ?? 3;

$f = Factura::find($id);
if (!$f) {
    echo "Factura {$id} not found\n";
    exit(1);
}

$f->nombre_cliente = 'Admin Direct';
$f->correo_cliente = 'direct@prueba.com';
$f->direccion_cliente = 'Direccion directa 1';
$f->identificacion_cliente = '1234567890';
$f->estado_pedido = 'pagada';
$f->total = 200.50;
$f->save();

echo "Updated factura:\n";
echo json_encode($f->fresh()->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;

return 0;
