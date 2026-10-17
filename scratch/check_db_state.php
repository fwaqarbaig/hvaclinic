<?php

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\Tag;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo 'Pages count: '.Page::count().PHP_EOL;
echo 'Posts count: '.Post::count().PHP_EOL;
echo 'Services count: '.Service::count().PHP_EOL;
echo 'MenuItems count: '.MenuItem::count().PHP_EOL;
echo 'Categories count: '.Category::count().PHP_EOL;
echo 'Tags count: '.Tag::count().PHP_EOL;

echo "\n--- Top Level Menus ---\n";
foreach (MenuItem::whereNull('parent_id')->orderBy('order')->get() as $m) {
    echo "Menu #{$m->id}: {$m->title} ({$m->url})\n";
    foreach ($m->children()->orderBy('order')->get() as $c) {
        echo "   - Child #{$c->id}: {$c->title} ({$c->url})\n";
        foreach ($c->children()->orderBy('order')->get() as $gc) {
            echo "       * GrandChild #{$gc->id}: {$gc->title} ({$gc->url})\n";
        }
    }
}

echo "\n--- First 10 Pages ---\n";
foreach (Page::take(10)->get() as $p) {
    echo "Page: {$p->title} [slug: {$p->slug}]\n";
}

echo "\n--- First 10 Posts ---\n";
foreach (Post::take(10)->get() as $p) {
    echo "Post: {$p->title} [slug: {$p->slug}]\n";
}
