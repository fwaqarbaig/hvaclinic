<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

echo 'Total posts: '.Post::count().PHP_EOL;

$blogCategory = Category::where('slug', 'blog')->first();
if ($blogCategory) {
    echo "Posts in 'blog' category: ".$blogCategory->posts()->count().PHP_EOL;
} else {
    echo 'Blog category not found!'.PHP_EOL;
}

echo "\nCurrent Menu Items under Services:\n";
$services = MenuItem::where('location', 'header')->where('title', 'Services')->first();
if ($services) {
    foreach ($services->children as $child) {
        echo ' - '.$child->title.' ('.$child->url.') [children: '.$child->children->count()."]\n";
        foreach ($child->children as $sub) {
            echo '     * '.$sub->title.' ('.$sub->url.")\n";
        }
    }
}
