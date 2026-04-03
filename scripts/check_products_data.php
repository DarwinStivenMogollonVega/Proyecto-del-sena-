<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Producto;

echo "Checking products for missing data...\n\n";

$products = Producto::with(['categoria','catalogo','proveedor','artista'])->get();
$missingCount = 0;
foreach ($products as $p) {
    $miss = [];
    if (!$p->categoria) $miss[] = 'categoria';
    if (!$p->catalogo) $miss[] = 'catalogo';
    if (!$p->proveedor) $miss[] = 'proveedor';
    if (!$p->artista) $miss[] = 'artista';
    if (empty($p->anio_lanzamiento)) $miss[] = 'anio_lanzamiento';

    if (!empty($miss)) {
        $missingCount++;
        echo sprintf("ID: %s | %s | Missing: %s\n", $p->getKey(), $p->nombre, implode(', ', $miss));
    }
}

if ($missingCount === 0) {
    echo "All products have the required relations/fields.\n";
} else {
    echo "\nTotal products with missing data: $missingCount\n";
}

echo "Done.\n";
