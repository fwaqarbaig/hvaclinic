<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

Cache::flush();

$routes = [
    '/robots.txt',
    '/sitemap.xml',
    '/sitemap-index.xml',
    '/sitemap-products.xml',
    '/sitemap-services.xml',
    '/sitemap-posts.xml',
    '/sitemap-pages.xml',
    '/sitemap-categories.xml',
];

foreach ($routes as $uri) {
    $request = Request::create($uri, 'GET');
    $response = $app->handle($request);
    $status = $response->getStatusCode();
    $length = strlen($response->getContent());
    echo "Endpoint {$uri} => Status: {$status}, Content-Length: {$length}\n";
    if ($uri === '/robots.txt') {
        echo "Robots content:\n".$response->getContent()."\n";
    }
}
