<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

echo "========================================================\n";
echo "COMPREHENSIVE VERIFICATION: IMAGES, SCHEMAS & LINKS\n";
echo "========================================================\n\n";

$passCount = 0;
$failCount = 0;

function assertCheck($cond, $msg)
{
    global $passCount, $failCount;
    if ($cond) {
        $passCount++;
        echo "  [PASS] $msg\n";
    } else {
        $failCount++;
        echo "  [FAIL] $msg\n";
    }
}

// 1. VERIFY IMAGES ON DISK
echo "--- 1. VERIFYING IMAGES EXIST ON DISK ---\n";

foreach (Product::all() as $p) {
    $path = public_path(ltrim($p->featured_image, '/'));
    assertCheck(file_exists($path), "Product #{$p->id} ({$p->slug}) image exists: {$p->featured_image}");
}

foreach (Service::all() as $s) {
    $path = public_path(ltrim($s->featured_image, '/'));
    assertCheck(file_exists($path), "Service #{$s->id} ({$s->slug}) image exists: {$s->featured_image}");
}

foreach (Post::all() as $post) {
    $path = public_path(ltrim($post->featured_image, '/'));
    assertCheck(file_exists($path), "Post #{$post->id} ({$post->slug}) image exists: {$post->featured_image}");
}

foreach (Page::all() as $page) {
    $path = public_path(ltrim($page->featured_image, '/'));
    assertCheck(file_exists($path), "Page #{$page->id} ({$page->slug}) image exists: {$page->featured_image}");
}

// 2. VERIFY SCHEMAS HAVE VALID JSON & IMAGE
echo "\n--- 2. VERIFYING SCHEMA.ORG JSON-LD & IMAGE FIELD ---\n";

$models = [
    'Product' => Product::all(),
    'Service' => Service::all(),
    'Post' => Post::all(),
    'Page' => Page::all(),
    'Category' => Category::all(),
];

foreach ($models as $type => $collection) {
    foreach ($collection as $item) {
        $json = json_decode($item->schema_markup, true);
        $validJson = (json_last_error() === JSON_ERROR_NONE && ! empty($json));
        $hasImage = str_contains($item->schema_markup ?? '', 'image');
        $identifier = $item->slug ?? ($item->name ?? $item->title);
        assertCheck($validJson && $hasImage, "$type $identifier has valid JSON-LD and includes 'image'");
    }
}

// 3. VERIFY ALL IN-CONTENT INTERNAL LINKS IN POSTS RESOLVE
echo "\n--- 3. VERIFYING POST IN-CONTENT INTERNAL LINKS (HTTP 200) ---\n";

$testedUrls = [];
foreach (Post::all() as $post) {
    preg_match_all('/href=[\'"]([^\'"]+)[\'"]/', $post->content, $matches);
    $links = $matches[1] ?? [];
    foreach ($links as $url) {
        if (! str_starts_with($url, '/')) {
            continue; // skip external/mailto/tel
        }
        if (isset($testedUrls[$url])) {
            continue; // already tested
        }

        $req = Request::create($url, 'GET');
        $res = $app->handle($req);
        $status = $res->getStatusCode();
        $ok = ($status === 200 || $status === 301 || $status === 302);
        assertCheck($ok, "Post link $url -> HTTP $status");
        $testedUrls[$url] = $status;
    }
}

// 4. VERIFY HOME, FLEET, SERVICE & BLOG PAGES RENDER
echo "\n--- 4. VERIFYING KEY FRONTEND VIEWS RENDER CLEANLY ---\n";
$viewsToTest = [
    '/' => 'Home Page',
    '/about-us' => 'About Us',
    '/fleet' => 'Fleet Index',
    '/fleet/50-kva' => 'Fleet Single (50 kVA)',
    '/fleet/500-kva' => 'Fleet Single (500 kVA)',
    '/services' => 'Services Index',
    '/service/rental-power' => 'Service Single (Rental Power)',
    '/industries' => 'Industries Page',
    '/used-refurbished-generators' => 'Used Generators',
    '/locations' => 'Locations Index',
    '/locations/dubai' => 'Location Detail (Dubai)',
    '/blog' => 'Blog Index',
    '/post/generator-sizing-guide-dubai-construction-kva' => 'Blog Single (Sizing Guide)',
    '/contact-us' => 'Contact Us',
];

foreach ($viewsToTest as $uri => $name) {
    $req = Request::create($uri, 'GET');
    $res = $app->handle($req);
    $status = $res->getStatusCode();
    assertCheck($status === 200, "View $name ($uri) -> HTTP $status");
}

echo "\n========================================================\n";
echo "SUMMARY: Passed: $passCount | Failed: $failCount\n";
echo "========================================================\n";
