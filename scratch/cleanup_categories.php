<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$blogCat = Category::firstOrCreate(['slug' => 'blog'], ['name' => 'Blog']);

// Ensure all 140 posts are attached to Blog category
foreach (Post::all() as $post) {
    if (! $post->categories()->where('categories.id', $blogCat->id)->exists()) {
        $post->categories()->attach($blogCat->id);
    }
}

// Remove empty legacy categories
$deleted = Category::whereDoesntHave('posts')->delete();
echo "Deleted $deleted empty legacy categories.\n";

echo "Remaining categories:\n";
foreach (Category::all() as $c) {
    echo "  - {$c->name} ({$c->slug}) -> ".$c->posts()->count()." posts\n";
}
