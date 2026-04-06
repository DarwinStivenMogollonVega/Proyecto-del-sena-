<?php
// Minimal script to bootstrap the app in 'testing' env and render '/'
putenv('APP_ENV=testing');
putenv('APP_DEBUG=true');
putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=:memory:');
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/', 'GET');
try {
    $response = $kernel->handle($request);
    echo $response->getContent();
    $kernel->terminate($request, $response);
} catch (Throwable $e) {
    echo get_class($e) . "\n";
    echo $e->getMessage() . "\n";
    echo "In: " . $e->getFile() . ':' . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();
    exit(1);
}
