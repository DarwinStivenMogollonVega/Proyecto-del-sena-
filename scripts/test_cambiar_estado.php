<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Authenticate as user id 1 if exists
try {
    auth()->loginUsingId(1);
} catch (Throwable $e) {
    echo "Auth login error: " . $e->getMessage() . PHP_EOL;
}

$request = Illuminate\Http\Request::create('/pedidos/1/estado', 'PATCH', ['estado' => 'enviado']);

try {
    $id = Illuminate\Support\Facades\DB::table('pedidos')->value('id');
    if (empty($id)) {
        // Crear un pedido mínimo de prueba
        $id = Illuminate\Support\Facades\DB::table('pedidos')->insertGetId([
            'usuario_id' => 1,
            'total' => 0,
            'estado' => 'pendiente',
            'nombre' => 'Prueba',
            'email' => 'prueba@local',
            'telefono' => '000',
            'direccion' => 'Prueba',
            'metodo_pago' => 'efectivo',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        echo "Created test pedido id: $id\n";
    }
    $request = Illuminate\Http\Request::create("/pedidos/{$id}/estado", 'PATCH', ['estado' => 'enviado']);
    $response = app()->call('App\\Http\\Controllers\\PedidoController@cambiarEstado', ['request' => $request, 'id' => $id]);
    echo "Controller response:\n";
    var_dump($response);
} catch (Throwable $e) {
    echo "Exception: " . $e->getMessage() . PHP_EOL;
    echo $e;
}

echo "Done\n";
