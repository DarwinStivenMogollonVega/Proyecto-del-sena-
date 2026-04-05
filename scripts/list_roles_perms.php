<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "Permissions in DB:\n";
foreach(Permission::all() as $p){
    echo "- {$p->id} {$p->name}\n";
}

echo "\nRoles and their permissions:\n";
foreach(Role::all() as $r){
    $perms = $r->permissions->pluck('name')->toArray();
    echo "- {$r->id} {$r->name} => [" . implode(',', $perms) . "]\n";
}
