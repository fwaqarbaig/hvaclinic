<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

$urls = [
    '/locations/dubai',
    '/locations/abu-dhabi',
    '/locations/sharjah',
    '/locations/ajman',
    '/rental-chiller-in-dubai/',
    '/services/rental-chiller-in-uae/rental-chiller-in-dubai/',
    '/services/rental-chiller-in-uae/rental-chiller-in-abu-dhabi/',
    '/services/rental-chiller-in-uae/rental-chiller-in-sharjah/',
];

foreach ($urls as $url) {
    $req = Request::create($url, 'GET');
    $res = $kernel->handle($req);
    $status = $res->getStatusCode();
    $target = $res->headers->get('Location');
    echo sprintf("%-60s -> %s %s\n", $url, $status, $target ? "(-> $target)" : "");
}
