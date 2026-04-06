<?php
// Small script to send a test email using the Laravel app bootstrap.
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $mailer = $app->make('mailer');
    $to = 'stivendarwinvegamogollon@gmail.com';
    $mailer->raw('Prueba de envío desde script', function ($m) use ($to) {
        $m->to($to)->subject('Prueba desde script');
    });
    echo "Mail send attempted\n";
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
}
