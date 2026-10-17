<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);

$request = Request::create('/', 'GET');
$response = $kernel->handle($request);
$html = $response->getContent();

echo 'Home HTML length: '.strlen($html)."\n";
echo 'Has Schema: '.(str_contains($html, 'application/ld+json') ? 'YES' : 'NO')."\n";
echo 'Has Canonical: '.(str_contains($html, 'rel="canonical"') ? 'YES' : 'NO')."\n";
echo 'Title tag: '.(preg_match('/<title>(.*?)<\/title>/', $html, $m) ? $m[1] : 'NOT FOUND')."\n";
echo 'Meta description: '.(preg_match('/<meta name="description" content="(.*?)"/', $html, $m) ? $m[1] : 'NOT FOUND')."\n";
echo "Preview first 500 chars of body:\n";
if (preg_match('/<body[^>]*>(.*?)<\/body>/s', $html, $m)) {
    echo substr(strip_tags($m[1]), 0, 500)."\n";
}
