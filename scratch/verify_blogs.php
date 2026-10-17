<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);

echo "=== VERIFYING BLOGS ===\n";

$urls = [
    '/blog/' => 'Blog Index',
    '/category/blog/' => 'Blog Category Archive',
    '/rental-cooling-in-uae/' => 'Rental Cooling in UAE Post',
    '/rental-cooling-in-dubai/' => 'Rental Cooling in Dubai Post',
    '/chiller-maintenance-in-dubai/' => 'Chiller Maintenance in Dubai Post',
    '/services/rental-cooling/rental-cooling-in-uae/' => 'Original Page URL Still Accessible',
];

foreach ($urls as $uri => $label) {
    $request = Request::create($uri, 'GET');
    $response = $kernel->handle($request);
    $status = $response->getStatusCode();
    echo "URL: $uri ($label) -> Status: $status\n";
    $kernel->terminate($request, $response);
}

// Check category content
$request = Request::create('/category/blog/', 'GET');
$response = $kernel->handle($request);
$content = $response->getContent();

$expected = [
    'Blog',
    'Rental Cooling in UAE',
    'Rental Cooling in Dubai',
];

echo "\nChecking Blog Category Content:\n";
foreach ($expected as $exp) {
    if (str_contains($content, $exp)) {
        echo "[FOUND] \"$exp\"\n";
    } else {
        echo "[MISSING] \"$exp\"\n";
    }
}
