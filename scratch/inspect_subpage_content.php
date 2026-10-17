<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Page;
use Illuminate\Contracts\Console\Kernel;

$subSlugs = [
    'services/rental-cooling/rental-cooling-in-uae',
    'services/rental-cooling/rental-cooling-in-dubai',
    'services/rental-cooling/rental-cooling-in-abu-dhabi',
    'services/rental-ac-in-uae/rental-ac-in-dubai',
    'services/wild-air-rental-in-uae/wild-air-in-uae',
    'services/chiller-maintenance-in-uae/chiller-maintenance-in-dubai',
    'services/generator-rental-in-uae/generator-rental-dubai',
    'services/generator-maintenance-repair-in-uae/generator-maintenance-in-dubai',
    'used-refurbished-equipment-in-uae/used-chiller-for-sale-in-dubai',
];

foreach ($subSlugs as $slug) {
    $page = Page::where('slug', $slug)->first();
    echo "PAGE {$slug}: ".($page ? "Title: {$page->title}, Content length: ".strlen($page->content) : 'NOT FOUND')."\n";
}
