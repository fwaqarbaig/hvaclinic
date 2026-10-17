<?php

use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$routes = [
    '/',
    '/about-us',
    '/fleet',
    '/services',
    '/industries',
    '/used-refurbished-generators',
    '/locations',
    '/locations/dubai',
    '/blog',
    '/contact-us',
    '/sitemap.xml',
    '/robots.txt',
];

// Add each service URL
foreach (Service::all() as $s) {
    $routes[] = '/service/'.$s->slug;
}

// Add sample fleet items
foreach (Product::take(5)->get() as $p) {
    $routes[] = '/fleet/'.$p->slug;
}

// Add sample blog posts
foreach (Post::where('status', 'published')->take(5)->get() as $p) {
    $routes[] = '/post/'.$p->slug;
}

// Add sample pages
foreach (Page::all() as $pg) {
    $routes[] = '/page/'.$pg->slug;
}

echo 'Testing '.count($routes)." frontend URLs...\n";
$errors = 0;

foreach ($routes as $uri) {
    $req = Request::create($uri, 'GET');
    try {
        $res = $app->handle($req);
        $status = $res->getStatusCode();
        if ($status !== 200) {
            echo "NON-200: $uri -> $status\n";
            $errors++;
        } else {
            // Check if response contains any obvious 404 or missing image
            $content = $res->getContent();
            echo "200 OK: $uri (len: ".strlen($content).")\n";
        }
    } catch (Throwable $e) {
        echo "EXCEPTION on $uri: ".$e->getMessage()."\n";
        $errors++;
    }
}

echo "\nSummary: Tested ".count($routes)." routes. Errors: $errors\n";
