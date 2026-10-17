<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

$s = Service::where('slug', 'portacabin')->first();
if ($s) {
    echo "=== SERVICE: portacabin ===\n";
    echo 'Title: '.$s->title."\n";
    echo 'Description: '.$s->description."\n";
    echo "Content (first 1000 chars):\n".substr($s->content, 0, 1000)."\n\n";
}

$p = Page::where('slug', 'like', '%portacabin%')->orWhere('slug', 'like', '%used%')->first();
if ($p) {
    echo "=== PAGE: {$p->slug} ===\n";
    echo 'Title: '.$p->title."\n";
    echo "Content (first 1000 chars):\n".substr($p->content, 0, 1000)."\n\n";
}

echo "=== CHECKING POSTS WITH 'PORTACABIN' ===\n";
$posts = Post::where('title', 'like', '%portacabin%')->orWhere('slug', 'like', '%portacabin%')->orWhere('title', 'like', '%cabin%')->get();
echo 'Found '.$posts->count()." posts mentioning portacabin/cabin.\n";
foreach ($posts as $po) {
    echo "ID: {$po->id} | {$po->title} (Slug: {$po->slug})\n";
}
