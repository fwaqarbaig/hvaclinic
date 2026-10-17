<?php

use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "SERVICES FEATURED IMAGES:\n";
foreach (Service::all() as $s) {
    echo "ID {$s->id}: '{$s->featured_image}'\n";
}

echo "\nPAGES FEATURED IMAGES (sample 10):\n";
foreach (Page::take(10)->get() as $p) {
    echo "ID {$p->id}: '{$p->featured_image}'\n";
}

echo "\nPOSTS FEATURED IMAGES (sample 10):\n";
foreach (Post::take(10)->get() as $post) {
    echo "ID {$post->id}: '{$post->featured_image}'\n";
}

echo "\nPOSTS with recoverydata:\n";
echo Post::where('featured_image', 'like', '%recoverydata%')->count()."\n";
echo "PAGES with recoverydata:\n";
echo Page::where('featured_image', 'like', '%recoverydata%')->count()."\n";
echo "SERVICES with recoverydata:\n";
echo Service::where('featured_image', 'like', '%recoverydata%')->count()."\n";
