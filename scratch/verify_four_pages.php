<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);

$pagesToTest = [
    '/about/' => [
        'name' => 'About',
        'mustSee' => [
            'About HVAC Clinic',
            'Setting the UAE Industry Standard',
            'We specialize in:',
            'Rental Cooling',
            'Rental Power',
            'Get Free Appointment',
            '/wp-content/uploads/2026/03/g-2.jpg',
            '+971 50 369 2131',
        ],
    ],
    '/our-team/' => [
        'name' => 'Our Team',
        'mustSee' => [
            'Our Leadership Team',
            'IMRAN ALI',
            'Managing Director',
            'RAGHIB WAQAS',
            'Entity Partner &amp; Business Developer',
            '/wp-content/uploads/2026/03/imran.jpg',
            '/wp-content/uploads/2026/03/raghi.jpg',
            'Harvard Business School',
            'Caterpillar University',
        ],
    ],
    '/membership/' => [
        'name' => 'Membership',
        'mustSee' => [
            'Official Membership Certificates',
            'HVAC &amp; Power Solution FZE',
            'Verified Industry Credentials',
            '/wp-content/uploads/2026/03/a.jpg',
            '/wp-content/uploads/2026/03/b.jpg',
            '/wp-content/uploads/2026/03/c.jpg',
            '/wp-content/uploads/2026/03/d.jpg',
        ],
    ],
    '/certificates/' => [
        'name' => 'Certificates',
        'mustSee' => [
            'Certificates of Achievement',
            'HVAC &amp; Power Solution FZE',
            '/wp-content/uploads/2026/03/a-1.jpg',
            '/wp-content/uploads/2026/03/b-1.jpg',
            '/wp-content/uploads/2026/03/c-1.jpg',
            '/wp-content/uploads/2026/03/d-1.jpg',
            '/wp-content/uploads/2026/03/e.jpg',
            '/wp-content/uploads/2026/03/f.jpg',
            '/wp-content/uploads/2026/03/g.jpg',
            '/wp-content/uploads/2026/03/h.jpg',
            '/wp-content/uploads/2026/03/i.jpg',
            '/wp-content/uploads/2026/03/j.jpg',
        ],
    ],
];

echo "=== VERIFYING ABOUT, OUR TEAM, MEMBERSHIP & CERTIFICATES ===\n";
$allOk = true;

foreach ($pagesToTest as $uri => $data) {
    $request = Request::create($uri, 'GET');
    $response = $kernel->handle($request);
    $status = $response->getStatusCode();
    $content = $response->getContent();

    echo "\nTesting: {$data['name']} ($uri)\n";
    echo "  Status: $status\n";
    if ($status !== 200) {
        echo "  [FAIL] Expected status 200, got $status\n";
        $allOk = false;

        continue;
    }

    foreach ($data['mustSee'] as $str) {
        if (str_contains($content, $str)) {
            echo "  [FOUND] $str\n";
        } else {
            echo "  [MISSING] $str\n";
            $allOk = false;
        }
    }

    $kernel->terminate($request, $response);
}

echo "\n==========================================\n";
echo $allOk ? 'ALL 4 PAGES VERIFIED 100% PERFECT!' : 'ERRORS ENCOUNTERED';
echo "\n==========================================\n";
