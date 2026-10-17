<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

echo "=== EXTRACTING AND CHECKING ALL INTERNAL LINKS FROM KEY PAGES ===\n";

$pagesToCrawl = [
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
];

$allLinks = [];
$brokenLinks = [];
$externalLinks = [];
$mailTelLinks = [];

foreach ($pagesToCrawl as $pageUri) {
    $req = Request::create($pageUri, 'GET');
    $resp = $app->handle($req);
    $html = $resp->getContent();

    // Extract hrefs
    preg_match_all('/href=["\']([^"\'#]+)["\']/i', $html, $matches);
    foreach ($matches[1] as $href) {
        $href = trim($href);
        if (empty($href) || str_starts_with($href, 'javascript:')) {
            continue;
        }
        if (str_starts_with($href, 'mailto:') || str_starts_with($href, 'tel:') || str_starts_with($href, 'https://wa.me')) {
            $mailTelLinks[$href] = true;

            continue;
        }
        if (str_starts_with($href, 'http://') || str_starts_with($href, 'https://')) {
            $parsed = parse_url($href);
            $host = $parsed['host'] ?? '';
            if ($host !== 'localhost' && $host !== '127.0.0.1' && $host !== 'generatordubai.com' && $host !== 'www.generatordubai.com') {
                $externalLinks[$href] = $pageUri;

                continue;
            }
            $href = ($parsed['path'] ?? '/').(isset($parsed['query']) ? '?'.$parsed['query'] : '');
        }

        $allLinks[$href][] = $pageUri;
    }
}

echo 'Total unique internal links found: '.count($allLinks)."\n";
echo 'External links found: '.count($externalLinks)."\n";
foreach ($externalLinks as $ext => $from) {
    echo "  - $ext (found on $from)\n";
}

echo "\n--- Checking internal link HTTP status codes ---\n";
foreach (array_keys($allLinks) as $link) {
    // Ignore static asset links like .css, .js, .ico for route testing, but check file existence
    if (preg_match('/\.(css|js|png|jpg|jpeg|webp|svg|ico)$/i', $link)) {
        $filePath = public_path(ltrim($link, '/'));
        if (! file_exists($filePath)) {
            $brokenLinks[] = [
                'link' => $link,
                'status' => 'Missing static asset',
                'pages' => $allLinks[$link],
            ];
        }

        continue;
    }

    try {
        $req = Request::create($link, 'GET');
        $resp = $app->handle($req);
        $status = $resp->getStatusCode();
        if ($status !== 200 && $status !== 301 && $status !== 302) {
            $brokenLinks[] = [
                'link' => $link,
                'status' => $status,
                'pages' => $allLinks[$link],
            ];
        }
    } catch (Throwable $e) {
        $brokenLinks[] = [
            'link' => $link,
            'status' => 'Exception: '.$e->getMessage(),
            'pages' => $allLinks[$link],
        ];
    }
}

echo 'Broken internal links count: '.count($brokenLinks)."\n";
foreach ($brokenLinks as $bl) {
    echo "  [BROKEN] {$bl['link']} (Status: {$bl['status']})\n";
    echo '    Found on: '.implode(', ', array_unique($bl['pages']))."\n";
}
