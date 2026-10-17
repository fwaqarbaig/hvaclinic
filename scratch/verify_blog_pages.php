<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);

$tests = [
    'Main Blog Index' => '/blog',
    'Blog Pagination Page 2' => '/blog?page=2',
    'Blog Search Query' => '/blog?q=chiller',
    'Category Blog 301 Redirect' => '/category/blog',
    'Category Archive (rentalpower)' => '/category/rentalpower',
    'Single Post: On-Demand Chiller Rental' => '/on-demand-chiller-rental-services-for-uae-businesses',
];

$allPassed = true;

echo '=== VERIFYING BLOG PAGES & RECOVERYDATA LAYOUT ==='.PHP_EOL.PHP_EOL;

foreach ($tests as $label => $uri) {
    $request = Request::create($uri, 'GET');
    $response = $kernel->handle($request);
    $status = $response->getStatusCode();
    $content = $response->getContent();

    echo "Testing [{$label}] ({$uri}): Status {$status}".PHP_EOL;

    if ($status === 301 || $status === 302) {
        $target = $response->headers->get('Location');
        echo "  -> Redirects to: {$target}".PHP_EOL;
        $subRequest = Request::create($target, 'GET');
        $subResponse = $kernel->handle($subRequest);
        $subStatus = $subResponse->getStatusCode();
        $content = $subResponse->getContent();
        echo "  -> Target Status: {$subStatus}".PHP_EOL;
        if ($subStatus !== 200) {
            echo "  [FAIL] Redirect target failed with {$subStatus}!".PHP_EOL;
            $allPassed = false;

            continue;
        }
    } elseif ($status !== 200) {
        echo "  [FAIL] Expected 200, got {$status}!".PHP_EOL;
        $allPassed = false;

        continue;
    }

    $sizeKb = round(strlen($content) / 1024, 1);
    echo "  -> Size: {$sizeKb} KB".PHP_EOL;

    // Check Title
    if (preg_match('/<title>(.*?)<\/title>/is', $content, $m)) {
        echo '  -> Title: '.trim($m[1]).PHP_EOL;
    } else {
        echo '  [FAIL] Missing <title>!'.PHP_EOL;
        $allPassed = false;
    }

    // Check H1
    if (preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $content, $m)) {
        $cleanH1 = trim(preg_replace('/\s+/', ' ', strip_tags($m[1])));
        echo "  -> H1: {$cleanH1}".PHP_EOL;
    } else {
        echo '  [FAIL] Missing <h1>!'.PHP_EOL;
        $allPassed = false;
    }

    // Check Schema.org
    if (str_contains($content, '"@context"') && (str_contains($content, '"ItemList"') || str_contains($content, '"Article"') || str_contains($content, '"BreadcrumbList"'))) {
        echo '  -> Schema.org JSON-LD: OK'.PHP_EOL;
    } else {
        echo '  [FAIL] Missing Schema.org JSON-LD!'.PHP_EOL;
        $allPassed = false;
    }

    // Check Search bar on index/archive
    if (str_contains($uri, '/blog') || str_contains($uri, '/category/')) {
        if (str_contains($content, 'name="q"') && str_contains($content, 'Search articles...')) {
            echo '  -> Search input: OK'.PHP_EOL;
        } else {
            echo '  [FAIL] Missing search input bar!'.PHP_EOL;
            $allPassed = false;
        }
    }

    // Check 24/7 hotline and WhatsApp CTA
    if (str_contains($content, '+971 50 369 2131') || str_contains($content, '971503692131')) {
        echo '  -> HVAC Clinic Contact (+971 50 369 2131): OK'.PHP_EOL;
    } else {
        echo '  [FAIL] Missing HVAC Clinic contact info!'.PHP_EOL;
        $allPassed = false;
    }

    echo PHP_EOL;
}

if ($allPassed) {
    echo '=== ALL BLOG PAGE CHECKS PASSED SUCCESSFULLY! ==='.PHP_EOL;
} else {
    echo '=== SOME CHECKS FAILED! PLEASE REVIEW ABOVE! ==='.PHP_EOL;
}
