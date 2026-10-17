<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo '=== POST COUNT ==='.PHP_EOL;
echo 'Published posts: '.Post::published()->count().PHP_EOL;
echo 'Total posts: '.Post::count().PHP_EOL;

echo PHP_EOL.'=== CATEGORIES ==='.PHP_EOL;
foreach (Category::all() as $c) {
    echo "ID: {$c->id} | Name: {$c->name} | Slug: {$c->slug} | Published Posts: ".$c->publishedPosts()->count().PHP_EOL;
}

echo PHP_EOL.'=== SAMPLE 5 POSTS ==='.PHP_EOL;
foreach (Post::published()->with('categories')->latest('published_at')->take(5)->get() as $p) {
    $catNames = $p->categories->pluck('name')->implode(', ');
    echo "Post #{$p->id}: {$p->title}".PHP_EOL;
    echo "  Slug: {$p->slug} | Date: {$p->published_at} | Cat: {$catNames}".PHP_EOL;
    echo "  Image: {$p->featured_image_url}".PHP_EOL;
}
