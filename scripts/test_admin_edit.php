<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\FacturaController;

$id = $argv[1] ?? null;
if (!$id) {
    echo "Usage: php scripts/test_admin_edit.php <factura_id>\n";
    exit(1);
}

$ctrl = new FacturaController();
$response = $ctrl->adminEdit($id);

if ($response instanceof Illuminate\Contracts\View\View) {
    // dump structured data
    $data = $response->getData();
    echo "--- DATA ---\n";
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
    echo "\n--- RENDERED HTML SNIPPET ---\n";
    // render full view and print a snippet around the form
    // ensure $errors is available (normally provided by the framework in an HTTP request)
    if (!isset($GLOBALS['__view_errors_shared'])) {
        $bag = new Illuminate\Support\ViewErrorBag();
        view()->share('errors', $bag);
        $GLOBALS['__view_errors_shared'] = true;
    }
    // ensure an authenticated user exists for menu rendering
    if (!auth()->user()) {
        $u = App\Models\User::first();
        if ($u) auth()->setUser($u);
    }
    $html = $response->render();
    // find form that posts to admin.facturas.update (contains '/admin/facturas/')
    if (preg_match_all('/<form[\s\S]*?<\/form>/', $html, $forms)) {
        $found = false;
        foreach ($forms[0] as $f) {
            if (strpos($f, '/admin/facturas') !== false) {
                echo $f;
                $found = true;
                break;
            }
        }
        if (!$found) {
            echo $forms[0][0] ?? substr($html, 0, 2000);
        }
    } else {
        echo substr($html, 0, 2000);
    }
} else {
    echo "Controller did not return a view.\n";
}

return 0;
