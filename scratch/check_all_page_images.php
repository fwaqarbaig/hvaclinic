<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

echo "=== CHECKING ALL <img> TAGS ACROSS KEY PAGES ===\n";

$pages = [
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
    '/contact-us',
    '/blog',
    '/post/generator-sizing-guide-dubai-construction-kva',
    '/fleet/50-kva',
];

$allImages = [];
$brokenImages = [];

foreach ($pages as $p) {
    $req = Request::create($p, 'GET');
    $resp = $app->handle($req);
    $html = $resp->getContent();

    preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $html, $matches);
    foreach ($matches[1] as $src) {
        $src = trim($src);
        if (str_starts_with($src, 'data:')) {
            continue;
        }

        $allImages[$src][] = $p;
    }
}

echo 'Found '.count($allImages)." distinct image sources across pages.\n";

foreach ($allImages as $src => $fromPages) {
    // Check if URL or local path
    $path = $src;
    if (str_starts_with($src, 'http://') || str_starts_with($src, 'https://')) {
        $parsed = parse_url($src);
        $path = $parsed['path'] ?? '';
    }

    $localFile = public_path(ltrim($path, '/'));
    if (! file_exists($localFile)) {
        // Test if double storage
        $brokenImages[] = [
            'src' => $src,
            'expected_file' => $localFile,
            'pages' => $fromPages,
        ];
    }
}

echo 'Broken image count: '.count($brokenImages)."\n";
foreach ($brokenImages as $bi) {
    echo "  [BROKEN IMAGE] {$bi['src']}\n";
    echo "     Expected on disk: {$bi['expected_file']}\n";
    echo '     Found on pages: '.implode(', ', array_unique($bi['pages']))."\n";
}
