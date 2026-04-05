<?php
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$m = config('permission.models.permission');
$res = $m::firstOrCreate(['name'=>'debug-test-perm','guard_name'=>config('auth.defaults.guard')]);
echo 'Model class: '.get_class($res).PHP_EOL;
echo 'Key name: '.$res->getKeyName().PHP_EOL;
echo 'Key value: '.var_export($res->getKey(), true).PHP_EOL;
print_r($res->getAttributes());
