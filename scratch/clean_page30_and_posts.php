<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Page;
use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

// 1. Page 30
$page = Page::where('slug', 'services')->first();
if ($page) {
    $page->meta_title = 'Generator Rental & Site Power Services UAE | Generator Dubai';
    $page->meta_description = 'Complete generator rental, preventative AMC maintenance, multi-megawatt temporary power plants, used & refurbished portacabins, and 24/7 emergency repair across UAE.';
    $page->content = str_replace(['portacabin hire', 'portacabin rental'], 'used and refurbished portacabins', $page->content);
    $page->save();
    echo "Page 30 (services) cleaned.\n";
}

// 2. Post 880 content update
$p880 = Post::find(880);
if ($p880) {
    $p880->excerpt = 'Turnkey temporary generator power rental paired with certified used and refurbished site portacabins for Dubai and UAE construction sites under one coordinated setup.';
    $p880->content = str_replace(
        ['Turnkey Portacabin + Generator Combo Packages: One Invoice Power & Office', 'portacabin rental', 'cabin rental', 'combo rental'],
        ['Turnkey Generator Power & Used Site Portacabin Packages', 'used portacabin purchase & buyback', 'used cabin purchase', 'power and cabin package'],
        $p880->content
    );
    $p880->save();
    echo "Post 880 content cleaned.\n";
}

// 3. Post 898 content update
$p898 = Post::find(898);
if ($p898) {
    $p898->excerpt = 'Evaluating the durability, insulation, and resale value of buying surplus refurbished portacabins compared to temporary contractor-built plywood structures in UAE climate.';
    $p898->content = str_replace(
        ['Buying Ex-Rental vs Contractor-Built Portacabins: What Lasts Longer?', 'ex-rental portacabin', 'ex-rental cabin'],
        ['Buying Surplus Pre-Owned vs Contractor-Built Portacabins: What Lasts Longer?', 'surplus refurbished portacabin', 'pre-owned refurbished cabin'],
        $p898->content
    );
    $p898->save();
    echo "Post 898 content cleaned.\n";
}

// 4. Menu item title update
DB::table('menu_items')->where('url', '/service/portacabin')->update([
    'title' => 'Used & Scrap Portacabins',
]);
echo "Menu item title updated to: Used & Scrap Portacabins\n";
