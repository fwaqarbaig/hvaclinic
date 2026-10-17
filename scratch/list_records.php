<?php

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "--- PAGES ---\n";
foreach (Page::all(['id', 'slug', 'title', 'template']) as $p) {
    echo "ID {$p->id}: [{$p->slug}] {$p->title} (template: {$p->template})\n";
}

echo "\n--- POSTS ---\n";
foreach (Post::all(['id', 'slug', 'title']) as $p) {
    echo "ID {$p->id}: [{$p->slug}] {$p->title}\n";
}

echo "\n--- SERVICES ---\n";
foreach (Service::all(['id', 'slug', 'title']) as $s) {
    echo "ID {$s->id}: [{$s->slug}] {$s->title}\n";
}

echo "\n--- PRODUCTS ---\n";
foreach (Product::all(['id', 'slug', 'title']) as $pr) {
    echo "ID {$pr->id}: [{$pr->slug}] {$pr->title}\n";
}

echo "\n--- CATEGORIES ---\n";
foreach (Category::all(['id', 'slug', 'name']) as $c) {
    echo "ID {$c->id}: [{$c->slug}] {$c->name}\n";
}
