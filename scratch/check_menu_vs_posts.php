<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

$services = MenuItem::where('location', 'header')->where('title', 'Services')->first();
$subItems = [];
if ($services) {
    foreach ($services->children as $service) {
        foreach ($service->children as $sub) {
            $subItems[] = [
                'service' => $service->title,
                'title' => $sub->title,
                'url' => $sub->url,
            ];
        }
    }
}

echo 'Total sub-items currently under Services in menu: '.count($subItems)."\n\n";

foreach ($subItems as $item) {
    $cleanPath = trim($item['url'], '/');
    $page = Page::where('slug', $cleanPath)->first();
    $postByTitle = Post::where('title', $item['title'])->first();
    $lastSegment = basename($cleanPath);
    $postBySlug = Post::where('slug', $lastSegment)->first();

    echo "Sub-item: {$item['title']} ({$item['url']})\n";
    echo '  - Page exists: '.($page ? "YES (id: {$page->id})" : 'NO')."\n";
    echo '  - Post by title: '.($postByTitle ? "YES (id: {$postByTitle->id}, slug: {$postByTitle->slug})" : 'NO')."\n";
    echo "  - Post by slug ({$lastSegment}): ".($postBySlug ? "YES (id: {$postBySlug->id})" : 'NO')."\n";
}
