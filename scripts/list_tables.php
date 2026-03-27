<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
// Bootstrap the framework
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$db = $app->make('db');
try {
    $rows = $db->select('SHOW TABLES');
    if (empty($rows)) {
        echo "(no tables)\n";
        exit(0);
    }
    foreach ($rows as $r) {
        foreach ((array)$r as $v) {
            echo $v . PHP_EOL;
        }
    }
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
