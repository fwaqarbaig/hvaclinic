<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Page;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

echo "=== SERVICES TABLE RECORDS ===\n";
foreach (Service::all() as $s) {
    echo "ID: {$s->id} | Title: {$s->title} | Slug: {$s->slug} | Status: {$s->status} | Content Length: ".strlen($s->content)."\n";
}

echo "\n=== PAGES TABLE SERVICES RECORDS ===\n";
$servicePages = [
    'services',
    'services/rental-cooling',
    'services/rental-ac-in-uae',
    'services/wild-air-rental-in-uae',
    'services/chiller-maintenance-in-uae',
    'services/generator-rental-in-uae',
    'services/generator-maintenance-repair-in-uae',
    'used-refurbished-equipment-in-uae',
];

foreach ($servicePages as $slug) {
    $p = Page::where('slug', $slug)->first();
    echo "Slug: {$slug} -> ".($p ? "ID: {$p->id} | Title: {$p->title} | Status: {$p->status} | Content Length: ".strlen($p->content) : 'NOT FOUND')."\n";
}
