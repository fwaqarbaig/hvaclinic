<?php

use App\Models\Page;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$slugs = ['about', 'our-team', 'membership', 'certificates'];

foreach ($slugs as $slug) {
    $page = Page::where('slug', $slug)->first();
    if (! $page) {
        continue;
    }
    echo "=== Page: {$page->title} ({$page->slug}) ===\n";
    preg_match_all('/<img[^>]+src=[\'"]([^\'"]+)[\'"]/i', $page->content, $m);
    $images = array_unique($m[1] ?? []);
    echo 'Total images: '.count($images)."\n";
    foreach ($images as $img) {
        $clean = ltrim(parse_url($img, PHP_URL_PATH), '/');
        $exists = file_exists(public_path($clean));
        echo "  - $img -> ".($exists ? 'EXISTS ('.filesize(public_path($clean)).' bytes)' : 'MISSING!')."\n";
    }
}
