<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Producto;

$path = __DIR__ . '/../storage/app/missing_artistas_products.csv';
$fh = fopen($path, 'w');
if (!$fh) {
    echo "No se pudo abrir el archivo para escritura: $path\n";
    exit(1);
}

fputcsv($fh, ['producto_id', 'nombre', 'codigo', 'artista_id', 'artista_existente', 'created_at']);

$productos = Producto::with('artista')
    ->where(function ($q) {
        $q->whereNull('artista_id')
          ->orWhereDoesntHave('artista');
    })->get();

foreach ($productos as $p) {
    fputcsv($fh, [
        $p->getKey(),
        $p->nombre,
        $p->codigo,
        $p->artista_id,
        $p->artista ? 'si' : 'no',
        $p->created_at?->toDateTimeString() ?? '',
    ]);
}

fclose($fh);

echo "Exportado {$productos->count()} registros a: $path\n";
