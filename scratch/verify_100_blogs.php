<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo '=== COMPREHENSIVE 100 BLOG VERIFICATION ==='.PHP_EOL.PHP_EOL;

$publishedCount = Post::published()->count();
echo "Total published posts in database: {$publishedCount}".PHP_EOL;
if ($publishedCount < 277) {
    echo "[FAIL] Expected at least 277 posts, found {$publishedCount}!".PHP_EOL;
    exit(1);
} else {
    echo '[PASS] Total published posts check OK.'.PHP_EOL;
}

echo PHP_EOL.'--- Checking Categories & Post Counts ---'.PHP_EOL;
$cats = ['chiller-rental', 'rental-cooling', 'rental-ac', 'wild-air', 'chiller-maintenance', 'chiller-amc', 'used-chillers', 'rental-power', 'packaged-units'];
foreach ($cats as $slug) {
    $cat = Category::where('slug', $slug)->first();
    if (! $cat) {
        echo "[FAIL] Category missing: {$slug}".PHP_EOL;
    } else {
        $count = $cat->posts()->published()->count();
        echo "  Category '{$cat->name}' ({$slug}): {$count} published posts.".PHP_EOL;
    }
}

echo PHP_EOL.'--- Checking Representative Articles Across All 8 Clusters ---'.PHP_EOL;
$sampleSlugs = [
    'Cluster 1' => 'temporary-chiller-sizing-concrete-batching-plants-uae',
    'Cluster 2' => 'fast-track-fitout-rental-ac-drywall-protection-dubai',
    'Cluster 3' => 'what-is-wild-air-uae-construction-fitout-protection',
    'Cluster 4' => 'comprehensive-chiller-preventive-maintenance-checklist-uae',
    'Cluster 5' => 'comprehensive-vs-non-comprehensive-chiller-amc-uae',
    'Cluster 6' => '15-point-inspection-checklist-buying-used-chillers-uae',
    'Cluster 7' => 'motor-starting-inrush-sizing-chiller-generators-uae',
    'Cluster 8' => 'commercial-disaster-recovery-chiller-power-readiness-uae',
];

$allPassed = true;

foreach ($sampleSlugs as $clusterName => $slug) {
    $uri = '/'.$slug;
    $req = Request::create($uri, 'GET');
    $res = $kernel->handle($req);
    $status = $res->getStatusCode();
    $html = $res->getContent();

    echo "Testing [{$clusterName}] ({$uri}): Status {$status}";
    if ($status === 200) {
        echo ' [OK]'.PHP_EOL;
        // Verify key components
        $hasTable = str_contains($html, '<table');
        $hasFaq = str_contains($html, '<details');
        $hasSchema = str_contains($html, '"@type": "Article"') || str_contains($html, '"@type":"Article"');
        $hasPhone = str_contains($html, '+971 50 369 2131');
        $hasInternalLink = str_contains($html, '/services/');

        echo '    Table: '.($hasTable ? 'YES' : 'NO');
        echo ' | FAQs: '.($hasFaq ? 'YES' : 'NO');
        echo ' | Schema Article: '.($hasSchema ? 'YES' : 'NO');
        echo ' | Internal Links: '.($hasInternalLink ? 'YES' : 'NO');
        echo ' | Hotline: '.($hasPhone ? 'YES' : 'NO').PHP_EOL;

        if (! $hasTable || ! $hasFaq || ! $hasSchema || ! $hasPhone) {
            $allPassed = false;
        }
    } else {
        echo ' [FAIL]'.PHP_EOL;
        $allPassed = false;
    }
}

echo PHP_EOL.'--- Checking Category Archive Pages ---'.PHP_EOL;
foreach (['/category/chiller-rental', '/category/wild-air', '/category/rental-power', '/category/chiller-amc'] as $catUri) {
    $req = Request::create($catUri, 'GET');
    $res = $kernel->handle($req);
    $status = $res->getStatusCode();
    echo "Testing Category Archive ({$catUri}): Status {$status}".($status === 200 ? ' [OK]' : ' [FAIL]').PHP_EOL;
    if ($status !== 200) {
        $allPassed = false;
    }
}

echo PHP_EOL.'--- Checking Search & Pagination ---'.PHP_EOL;
$searchUris = [
    '/blog?q=rental+chiller',
    '/blog?q=wild+air',
    '/blog?q=generator',
    '/blog?q=refurbished',
    '/blog?page=2',
    '/blog?page=15',
    '/blog?page=23',
];
foreach ($searchUris as $sUri) {
    $req = Request::create($sUri, 'GET');
    $res = $kernel->handle($req);
    $status = $res->getStatusCode();
    echo "Testing ({$sUri}): Status {$status}".($status === 200 ? ' [OK]' : ' [FAIL]').PHP_EOL;
    if ($status !== 200) {
        $allPassed = false;
    }
}

echo PHP_EOL.'--- Checking XML Sitemaps ---'.PHP_EOL;
foreach (['/sitemap.xml', '/post-sitemap.xml', '/sitemap_index.xml'] as $sitemapUri) {
    $req = Request::create($sitemapUri, 'GET');
    $res = $kernel->handle($req);
    $status = $res->getStatusCode();
    $xml = $res->getContent();
    $urlCount = substr_count($xml, '<loc>');
    echo "Sitemap ({$sitemapUri}): Status {$status} | URL Count: {$urlCount}".($status === 200 && $urlCount > 0 ? ' [OK]' : ' [FAIL]').PHP_EOL;
    if ($status !== 200 || $urlCount === 0) {
        $allPassed = false;
    }
}

echo PHP_EOL.'=== OVERALL VERIFICATION: '.($allPassed ? 'PASSED 100%' : 'FAILURES DETECTED').' ==='.PHP_EOL;
