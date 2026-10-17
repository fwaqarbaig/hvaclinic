<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);

$urls = [
    '/services/rental-chiller-in-uae/rental-chiller-in-dubai',
    '/services/rental-ac-in-uae/floor-standing-ac-rental-in-uae',
    '/category/blog',
    '/category/rentalpower',
];

foreach ($urls as $u) {
    $request = Request::create($u, 'GET');
    $response = $kernel->handle($request);
    echo sprintf("%-60s [%d]\n", $u, $response->getStatusCode());
    $kernel->terminate($request, $response);
}
