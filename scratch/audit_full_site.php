<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

echo "=======================================================\n";
echo "1. AUDITING PORTACABIN CONTENT & RENTAL PORTACABIN\n";
echo "=======================================================\n";

// Check pages
echo "\n--- Pages with 'portacabin' or 'rental' ---\n";
foreach (DB::table('pages')->get() as $page) {
    if (stripos($page->title, 'portacabin') !== false || stripos($page->content, 'portacabin') !== false || stripos($page->slug, 'portacabin') !== false) {
        echo "Page ID {$page->id}: {$page->title} (Slug: {$page->slug})\n";
        // Check for 'rental' + 'portacabin'
        if (preg_match('/(portacabin.*rent|rent.*portacabin|cabin.*hire|hire.*cabin)/i', $page->title.' '.$page->content)) {
            echo "   [WARNING] Contains 'portacabin rental/hire'!\n";
        }
    }
}

// Check services
echo "\n--- Services with 'portacabin' or 'rental' ---\n";
foreach (DB::table('services')->get() as $s) {
    echo "Service ID {$s->id}: {$s->title} (Slug: {$s->slug})\n";
    if (stripos($s->title, 'portacabin') !== false || stripos($s->description ?? '', 'portacabin') !== false || stripos($s->content ?? '', 'portacabin') !== false) {
        echo "   -> Portacabin mentioned.\n";
        if (preg_match('/(portacabin.*rent|rent.*portacabin|cabin.*hire|hire.*cabin)/i', $s->title.' '.($s->content ?? '').' '.($s->description ?? ''))) {
            echo "   [WARNING] Service contains 'portacabin rental/hire'!\n";
        }
    }
}

// Check menu items
echo "\n--- Menu Items ---\n";
if (DB::getSchemaBuilder()->hasTable('menus')) {
    foreach (DB::table('menus')->get() as $m) {
        echo "Menu: {$m->name} -> ".($m->url ?? $m->route ?? '')."\n";
    }
} elseif (DB::getSchemaBuilder()->hasTable('menu_items')) {
    foreach (DB::table('menu_items')->get() as $m) {
        echo "Menu Item: {$m->title} -> {$m->url}\n";
    }
}

// Check posts mentioning portacabin rental vs used/scrap/refurbished
echo "\n--- Posts mentioning portacabin ---\n";
$portacabinRentalPosts = [];
$portacabinBuySellScrapPosts = [];
$nonGeneratorPosts = [];

foreach (Post::all() as $p) {
    $text = $p->title.' '.$p->slug.' '.$p->excerpt;

    // Check if it's rental portacabin
    if (preg_match('/(portacabin.*rent|rent.*portacabin|cabin.*rent|rent.*cabin|cabin.*hire|hire.*cabin)/i', $text)) {
        $portacabinRentalPosts[] = $p;
    }

    // Check if it's buy/sell/scrap/refurbished portacabin
    if (preg_match('/(scrap.*cabin|cabin.*scrap|used.*cabin|cabin.*buy|cabin.*sell|refurb.*cabin|cabin.*refurb)/i', $text)) {
        $portacabinBuySellScrapPosts[] = $p;
    }
}

echo 'Total Portacabin Rental posts found: '.count($portacabinRentalPosts)."\n";
foreach (array_slice($portacabinRentalPosts, 0, 15) as $prp) {
    echo "  - [ID {$prp->id}] {$prp->title} ({$prp->slug})\n";
}

echo "\nTotal Portacabin Buy/Sell/Scrap/Refurbished posts found: ".count($portacabinBuySellScrapPosts)."\n";
foreach (array_slice($portacabinBuySellScrapPosts, 0, 15) as $pbs) {
    echo "  - [ID {$pbs->id}] {$pbs->title} ({$pbs->slug})\n";
}

echo "\n=======================================================\n";
echo "2. AUDITING UNRELATED BLOG TOPICS (CLUSTER 8 & OTHERS)\n";
echo "=======================================================\n";

$unrelatedKeywords = [
    'sub-floor', 'subfloor', 'settlement', 'siren', 'aluminium', 'composite panel',
    'termite', 'grille', 'prayer room', 'defibrillator', 'aed', 'odor control',
    'acoustic ceiling', 'training & induction', 'waste sorting', 'demobilization',
    'vinyl flooring', 'internal partitioning', 'fresh air intake', 'rainwater drainage',
    'cctv mounting', 'wheelchair ramp', 'chemical storage', 'bullet-resistant',
    'pop-up retail', 'bunk bed', 'wpc wood', 'portable toilet single', 'level and shim',
    'labor camp kitchen', 'asbestos', 'upvc drain', 'anti-fungal',
];

$unrelatedPosts = [];
foreach (Post::all() as $p) {
    foreach ($unrelatedKeywords as $uk) {
        if (stripos($p->title, $uk) !== false || stripos($p->slug, $uk) !== false) {
            $unrelatedPosts[$p->id] = [
                'post' => $p,
                'matched' => $uk,
            ];
            break;
        }
    }
}

echo 'Total distinctly unrelated posts found matching keywords: '.count($unrelatedPosts)."\n";
foreach (array_slice($unrelatedPosts, 0, 30) as $id => $info) {
    echo "  - [ID {$id}] [Matched: {$info['matched']}] {$info['post']->title}\n";
}

echo "\n=======================================================\n";
echo "3. AUDITING FEATURED IMAGES & MEDIA FILES ON DISK\n";
echo "=======================================================\n";

$brokenImages = [];
$validImages = 0;
foreach (Post::all() as $p) {
    $img = $p->featured_image;
    if (empty($img)) {
        $brokenImages[] = "ID {$p->id}: Empty image field";

        continue;
    }

    // Check if local file or URL
    if (str_starts_with($img, 'http')) {
        // external url
        continue;
    }

    $fullPath1 = public_path('storage/'.$img);
    $fullPath2 = public_path($img);
    $fullPath3 = storage_path('app/public/'.$img);

    if (File::exists($fullPath1) || File::exists($fullPath2) || File::exists($fullPath3)) {
        $validImages++;
    } else {
        $brokenImages[] = "ID {$p->id} ({$p->slug}): Missing file on disk -> {$img}";
    }
}

echo "Valid images on disk: {$validImages}\n";
echo 'Broken or missing images: '.count($brokenImages)."\n";
if (count($brokenImages) > 0) {
    echo "First 10 broken image samples:\n";
    foreach (array_slice($brokenImages, 0, 10) as $bi) {
        echo "  - {$bi}\n";
    }
}

echo "\n=======================================================\n";
echo "4. CHECKING PUBLIC/MEDIA AND STORAGE/APP/PUBLIC FOLDERS\n";
echo "=======================================================\n";

$publicMedia = public_path('media');
$storageMedia = public_path('storage');
echo 'public/media exists? '.(File::isDirectory($publicMedia) ? 'YES' : 'NO')."\n";
echo 'public/storage exists? '.(File::isDirectory($storageMedia) ? 'YES' : 'NO')."\n";

if (File::isDirectory(public_path('images'))) {
    echo 'public/images files: '.count(File::allFiles(public_path('images')))."\n";
}
if (File::isDirectory(public_path('storage/media'))) {
    echo 'public/storage/media files: '.count(File::allFiles(public_path('storage/media')))."\n";
}
