<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$checks = [
    '/about' => '/about-us',
    '/contact' => '/contact-us',
    '/products' => '/fleet',
    '/product/50-kva' => '/fleet/50-kva',
    '/products/50-kva' => '/fleet/50-kva',
    '/services/rental-power' => '/service/rental-power',
    '/used-generators' => '/used-refurbished-generators',
];

foreach ($checks as $from => $expectedTarget) {
    $request = Request::create($from, 'GET');
    $response = $app->handle($request);
    $status = $response->getStatusCode();
    $target = $response->headers->get('Location');
    $pass = ($status === 301 && str_ends_with($target, $expectedTarget)) ? 'PASS' : 'FAIL';
    echo "[{$pass}] {$from} -> Status: {$status}, Location: {$target} (Expected: {$expectedTarget})\n";
}
