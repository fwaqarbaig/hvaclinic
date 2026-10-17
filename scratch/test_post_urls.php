<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

$sampleSlugs = [
    'size-50-kva-generator-uae',
    'generator-rental-jafza-dubai-permits',
    'generator-amc-contract-checklist-dubai',
    'multi-megawatt-generator-synchronization-uae',
    'temporary-power-marine-shipyards-drydock-uae',
    'value-used-diesel-generator-uae-hours',
    'used-portacabins-dubai-buyers-guide',
    '50-person-construction-compound-portacabin-design',
];

echo "Testing single post views across all 8 clusters:\n";
foreach ($sampleSlugs as $slug) {
    $request = Request::create("/post/{$slug}", 'GET');
    $response = $app->handle($request);
    $status = $response->getStatusCode();
    $content = $response->getContent();
    $hasSchema = str_contains($content, 'application/ld+json');
    $hasFaq = str_contains($content, 'FAQPage');
    $hasOgImage = str_contains($content, 'og:image');

    echo sprintf(
        "Post /post/%-48s -> Status: %d | Schema: %s | FAQ: %s | OG: %s\n",
        substr($slug, 0, 48),
        $status,
        $hasSchema ? 'YES' : 'NO',
        $hasFaq ? 'YES' : 'NO',
        $hasOgImage ? 'YES' : 'NO'
    );
}

// Check sitemap-posts.xml
$requestSitemap = Request::create('/sitemap-posts.xml', 'GET');
$respSitemap = $app->handle($requestSitemap);
echo "\nSitemap /sitemap-posts.xml Status: ".$respSitemap->getStatusCode()."\n";
$sitemapXml = $respSitemap->getContent();
$urlCount = substr_count($sitemapXml, '<loc>');
echo "Total URLs in sitemap-posts.xml: {$urlCount}\n";
