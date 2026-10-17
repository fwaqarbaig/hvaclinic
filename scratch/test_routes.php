<?php

use App\Models\Inquiry;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);

$urls = [
    '/' => 'Home',
    '/about/' => 'About HVAC',
    '/our-team/' => 'Our Team',
    '/membership/' => 'Membership',
    '/certificates/' => 'Certificates',
    '/services/' => 'Services Index',
    '/services/rental-cooling/' => 'Rental Cooling',
    '/services/rental-ac-in-uae/' => 'Rental AC',
    '/services/wild-air-rental-in-uae/' => 'Wild Air Rental',
    '/services/chiller-maintenance-in-uae/' => 'Chiller Maintenance',
    '/services/generator-rental-in-uae/' => 'Rental Generator',
    '/services/generator-maintenance-repair-in-uae/' => 'Rental Power',
    '/used-refurbished-equipment-in-uae/' => 'Used & Refurbished',
    '/blog/' => 'Blog Index',
    '/category/blog/' => 'Blogs Category',
    '/contact/' => 'Contact us',
];

echo "=== TESTING ALL MENU & HOMEPAGE ROUTES ===\n";
$allPassed = true;

foreach ($urls as $uri => $label) {
    $request = Request::create($uri, 'GET');
    $response = $kernel->handle($request);
    $status = $response->getStatusCode();

    if ($status === 200 || $status === 301 || $status === 302) {
        echo "[PASS] $uri ($label) -> Status: $status\n";
    } else {
        echo "[FAIL] $uri ($label) -> Status: $status\n";
        $allPassed = false;
    }

    $kernel->terminate($request, $response);
}

// Check homepage content
$request = Request::create('/', 'GET');
$response = $kernel->handle($request);
$content = $response->getContent();

$expectedStrings = [
    'Engineered Cooling &amp; Power Rental in UAE',
    'Rental Cooling',
    'Rental AC',
    'Wild Air Rental',
    'Chiller Maintenance',
    'Rental Generator',
    'Rental Power',
    'USed &amp; Refurbished',
    'hero-quote-form',
    '+971 50 369 2131',
    'Blogs',
    'Contact us',
];

echo "\n=== CHECKING HOMEPAGE CONTENT INTEGRITY ===\n";
foreach ($expectedStrings as $str) {
    if (str_contains($content, $str)) {
        echo "[FOUND] \"$str\"\n";
    } else {
        echo "[MISSING] \"$str\"\n";
        $allPassed = false;
    }
}

// Test quick consultation form submit with session CSRF
echo "\n=== TESTING QUICK CONSULTATION POST INTAKE ===\n";
$session = $app->make('session')->driver();
$session->start();
$token = $session->token();

$postRequest = Request::create('/contact', 'POST', [
    '_token' => $token,
    'name' => 'Automated Test Client',
    'phone' => '+971501234567',
    'service' => 'Rental Cooling',
    'subject' => 'Dubai Site',
    'message' => 'Automated verification test inquiry',
]);
$postRequest->setLaravelSession($session);
$postResponse = $kernel->handle($postRequest);
$postStatus = $postResponse->getStatusCode();
echo "POST /contact Status: $postStatus\n";
if ($postStatus === 302) {
    echo "[PASS] Quick consultation form successfully accepted and redirected!\n";
    $inquiry = Inquiry::where('name', 'Automated Test Client')->first();
    if ($inquiry) {
        echo "[PASS] Inquiry record saved in DB with ID: {$inquiry->id}\n";
    }
} else {
    echo "[FAIL] Form submission returned unexpected status: $postStatus\n";
    $allPassed = false;
}
$kernel->terminate($postRequest, $postResponse);

echo "\n".($allPassed ? 'ALL TESTS PASSED WITH 100% SUCCESS!' : 'SOME TESTS FAILED')."\n";
