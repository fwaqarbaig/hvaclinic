<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);

echo "=== TESTING BLOG SEARCH FOR SYNCD POSTS ===\n";

$searchQueries = [
    'Rental Cooling in UAE',
    'Rental AC in Dubai',
    'Chiller Maintenance in Dubai',
];

foreach ($searchQueries as $q) {
    $request = Request::create('/blog?q='.urlencode($q), 'GET');
    $response = $kernel->handle($request);
    $status = $response->getStatusCode();
    $content = $response->getContent();
    $found = str_contains($content, $q);
    echo "Query: \"$q\" -> Status: $status | Post Title Present in Search Results: ".($found ? 'YES' : 'NO')."\n";
    $kernel->terminate($request, $response);
}

// Test direct post rendering
echo "\n=== TESTING DIRECT POST SHOW RENDERING ===\n";
$request = Request::create('/rental-cooling-in-uae/', 'GET');
$response = $kernel->handle($request);
$status = $response->getStatusCode();
$content = $response->getContent();
echo "URL /rental-cooling-in-uae/ Status: $status | Has Content: ".(str_contains($content, 'Rental Cooling') ? 'YES' : 'NO')."\n";
$kernel->terminate($request, $response);
