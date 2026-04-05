<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

foreach (User::all() as $u) {
    $roles = implode(',', $u->getRoleNames()->toArray());
    $perms = implode(',', $u->getPermissionNames()->toArray());
    echo "{$u->getKey()} {$u->email} Roles:[{$roles}] Perms:[{$perms}]\n";
}
