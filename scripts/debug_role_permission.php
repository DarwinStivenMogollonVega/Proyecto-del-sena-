<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\RoleCustom;
use App\Models\PermissionCustom;

$guard = config('auth.defaults.guard');
$role = RoleCustom::firstOrCreate(['name'=>'admin','guard_name'=>$guard]);
$perm = PermissionCustom::firstOrCreate(['name'=>'debug-perm-2','guard_name'=>$guard]);

echo "Role class: ".get_class($role).PHP_EOL;
echo "Role key name: ".$role->getKeyName().PHP_EOL;
echo "Role key value: ".var_export($role->getKey(), true).PHP_EOL;
print_r($role->getAttributes());

echo "Permission key name: ".$perm->getKeyName().PHP_EOL;
echo "Permission key value: ".var_export($perm->getKey(), true).PHP_EOL;
print_r($perm->getAttributes());

// Try to attach and catch exception
try {
    $role->givePermissionTo($perm);
    echo "Assigned OK\n";
} catch (Exception $e) {
    echo "Assign error: " . $e->getMessage() . PHP_EOL;
}
