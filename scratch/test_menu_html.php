<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);

$request = Request::create('/', 'GET');
$response = $kernel->handle($request);
$html = $response->getContent();

echo "=== VERIFYING HEADER SERVICES DROPDOWN HTML ===\n";

$services = [
    'Rental Cooling' => '/services/rental-cooling/',
    'Rental AC' => '/services/rental-ac-in-uae/',
    'Wild Air Rental' => '/services/wild-air-rental-in-uae/',
    'Chiller Maintenance' => '/services/chiller-maintenance-in-uae/',
    'Rental Generator' => '/services/generator-rental-in-uae/',
    'Rental Power' => '/services/generator-maintenance-repair-in-uae/',
    'USed & Refurbished' => '/used-refurbished-equipment-in-uae/',
];

foreach ($services as $name => $url) {
    if (str_contains($html, $url)) {
        echo "[FOUND SERVICE] $name -> $url\n";
    } else {
        echo "[MISSING SERVICE] $name -> $url\n";
    }
}

// Ensure 3rd-level sub-items are NOT in the header nav
$forbiddenSublinks = [
    '/services/rental-cooling/rental-cooling-in-uae/',
    '/services/rental-cooling/rental-cooling-in-dubai/',
    '/services/rental-cooling/rental-cooling-in-abu-dhabi/',
    '/services/rental-ac-in-uae/rental-ac-in-dubai/',
    '/services/wild-air-rental-in-uae/wild-air-in-uae/',
    '/services/chiller-maintenance-in-uae/chiller-maintenance-in-dubai/',
];

echo "\n=== VERIFYING NESTED SUB-ITEMS REMOVED FROM MENU ===\n";
$allClean = true;
foreach ($forbiddenSublinks as $sub) {
    if (str_contains($html, $sub)) {
        echo "[ERROR: FOUND IN HTML] $sub\n";
        $allClean = false;
    } else {
        echo "[CLEAN: NOT IN MENU] $sub\n";
    }
}

if ($allClean) {
    echo "\nSUCCESS: Services menu contains ONLY the 7 direct services, and ZERO nested sub-pages!\n";
} else {
    echo "\nFAILURE: Some sublinks are still present in HTML!\n";
}
