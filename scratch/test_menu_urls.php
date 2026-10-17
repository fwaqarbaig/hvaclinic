<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

$urls = [
    '/',
    '/about/',
    '/our-team/',
    '/membership/',
    '/certificates/',
    '/services/',
    '/services/rental-chiller-in-uae/',
    '/services/rental-chiller-in-uae/rental-chiller-in-dubai/',
    '/services/rental-chiller-in-uae/rental-chiller-in-abu-dhabi/',
    '/services/rental-chiller-in-uae/rental-chiller-in-sharjah/',
    '/services/rental-chiller-in-uae/industrial-chiller-rental-in-uae/',
    '/services/rental-chiller-in-uae/air-cooled-chiller-rental-in-uae/',
    '/services/rental-chiller-in-uae/water-cooled-chiller-in-uae/',
    '/services/rental-chiller-in-uae/emergency-chiller-rental-in-uae/',
    '/services/rental-ac-in-uae/',
    '/services/rental-ac-in-uae/rental-ac-in-dubai/',
    '/services/rental-ac-in-uae/rental-ac-in-sharjah/',
    '/services/rental-ac-in-uae/rental-ac-abu-in-dhabi/',
    '/services/rental-ac-in-uae/portable-ac-rental-in-dubai/',
    '/services/rental-ac-in-uae/outdoor-ac-rental-in-dubai/',
    '/services/rental-ac-in-uae/floor-standing-ac-rental-in-uae/',
    '/services/rental-ac-in-uae/portable-ac-rental-in-uae/',
    '/services/ac-maintenance-repair-uae/',
    '/services/ac-maintenance-repair-uae/ac-repair-in-dubai/',
    '/services/ac-maintenance-repair-uae/ac-maintenance-in-dubai/',
    '/services/ac-maintenance-repair-uae/ac-repair-in-abu-dhabi/',
    '/services/ac-maintenance-repair-uae/ac-maintenance-in-abu-dhabi/',
    '/services/ac-maintenance-repair-uae/ac-amc-in-uae/',
    '/services/generator-rental-in-uae/',
    '/services/generator-rental-in-uae/generator-rental-dubai/',
    '/services/generator-rental-in-uae/generator-rental-sharjah/',
    '/services/generator-rental-in-uae/generator-rental-abu-dhabi/',
    '/services/rental-cooling/',
    '/services/rental-cooling/rental-cooling-in-uae/',
    '/services/rental-cooling/rental-cooling-in-dubai/',
    '/services/rental-cooling/rental-cooling-in-abu-dhabi/',
    '/temporary-cooling-in-uae/',
    '/temporary-cooling-in-uae/temporary-cooling-in-dubai/',
    '/temporary-cooling-in-uae/warehouse-cooling-rental-in-uae/',
    '/temporary-cooling-in-uae/construction-site-cooling-in-uae/',
    '/temporary-cooling-in-uae/event-cooling-in-uae/',
    '/services/wild-air-rental-in-uae/wild-air-in-uae/',
    '/services/wild-air-rental-in-uae/',
    '/services/wild-air-rental-in-uae/wild-air-dubai/',
    '/services/wild-air-rental-in-uae/wild-air-abu-dhabi/',
    '/services/wild-air-rental-in-uae/wild-air-rental/',
    '/services/chiller-maintenance-in-uae/',
    '/services/chiller-maintenance-in-uae/chiller-maintenance-in-dubai/',
    '/services/chiller-maintenance-in-uae/chiller-repair-in-dubai/',
    '/services/chiller-maintenance-in-uae/chiller-maintenance-in-sharjah/',
    '/services/chiller-maintenance-in-uae/chiller-repair-in-abu-dhabi/',
    '/services/chiller-maintenance-in-uae/chiller-maintenance-in-abu-dhabi/',
    '/services/chiller-maintenance-in-uae/chiller-repair-in-uae/',
    '/services/chiller-maintenance-in-uae/chiller-amc-in-uae/',
    '/used-refurbished-equipment-in-uae/',
    '/used-refurbished-equipment-in-uae/sell-your-old-chiller/',
    '/used-refurbished-equipment-in-uae/sell-your-old-generator/',
    '/used-refurbished-equipment-in-uae/used-chiller-for-sale-in-dubai/',
    '/used-refurbished-equipment-in-uae/used-generator-for-sale-in-dubai/',
    '/used-refurbished-equipment-in-uae/used-generators-in-uae/',
    '/used-refurbished-equipment-in-uae/refurbished-chiller-in-uae/',
    '/contact/',
    '/blog/',
    '/category/blog/',
];

$results = [];
foreach ($urls as $url) {
    $req = Request::create($url, 'GET');
    $res = $app->handle($req);
    $status = $res->getStatusCode();
    if ($status !== 200 && $status !== 301) {
        $results[] = "$url -> HTTP $status";
    }
}

if (empty($results)) {
    echo 'ALL '.count($urls)." URLs return HTTP 200 or 301 clean!\n";
} else {
    echo 'Issues found in '.count($results)." URLs:\n";
    foreach ($results as $r) {
        echo "  $r\n";
    }
}
