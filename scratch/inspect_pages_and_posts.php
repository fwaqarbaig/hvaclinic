<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Page;
use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

echo "=== SEARCHING PAGES FOR 'rental' ===\n";
$pages = Page::where('title', 'like', '%rental%')->orWhere('slug', 'like', '%rental%')->get();
foreach ($pages as $p) {
    echo "PAGE: id={$p->id}, slug={$p->slug}, title={$p->title}\n";
}

echo "\n=== SEARCHING POSTS FOR 'rental' ===\n";
$posts = Post::where('title', 'like', '%rental%')->orWhere('slug', 'like', '%rental%')->take(10)->get();
foreach ($posts as $p) {
    echo "POST: id={$p->id}, slug={$p->slug}, title={$p->title}\n";
}

echo "\n=== TOTAL PAGES: ".Page::count()." ===\n";
echo '=== TOTAL POSTS: '.Post::count()." ===\n";

echo "\nSample posts:\n";
foreach (Post::take(5)->get() as $p) {
    echo "POST: slug={$p->slug}, title={$p->title}\n";
}
