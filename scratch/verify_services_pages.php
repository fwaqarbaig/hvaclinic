<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);

$urlsToTest = [
    'services' => '/services',
    'rental-cooling' => '/services/rental-cooling',
    'rental-ac-in-uae' => '/services/rental-ac-in-uae',
    'wild-air-rental-in-uae' => '/services/wild-air-rental-in-uae',
    'chiller-maintenance-in-uae' => '/services/chiller-maintenance-in-uae',
    'generator-rental-in-uae' => '/services/generator-rental-in-uae',
    'generator-maintenance-repair-in-uae' => '/services/generator-maintenance-repair-in-uae',
    'used-refurbished-equipment-in-uae' => '/used-refurbished-equipment-in-uae',
    'rental-chiller-in-uae (alias)' => '/services/rental-chiller-in-uae',
    'rental-power (alias)' => '/services/rental-power',
    'services/used-refurbished-equipment-in-uae (alias)' => '/services/used-refurbished-equipment-in-uae',
];

$allPassed = true;

echo '=== VERIFYING ALL 7 SERVICES & SERVICES INDEX ==='.PHP_EOL.PHP_EOL;

foreach ($urlsToTest as $name => $uri) {
    $request = Request::create($uri, 'GET');
    $response = $kernel->handle($request);
    $status = $response->getStatusCode();
    $content = $response->getContent();

    echo "Testing [{$name}] ({$uri}): Status {$status}".PHP_EOL;

    if ($status === 301 || $status === 302) {
        $target = $response->headers->get('Location');
        echo "  -> Redirects to: {$target}".PHP_EOL;
        // Follow redirect to ensure target returns 200
        $subRequest = Request::create($target, 'GET');
        $subResponse = $kernel->handle($subRequest);
        $subStatus = $subResponse->getStatusCode();
        $content = $subResponse->getContent();
        echo "  -> Target Status: {$subStatus}".PHP_EOL;
        if ($subStatus !== 200) {
            echo "  [FAIL] Target returned status {$subStatus}!".PHP_EOL;
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

    // Check <title>
    if (preg_match('/<title>(.*?)<\/title>/is', $content, $m)) {
        echo '  -> Title: '.trim($m[1]).PHP_EOL;
    } else {
        echo '  [FAIL] Missing <title>!'.PHP_EOL;
        $allPassed = false;
    }

    // Check <h1>
    if (preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $content, $m)) {
        $cleanH1 = trim(preg_replace('/\s+/', ' ', strip_tags($m[1])));
        echo "  -> H1: {$cleanH1}".PHP_EOL;
    } else {
        echo '  [FAIL] Missing <h1>!'.PHP_EOL;
        $allPassed = false;
    }

    // Check Schema.org
    if (str_contains($content, '"@context"') && (str_contains($content, '"Service"') || str_contains($content, '"ItemList"'))) {
        echo '  -> Schema.org JSON-LD: OK'.PHP_EOL;
    } else {
        echo '  [FAIL] Missing Schema.org JSON-LD!'.PHP_EOL;
        $allPassed = false;
    }

    // Check for old Generator Dubai phone
    if (str_contains($content, '569213754') || str_contains($content, '+971 56 921 3754')) {
        echo '  [FAIL] Found old Generator Dubai phone number 569213754 in content!'.PHP_EOL;
        $allPassed = false;
    } else {
        echo '  -> Phone check (HVAC Clinic +971 50 369 2131): Clean'.PHP_EOL;
    }

    // Check for FAQPage schema on service pages
    if (str_contains($uri, 'rental') || str_contains($uri, 'chiller') || str_contains($uri, 'equipment') || str_contains($uri, 'generator')) {
        if (str_contains($content, '"FAQPage"')) {
            echo '  -> FAQPage Schema: OK'.PHP_EOL;
        }
    }

    echo PHP_EOL;
}

if ($allPassed) {
    echo '=== ALL VERIFICATIONS PASSED SUCCESSFULLY! ==='.PHP_EOL;
} else {
    echo '=== SOME CHECKS FAILED! PLEASE REVIEW ABOVE! ==='.PHP_EOL;
}
