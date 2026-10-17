<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use App\Models\Product;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

echo "=== TESTING APPLICATION ROUTES & INTERNAL LINKS ===\n";

$routes = [
    '/',
    '/about-us',
    '/fleet',
    '/services',
    '/service/rental-power',
    '/service/power-plant',
    '/service/amc-generator',
    '/service/maintenance',
    '/service/portacabin',
    '/service/we-offer',
    '/service/new-generators',
    '/used-refurbished-generators',
    '/industries',
    '/locations',
    '/locations/dubai',
    '/locations/abu-dhabi',
    '/locations/sharjah',
    '/locations/ajman',
    '/locations/ras-al-khaimah',
    '/locations/fujairah',
    '/locations/umm-al-quwain',
    '/locations/oman',
    '/contact-us',
    '/blog',
    '/sitemap.xml',
    '/robots.txt',
];

$errors = [];
$redirects = [];
$ok = [];

foreach ($routes as $uri) {
    try {
        $req = Request::create($uri, 'GET');
        $resp = $app->handle($req);
        $status = $resp->getStatusCode();

        if ($status === 200) {
            $ok[] = "$uri (200 OK)";
        } elseif ($status >= 300 && $status < 400) {
            $loc = $resp->headers->get('Location');
            $redirects[] = "$uri ($status -> $loc)";
        } else {
            $errors[] = "$uri ($status Error)";
        }
    } catch (Throwable $e) {
        $errors[] = "$uri (Exception: ".$e->getMessage().')';
    }
}

echo 'Working (200 OK): '.count($ok)."\n";
echo 'Redirects (30x): '.count($redirects)."\n";
foreach ($redirects as $r) {
    echo "  - $r\n";
}
echo 'Errors: '.count($errors)."\n";
foreach ($errors as $e) {
    echo "  - $e\n";
}

// Test Sample Blog Posts
echo "\n--- Testing Sample 10 Blog Post URLs ---\n";
$posts = Post::take(10)->get();
foreach ($posts as $p) {
    $uri = '/post/'.$p->slug;
    $req = Request::create($uri, 'GET');
    $resp = $app->handle($req);
    $status = $resp->getStatusCode();
    if ($status !== 200) {
        echo "  [FAIL] $uri -> Status: $status\n";
    } else {
        echo "  [OK] $uri\n";
    }
}

// Test Fleet Product URLs
echo "\n--- Testing Products/Fleet URLs ---\n";
$prods = Product::all();
echo 'Total products: '.$prods->count()."\n";
foreach ($prods as $pr) {
    $uri = '/fleet/'.$pr->slug;
    $req = Request::create($uri, 'GET');
    $resp = $app->handle($req);
    $status = $resp->getStatusCode();
    if ($status !== 200) {
        echo "  [FAIL] $uri -> Status: $status\n";
    } else {
        echo "  [OK] $uri\n";
    }
}
