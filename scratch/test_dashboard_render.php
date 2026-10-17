<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$user = User::first();
Auth::login($user);

$controller = new DashboardController;
$request = Request::create('/admin', 'GET');

try {
    $response = $controller->index($request);
    $view = $response->render();
    echo 'SUCCESS: Dashboard rendered! Length: '.strlen($view)." bytes\n";
    if (strpos($view, 'Interactive Focus Keyword, Meta & Schema Code Studio') !== false) {
        echo "FOUND: Focus Keyword, Meta & Schema Code Studio is present in output!\n";
    }
    if (strpos($view, 'dashboardSeoStudio') !== false) {
        echo "FOUND: dashboardSeoStudio script is present in output!\n";
    }
} catch (Throwable $e) {
    echo 'ERROR rendering dashboard: '.$e->getMessage()."\n".$e->getTraceAsString()."\n";
}
