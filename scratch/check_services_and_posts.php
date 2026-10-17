<?php

use App\Models\Post;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "=== SERVICES LIST ===\n";
foreach (Service::all() as $s) {
    echo "ID {$s->id} | {$s->title} | slug: {$s->slug} | kw: {$s->focus_keyword} | meta: ".substr($s->meta_description ?? '', 0, 40).'... | schema: '.($s->schema_markup ? 'YES' : 'NO')."\n";
}

echo "\n=== PORTACABIN / BUY / SELL / SCRAP SERVICES ===\n";
$portacabinServices = Service::where('title', 'like', '%portacabin%')
    ->orWhere('title', 'like', '%cabin%')
    ->orWhere('slug', 'like', '%portacabin%')
    ->orWhere('slug', 'like', '%cabin%')
    ->get();
foreach ($portacabinServices as $s) {
    echo "Service ID {$s->id}: {$s->title} | slug: {$s->slug}\n";
}

echo "\n=== PORTACABIN POSTS ===\n";
$portacabinPosts = Post::where('title', 'like', '%portacabin%')
    ->orWhere('title', 'like', '%cabin%')
    ->orWhere('slug', 'like', '%portacabin%')
    ->get();
echo 'Found '.$portacabinPosts->count()." portacabin posts.\n";
foreach ($portacabinPosts as $p) {
    echo "Post ID {$p->id}: {$p->title} | kw: {$p->focus_keyword}\n";
}

echo "\n=== TOTAL POSTS BY KEYWORD ===\n";
echo 'Total published posts: '.Post::where('status', 'published')->count()."\n";
$nonKwPosts = Post::whereNull('focus_keyword')->orWhere('focus_keyword', '')->count();
echo "Posts without focus keyword: {$nonKwPosts}\n";
