<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$slugs = Post::pluck('slug')->toArray();
echo 'Total posts in DB: '.count($slugs).PHP_EOL;

$categories = Category::all();
echo 'Categories:'.PHP_EOL;
foreach ($categories as $c) {
    echo "ID: {$c->id} | Name: {$c->name} | Slug: {$c->slug}".PHP_EOL;
}

$images = Post::whereNotNull('featured_image')->pluck('featured_image')->unique()->values()->toArray();
echo 'Total unique featured images: '.count($images).PHP_EOL;
echo 'Sample images:'.PHP_EOL;
print_r(array_slice($images, 0, 10));
