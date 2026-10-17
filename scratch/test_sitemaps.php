<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);

$sitemapUrls = [
    '/sitemap_index.xml',
    '/sitemap.xml',
    '/page-sitemap.xml',
    '/service-sitemap.xml',
    '/post-sitemap.xml',
    '/category-sitemap.xml',
    '/author-sitemap.xml',
    '/robots.txt',
];

foreach ($sitemapUrls as $u) {
    $request = Request::create($u, 'GET');
    $response = $kernel->handle($request);
    $content = $response->getContent();
    $status = $response->getStatusCode();
    $contentType = $response->headers->get('Content-Type');
    $urlCount = substr_count($content, '<loc>');
    echo sprintf("%-25s [%d] %-30s (loc entries: %d, length: %d bytes)\n", $u, $status, $contentType, $urlCount, strlen($content));
}
