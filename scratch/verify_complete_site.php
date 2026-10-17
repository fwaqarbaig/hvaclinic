<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

echo "========================================================\n";
echo "FINAL COMPREHENSIVE SITE & SEO VERIFICATION REPORT\n";
echo "========================================================\n\n";

// 1. Post statistics
$totalPosts = Post::count();
$postsWithImages = Post::whereNotNull('featured_image')->where('featured_image', '!=', '')->count();
echo "1. POSTS AUDIT:\n";
echo "   Total Blog Posts: {$totalPosts}\n";
echo "   Posts with Featured Image: {$postsWithImages}\n";

$brokenImageAccessors = 0;
$brokenDiskImages = 0;
foreach (Post::all() as $p) {
    $url = $p->featured_image_url;
    if (str_contains($url, '/storage//storage/')) {
        $brokenImageAccessors++;
    }

    // Check local disk file
    $imgClean = ltrim($p->featured_image, '/');
    if (str_starts_with($imgClean, 'storage/')) {
        $imgClean = substr($imgClean, 8);
    }
    $localFile1 = public_path('storage/'.$imgClean);
    $localFile2 = public_path($imgClean);
    if (! File::exists($localFile1) && ! File::exists($localFile2)) {
        $brokenDiskImages++;
    }
}
echo "   Double-storage accessor defects: {$brokenImageAccessors} (Target: 0)\n";
echo "   Missing image files on disk: {$brokenDiskImages} (Target: 0)\n";

// 2. Portacabin Rental check
echo "\n2. PORTACABIN AUDIT (ZERO RENTAL PORTACABIN):\n";
$rentalCabinPosts = 0;
foreach (Post::all() as $p) {
    if (preg_match('/(portacabin.*rent|rent.*portacabin|cabin.*rent|rent.*cabin|cabin.*hire|hire.*cabin)/i', $p->title.' '.$p->slug.' '.$p->meta_title)) {
        echo "   [WARNING] Post {$p->id} has rental cabin: {$p->title}\n";
        $rentalCabinPosts++;
    }
}
echo "   Portacabin rental posts in DB: {$rentalCabinPosts} (Target: 0)\n";

$s20 = Service::where('slug', 'portacabin')->first();
echo "   Service 20 Title: {$s20->title}\n";
echo "   Service 20 Meta Title: {$s20->meta_title}\n";
$hasRentalInS20 = preg_match('/(portacabin.*rent|rent.*portacabin)/i', $s20->meta_title.' '.$s20->title) ? 'YES' : 'NO';
echo "   Does Service 20 have rental portacabin in title/meta? {$hasRentalInS20} (Target: NO)\n";

// 3. Cluster 8 Unrelated Blog check
echo "\n3. UNRELATED TOPICS AUDIT (ACP, Subfloor, Siren, Settlement, etc.):\n";
$unrelatedKeywords = [
    'sub-floor pipe insulation', 'ground settlement monitoring', 'emergency siren & compound',
    'aluminum composite panel (acp)', 'smart thermostats & timers on site office',
    'rapid de-mobilization protocols: packing and transporting a 20-cabin',
    'pest control & termite proofing for portacabin', 'acoustic ceiling baffles',
    'wheelchair ramps & accessibility standards for public', 'automated external defibrillator (aed)',
];
$foundUnrelated = 0;
foreach (Post::all() as $p) {
    foreach ($unrelatedKeywords as $uk) {
        if (stripos($p->title, $uk) !== false) {
            echo "   [UNRELATED DETECTED] Post {$p->id}: {$p->title}\n";
            $foundUnrelated++;
        }
    }
}
echo "   Unrelated blogs found in DB: {$foundUnrelated} (Target: 0)\n";

// 4. Test Key Pages for 200 OK and zero broken images
echo "\n4. TESTING KEY PAGES HTTP STATUS & IMAGES:\n";
$p923 = Post::find(923);
$p924 = Post::find(924);
$p925 = Post::find(925);
$p876 = Post::find(876);

$testPages = [
    '/',
    '/blog',
    '/post/'.($p923 ? $p923->slug : 'error'),
    '/post/'.($p924 ? $p924->slug : 'error'),
    '/post/'.($p925 ? $p925->slug : 'error'),
    '/post/'.($p876 ? $p876->slug : 'error'),
    '/service/portacabin',
    '/services',
    '/fleet',
    '/used-refurbished-generators',
    '/locations',
    '/sitemap.xml',
    '/robots.txt',
];

foreach ($testPages as $page) {
    try {
        $req = Request::create($page, 'GET');
        $resp = $app->handle($req);
        $status = $resp->getStatusCode();
        echo "   [HTTP {$status}] {$page}\n";
    } catch (Throwable $e) {
        echo "   [ERROR] {$page}: ".$e->getMessage()."\n";
    }
}

echo "\nVerification complete!\n";
