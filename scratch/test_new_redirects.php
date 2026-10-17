<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

$urls = [
    '/services/generator-rental-in-uae/generator-repair-abu-dhabi/',
    '/services/generator-rental-in-uae/generator-amc-uae/',
    '/services/generator-maintenance-repair-in-uae/generator-repair-in-dubai/',
    '/services/generator-maintenance-repair-in-uae/generator-repair-uae/',
    '/services/rental-ac-in-uae/rental-ac-in-abu-dhabi/',
    '/generator-repair-in-abu-dhabi/',
    '/generator-amc-in-uae/',
    '/generator-repair-dubai/',
    '/generator-repair-in-uae/',
    '/rental-ac-in-abu-dhabi/',
];

foreach ($urls as $url) {
    $req = Request::create($url, 'GET');
    $res = $kernel->handle($req);
    $status = $res->getStatusCode();
    $target = $res->headers->get('Location');
    echo sprintf("%-75s -> %s %s\n", $url, $status, $target ? "(-> $target)" : "");
}
