<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$paths = ['/services', '/contact', '/about', '/site-directory'];
foreach ($paths as $path) {
    $res = $kernel->handle(\Illuminate\Http\Request::create($path, 'GET'));
    if (preg_match('/<link rel="canonical" href="(.*?)"/', $res->getContent(), $m)) {
        echo sprintf("%-20s -> Canonical: %s\n", $path, $m[1]);
    } else {
        echo sprintf("%-20s -> Canonical NOT FOUND\n", $path);
    }
}
