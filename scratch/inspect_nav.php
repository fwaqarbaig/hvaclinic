<?php

use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo '=== MENU ITEMS ==='.PHP_EOL;
foreach (MenuItem::all() as $item) {
    echo "ID: {$item->id} | Title: {$item->title} | URL: {$item->url} | Parent: {$item->parent_id}".PHP_EOL;
}

echo PHP_EOL.'=== SERVICES ==='.PHP_EOL;
foreach (Service::all() as $s) {
    echo "ID: {$s->id} | Title: {$s->title} | Slug: {$s->slug} | Status: {$s->status}".PHP_EOL;
}

echo PHP_EOL.'=== MATCHING PAGES ==='.PHP_EOL;
$slugsToCheck = [
    'services',
    'rental-cooling',
    'rental-chiller-in-uae',
    'rental-ac-in-uae',
    'wild-air-rental-in-uae',
    'chiller-maintenance-in-uae',
    'generator-rental-in-uae',
    'generator-maintenance-repair-in-uae',
    'used-refurbished-equipment-in-uae',
    'services/rental-cooling',
    'services/rental-chiller-in-uae',
    'services/rental-ac-in-uae',
    'services/wild-air-rental-in-uae',
    'services/chiller-maintenance-in-uae',
    'services/generator-rental-in-uae',
    'services/generator-maintenance-repair-in-uae',
    'services/used-refurbished-equipment-in-uae',
];
foreach ($slugsToCheck as $slug) {
    $p = Page::where('slug', $slug)->first();
    if ($p) {
        echo "FOUND PAGE: {$slug} -> ID: {$p->id} | Title: {$p->title}".PHP_EOL;
    }
}
