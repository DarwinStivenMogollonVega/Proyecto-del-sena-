<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\FacturaController;
use App\Models\Factura;
use App\Models\User;
use Illuminate\Http\Request;

$id = $argv[1] ?? 3;
$name = $argv[2] ?? 'Admin Edited';
$email = $argv[3] ?? 'edited@prueba.com';

// Ensure an authenticated user for controller checks
$user = User::first();
if ($user) auth()->setUser($user);

$data = [
    'usuario_id' => $user ? $user->getKey() : 1,
    'nombre_cliente' => $name,
    'correo_cliente' => $email,
    'direccion_cliente' => 'Calle editada 123',
    'identificacion_cliente' => '9999999999',
    'numero_documento' => '9999999999',
    'tipo_documento' => 'cedula',
    'total' => '100.50',
    'estado' => 'pagada',
];

$request = Request::create("/admin/facturas/{$id}", 'POST', $data);
$request->setMethod('PUT');

$ctrl = new FacturaController();

try {
    $resp = $ctrl->adminUpdate($request, $id);
    echo "Update response: ";
    if ($resp instanceof Illuminate\Http\RedirectResponse) {
        echo "Redirect to " . $resp->getTargetUrl() . PHP_EOL;
    } else {
        echo get_class($resp) . PHP_EOL;
    }
} catch (Throwable $e) {
    echo "Exception: " . $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}

$f = Factura::find($id);
if ($f) {
    echo "--- Factura after update ---\n";
    echo json_encode($f->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
} else {
    echo "Factura not found after update.\n";
}

return 0;
