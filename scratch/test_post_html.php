<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);

$slug = 'on-demand-chiller-rental-services-for-uae-businesses';
$request = Request::create('/'.$slug, 'GET');
$response = $kernel->handle($request);
$html = $response->getContent();

echo 'Post HTML length: '.strlen($html)."\n";
echo 'Has Schema: '.(str_contains($html, 'application/ld+json') ? 'YES' : 'NO')."\n";
echo 'Title tag: '.(preg_match('/<title>(.*?)<\/title>/', $html, $m) ? $m[1] : 'NOT FOUND')."\n";
echo 'Meta description: '.(preg_match('/<meta name="description" content="(.*?)"/', $html, $m) ? $m[1] : 'NOT FOUND')."\n";
echo 'Featured image in HTML: '.(preg_match('/<img[^>]+src="([^">]+)"[^>]+fetchpriority="high"/', $html, $m) ? $m[1] : 'NOT FOUND')."\n";
