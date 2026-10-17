<?php

use App\Models\MenuItem;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$coreSlugs = [
    1 => 'rental-cooling',
    2 => 'rental-ac-in-uae',
    3 => 'wild-air-rental-in-uae',
    4 => 'chiller-maintenance-in-uae',
    5 => 'generator-rental-in-uae',
    6 => 'generator-maintenance-repair-in-uae',
    7 => 'used-refurbished-equipment-in-uae',
];

foreach ($coreSlugs as $order => $slug) {
    Service::where('slug', $slug)->update([
        'order' => $order,
        'status' => 'published',
        'is_featured' => true,
    ]);
    echo "Set core service {$slug} to order {$order}".PHP_EOL;
}

MenuItem::where('id', 268)->update(['title' => 'Used & Refurbished']);
echo "Updated MenuItem 268 to 'Used & Refurbished'".PHP_EOL;

// Deprecate duplicates from listing
$legacySlugs = [
    'temporary-cooling-in-uae',
    'ac-maintenance-repair-uae',
];
Service::whereIn('slug', $legacySlugs)->update([
    'status' => 'draft',
    'order' => 99,
]);

// Keep rental-chiller-in-uae synchronized with rental-cooling
$rentalCooling = Service::where('slug', 'rental-cooling')->first();
if ($rentalCooling) {
    Service::where('slug', 'rental-chiller-in-uae')->update([
        'content' => $rentalCooling->content,
        'summary' => $rentalCooling->summary,
        'features' => $rentalCooling->features,
        'benefits' => $rentalCooling->benefits,
        'benchmarks' => $rentalCooling->benchmarks,
        'tagline' => $rentalCooling->tagline,
        'hero_badge' => $rentalCooling->hero_badge,
        'featured_image' => $rentalCooling->featured_image,
        'status' => 'draft',
        'order' => 98,
    ]);
}

echo 'Services ordering and status successfully updated!'.PHP_EOL;
