<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$pedido = Illuminate\Support\Facades\DB::table('pedidos')->where('id', 1)->first();
var_export($pedido);
echo PHP_EOL;
