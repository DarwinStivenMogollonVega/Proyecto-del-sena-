<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Producto;
use App\Models\Catalogo;

$names = [
    'Vinilo LP Colombia Tierra Querida',
    'Richie Ray & Bobby Cruz – The Hits Live',
    'Daniel Calderón – Conexión',
    'Bobby Matos – My Latin Soul',
    'Aterciopelados – El Dorado',
    'Carlos Vives – La Tierra del Olvido',
    'Secos & Molhados – Secos & Molhados',
    'Los Prisioneros – La cultura de la basura',
    'Shakira – ¿Dónde están los ladrones?',
    'Juanes – Un Día Normal',
    'Selena – Amor Prohibido',
    'Daddy Yankee – Barrio Fino',
    'Vicente Fernández – Para Siempre',
    'Diomedes Díaz – Mi Biografía',
    'Juanes – La Vida... Es Un Ratico',
    'Ana Gabriel – Grandes Éxitos',
    'Latin Oldies Vol.1',
    'Soda Stereo – Sueño Stereo',
    'Michael Jackson – Thriller',
    'Nirvana – Nevermind',
];

$rows = Producto::whereIn('nombre', $names)->get()->map(function($p){
    return [
        'id' => $p->id,
        'nombre' => $p->nombre,
        'catalogo_id' => $p->catalogo_id,
        'catalogo' => $p->catalogo ? $p->catalogo->nombre : null,
    ];
})->toArray();

echo json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
