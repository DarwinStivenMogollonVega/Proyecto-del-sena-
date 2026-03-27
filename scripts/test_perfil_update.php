<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Ensure there's at least one user
$userId = DB::table('users')->value('id');
if (empty($userId)) {
    $userId = DB::table('users')->insertGetId([
        'name' => 'Test User',
        'email' => 'testuser+' . time() . '@local',
        'password' => bcrypt('secret'),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ]);
    echo "Created test user id: $userId\n";
}

// Authenticate
try {
    auth()->loginUsingId($userId);
} catch (Throwable $e) {
    echo "Auth login error: " . $e->getMessage() . PHP_EOL;
}

$userModel = App\Models\User::find($userId);
if (!$userModel) {
    echo "User not found after login.\n";
    exit(1);
}

// Prepare payload - keep email unchanged to avoid unique validation issues
$payload = [
    'name' => 'Updated ' . $userModel->name,
    'email' => $userModel->email,
    'telefono' => '123456789',
    'documento_identidad' => 'ABC123456',
    'fecha_nacimiento' => '1990-01-01',
    'ciudad' => 'CiudadTest',
    'pais' => 'PaisTest',
    'direccion' => 'Calle Falsa 123',
    'codigo_postal' => '0000',
    // leave password empty to avoid changing it
    'remove_avatar' => '0',
    'avatar_cropped' => '',
];

// Create FormRequest instance from base request so controller signature matches
$base = Request::create('/perfil', 'PUT', $payload);
// attach session/cookie data if needed
$base->setUserResolver(function () use ($userModel) { return $userModel; });

// Create the FormRequest (UserRequest) if class exists, else use base Request
$requestClass = 'App\\Http\\Requests\\UserRequest';
if (class_exists($requestClass)) {
    $formRequest = $requestClass::createFromBase($base);
    // set container so some FormRequest methods work
    if (method_exists($formRequest, 'setContainer')) {
        $formRequest->setContainer($app);
    }
    // skip automatic FormRequest validation to avoid side effects in CLI test
    $req = $formRequest;
} else {
    $req = $base;
}

// Call controller
try {
    $response = app()->call('App\\Http\\Controllers\\Auth\\PerfilController@update', ['request' => $req]);
    echo "Controller response:\n";
    if (is_object($response)) {
        echo get_class($response) . "\n";
        if (method_exists($response, 'getStatusCode')) echo "Status: " . $response->getStatusCode() . "\n";
    } else {
        var_dump($response);
    }
} catch (Throwable $e) {
    echo "Exception calling controller: " . $e->getMessage() . PHP_EOL;
    echo $e;
    exit(1);
}

// Reload user and print changed fields
$userModel->refresh();
$fields = ['name','email','telefono','documento_identidad','fecha_nacimiento','ciudad','pais','direccion','codigo_postal','avatar'];
$result = [];
foreach ($fields as $f) $result[$f] = $userModel->$f;

echo "User after update:\n";
print_r($result);

echo "Done.\n";
