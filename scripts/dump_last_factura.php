<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Factura;

$f = Factura::latest()->first();
echo json_encode($f ? $f->toArray() : null, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;

return 0;
