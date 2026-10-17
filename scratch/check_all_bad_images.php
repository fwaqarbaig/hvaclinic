<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Media;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

echo '=== CHECKING POSTS FEATURED_IMAGE ==='.PHP_EOL;
$postBad = 0;
foreach (Post::all() as $p) {
    if (str_contains($p->featured_image ?? '', 'recoverydata') || empty($p->featured_image)) {
        $postBad++;
        if ($postBad <= 5) {
            echo "Post [{$p->id}] '{$p->title}': {$p->featured_image}".PHP_EOL;
        }
    }
}
echo "Total posts with bad/external featured_image: {$postBad}".PHP_EOL;

echo PHP_EOL.'=== CHECKING PAGES FEATURED_IMAGE ==='.PHP_EOL;
$pageBad = 0;
foreach (Page::all() as $p) {
    echo "Page [{$p->id}] '{$p->title}': '{$p->featured_image}'".PHP_EOL;
}

echo PHP_EOL.'=== CHECKING SERVICES FEATURED_IMAGE ==='.PHP_EOL;
foreach (Service::all() as $s) {
    echo "Service [{$s->id}] '{$s->title}': '{$s->featured_image}'".PHP_EOL;
}

echo PHP_EOL.'=== CHECKING MEDIA TABLE ==='.PHP_EOL;
$mediaBad = 0;
foreach (Media::all() as $m) {
    if (str_contains($m->file_path ?? '', 'recoverydata')) {
        $mediaBad++;
    }
}
echo "Media rows with recoverydata.ae: {$mediaBad} of ".Media::count().PHP_EOL;
