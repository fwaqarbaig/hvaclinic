<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Contracts\Console\Kernel;

echo "=== CATEGORIES ===\n";
foreach (Category::all() as $c) {
    echo "ID: {$c->id} | Slug: {$c->slug} | Name: {$c->name}\n";
}

echo "\n=== TAGS ===\n";
foreach (Tag::all() as $t) {
    echo "ID: {$t->id} | Slug: {$t->slug} | Name: {$t->name}\n";
}
