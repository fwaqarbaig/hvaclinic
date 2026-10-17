<?php

use App\Models\Page;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "=== SERVICES ===\n";
foreach (Service::all() as $s) {
    echo "ID: {$s->id} | Slug: {$s->slug} | Title: {$s->title}\n";
    echo "   Keyword: [{$s->focus_keyword}] | Meta Title: [{$s->meta_title}] | Score: {$s->seo_score} | Schema: ".(! empty($s->schema_markup) ? 'SET' : 'NONE')."\n";
}

echo "\n=== PRODUCTS (FLEET) ===\n";
foreach (Product::all() as $p) {
    echo "ID: {$p->id} | Slug: {$p->slug} | Title: {$p->title}\n";
}

echo "\n=== LOCATIONS / CMS PAGES ===\n";
foreach (Page::all() as $page) {
    echo "ID: {$page->id} | Slug: {$page->slug} | Title: {$page->title}\n";
}
