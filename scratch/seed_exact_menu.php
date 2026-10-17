<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\MenuItem;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

echo "Seeding exact menu according to user specifications (Services with only 7 direct services, no nested pages)...\n";

DB::transaction(function () {
    // Clean up header items
    MenuItem::where('location', 'header')->delete();

    // 1. Home
    MenuItem::create([
        'title' => 'Home',
        'url' => '/',
        'route_name' => 'home',
        'location' => 'header',
        'order' => 1,
        'is_active' => true,
    ]);

    // 2. About
    $about = MenuItem::create([
        'title' => 'About',
        'url' => '/about/',
        'location' => 'header',
        'order' => 2,
        'is_active' => true,
    ]);

    MenuItem::create([
        'parent_id' => $about->id,
        'title' => 'About HVAC',
        'url' => '/about/',
        'order' => 1,
        'is_active' => true,
    ]);
    MenuItem::create([
        'parent_id' => $about->id,
        'title' => 'Our Team',
        'url' => '/our-team/',
        'order' => 2,
        'is_active' => true,
    ]);
    MenuItem::create([
        'parent_id' => $about->id,
        'title' => 'Membership',
        'url' => '/membership/',
        'order' => 3,
        'is_active' => true,
    ]);
    MenuItem::create([
        'parent_id' => $about->id,
        'title' => 'Certificates',
        'url' => '/certificates/',
        'order' => 4,
        'is_active' => true,
    ]);

    // 3. Services (ONLY the 7 core services directly, no nested 3rd-level items)
    $services = MenuItem::create([
        'title' => 'Services',
        'url' => '/services/',
        'location' => 'header',
        'order' => 3,
        'is_active' => true,
    ]);

    MenuItem::create([
        'parent_id' => $services->id,
        'title' => 'Rental Cooling',
        'url' => '/services/rental-cooling/',
        'order' => 1,
        'is_active' => true,
    ]);

    MenuItem::create([
        'parent_id' => $services->id,
        'title' => 'Rental AC',
        'url' => '/services/rental-ac-in-uae/',
        'order' => 2,
        'is_active' => true,
    ]);

    MenuItem::create([
        'parent_id' => $services->id,
        'title' => 'Wild Air Rental',
        'url' => '/services/wild-air-rental-in-uae/',
        'order' => 3,
        'is_active' => true,
    ]);

    MenuItem::create([
        'parent_id' => $services->id,
        'title' => 'Chiller Maintenance',
        'url' => '/services/chiller-maintenance-in-uae/',
        'order' => 4,
        'is_active' => true,
    ]);

    MenuItem::create([
        'parent_id' => $services->id,
        'title' => 'Rental Generator',
        'url' => '/services/generator-rental-in-uae/',
        'order' => 5,
        'is_active' => true,
    ]);

    MenuItem::create([
        'parent_id' => $services->id,
        'title' => 'Rental Power',
        'url' => '/services/generator-maintenance-repair-in-uae/',
        'order' => 6,
        'is_active' => true,
    ]);

    MenuItem::create([
        'parent_id' => $services->id,
        'title' => 'USed & Refurbished',
        'url' => '/used-refurbished-equipment-in-uae/',
        'order' => 7,
        'is_active' => true,
    ]);

    // 4. Blogs
    MenuItem::create([
        'title' => 'Blogs',
        'url' => '/category/blog/',
        'route_name' => 'blog.index',
        'location' => 'header',
        'order' => 4,
        'is_active' => true,
    ]);

    // 5. Contact us
    MenuItem::create([
        'title' => 'Contact us',
        'url' => '/contact/',
        'route_name' => 'contact',
        'location' => 'header',
        'order' => 5,
        'is_active' => true,
    ]);
});

echo "Exact menu successfully seeded with only 7 direct services!\n";
