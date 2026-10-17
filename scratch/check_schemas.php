<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\Page;
use App\Models\Post;
use App\Models\Service;

echo "Pages with schema_markup: " . Page::whereNotNull('schema_markup')->where('schema_markup', '!=', '')->count() . "\n";
foreach (Page::whereNotNull('schema_markup')->where('schema_markup', '!=', '')->get(['id', 'slug', 'title']) as $p) {
    echo "  Page {$p->id} ({$p->slug}): {$p->title}\n";
}

echo "Posts with schema_markup: " . Post::whereNotNull('schema_markup')->where('schema_markup', '!=', '')->count() . "\n";
echo "Services with schema_markup: " . Service::whereNotNull('schema_markup')->where('schema_markup', '!=', '')->count() . "\n";
