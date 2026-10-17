<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$urls = [
    '/locations/ajman',
    '/locations/ras-al-khaimah',
    '/locations/fujairah',
    '/locations/umm-al-quwain',
    '/locations/oman',
    '/blog',
    '/contact',
    '/services/we-offer',
    '/services/maintenance',
    '/services/new-generators',
    '/services/used-refurbished-generators',
    '/fleet/100-kva',
    '/fleet/150-kva',
    '/fleet/200-kva',
    '/fleet/250-kva',
    '/fleet/300-kva',
    '/fleet/350-kva',
    '/fleet/600-kva',
    '/fleet/800-kva',
    '/fleet/1250-kva',
];

echo "Testing Additional Routes...\n";
$allPass = true;
foreach ($urls as $uri) {
    $request = Request::create($uri, 'GET');
    $response = $kernel->handle($request);
    $status = $response->getStatusCode();
    $isOk = in_array($status, [200, 301, 302]);
    echo sprintf("[%s] %s -> HTTP %d\n", $isOk ? 'PASS' : 'FAIL', $uri, $status);
    if (! $isOk) {
        $allPass = false;
    }
}
echo $allPass ? "ALL ADDITIONAL ROUTES PASS!\n" : "SOME FAILED!\n";
