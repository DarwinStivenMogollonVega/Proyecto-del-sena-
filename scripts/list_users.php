<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$emails = ['admin@prueba.com','cliente@prueba.com'];
$users = User::whereIn('email', $emails)->get()->map(function($u){
    return [
        'email' => $u->email,
        'name' => $u->name,
        'roles' => $u->getRoleNames()->toArray(),
    ];
});

echo json_encode($users->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
