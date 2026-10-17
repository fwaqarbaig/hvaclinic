<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

echo "=== DATABASE POSTS ANALYSIS ===\n";
$totalPosts = Post::count();
echo "Total posts in DB: {$totalPosts}\n";

$keywords = [
    'portacabin', 'cabin', 'modular', 'aluminium', 'sub floor', 'subfloor',
    'smart technology', 'rapid', 'settlement', 'siren', 'scrap', 'used',
    'refurbished', 'floor', 'data recovery', 'hard drive', 'ssd', 'raid',
];

$matched = [];
$allPosts = Post::all();

foreach ($allPosts as $p) {
    foreach ($keywords as $k) {
        if (stripos($p->title, $k) !== false || stripos($p->slug, $k) !== false || stripos($p->content, $k) !== false) {
            $matched[] = [
                'id' => $p->id,
                'title' => $p->title,
                'slug' => $p->slug,
                'keyword' => $k,
                'featured_image' => $p->featured_image,
                'has_image' => ! empty($p->featured_image),
            ];
            break;
        }
    }
}

echo 'Posts matching suspicious keywords: '.count($matched)."\n";
foreach (array_slice($matched, 0, 40) as $m) {
    echo "ID {$m['id']} [{$m['keyword']}]: {$m['title']}\n";
    echo "    Slug: {$m['slug']}\n";
    echo '    Image: '.($m['featured_image'] ?: 'NO IMAGE')."\n";
}

echo "\n--- All Post Titles Overview (First 50 and Last 50) ---\n";
echo "First 20:\n";
foreach ($allPosts->take(20) as $p) {
    echo "ID {$p->id}: {$p->title} (Img: ".($p->featured_image ? 'YES' : 'NO').")\n";
}
echo "...\nLast 20:\n";
foreach ($allPosts->slice(-20) as $p) {
    echo "ID {$p->id}: {$p->title} (Img: ".($p->featured_image ? 'YES' : 'NO').")\n";
}

echo "\n--- Images status across all posts ---\n";
$withImage = Post::whereNotNull('featured_image')->where('featured_image', '!=', '')->count();
$withoutImage = Post::whereNull('featured_image')->orWhere('featured_image', '')->count();
echo "Posts with featured_image: {$withImage}\n";
echo "Posts without featured_image: {$withoutImage}\n";

echo "\n--- Categories & Tags ---\n";
foreach (Category::all() as $cat) {
    echo "Cat ID {$cat->id}: {$cat->name} (Slug: {$cat->slug}) - Posts: ".$cat->posts()->count()."\n";
}
foreach (Tag::all() as $tag) {
    echo "Tag ID {$tag->id}: {$tag->name} (Slug: {$tag->slug}) - Posts: ".$tag->posts()->count()."\n";
}

echo "\n--- Other tables: pages, services, products ---\n";
try {
    echo 'Pages: '.DB::table('pages')->count()."\n";
    foreach (DB::table('pages')->get() as $page) {
        echo "  Page: {$page->title} ({$page->slug})\n";
    }
} catch (Exception $e) {
    echo 'Pages table: '.$e->getMessage()."\n";
}

try {
    echo 'Services: '.DB::table('services')->count()."\n";
    foreach (DB::table('services')->get() as $s) {
        echo "  Service: {$s->title} ({$s->slug})\n";
    }
} catch (Exception $e) {
    echo 'Services table: '.$e->getMessage()."\n";
}

try {
    echo 'Products: '.DB::table('products')->count()."\n";
    foreach (DB::table('products')->get() as $pr) {
        echo "  Product: {$pr->name} ({$pr->slug})\n";
    }
} catch (Exception $e) {
    echo 'Products table: '.$e->getMessage()."\n";
}
