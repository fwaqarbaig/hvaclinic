<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);

$routesToTest = [
    '/',
    '/about-us',
    '/contact-us',
    '/fleet',
    '/fleet/50-kva',
    '/fleet/1000-kva',
    '/services',
    '/service/rental-power',
    '/service/amc-generator',
    '/industries',
    '/used-refurbished-generators',
    '/locations',
    '/locations/dubai',
    '/locations/abu-dhabi',
    '/blog',
    '/post/generator-sizing-guide-dubai-construction-kva',
    '/post/prime-vs-standby-generator-power-uae-iso8528',
    '/category/rental-power',
    '/category/dubai',
];

echo "Testing frontend routes and verifying Schema.org JSON-LD rendering:\n\n";

$passCount = 0;
foreach ($routesToTest as $uri) {
    $request = Request::create($uri, 'GET');
    $response = $kernel->handle($request);
    $status = $response->getStatusCode();
    $content = $response->getContent();

    $hasSchemaTag = str_contains($content, 'application/ld+json');
    $hasSchemaOrg = str_contains($content, 'schema.org');

    if ($status === 200 && $hasSchemaTag && $hasSchemaOrg) {
        echo "✓ [{$status}] {$uri} -> Schema JSON-LD detected successfully!\n";
        $passCount++;
    } else {
        echo "✗ [{$status}] {$uri} -> Failed! (status={$status}, hasTag=".($hasSchemaTag ? 'yes' : 'no').', hasOrg='.($hasSchemaOrg ? 'yes' : 'no').")\n";
    }
}

echo "\nSummary: {$passCount} / ".count($routesToTest)." routes passed schema verification!\n";
