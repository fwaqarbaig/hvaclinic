<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\Page;
use App\Models\Post;
use App\Models\RedirectRule;

$slugs = [
    'generator-repair-in-abu-dhabi',
    'generator-repair-abu-dhabi',
    'generator-amc-in-uae',
    'generator-amc-uae',
    'generator-repair-in-dubai',
    'generator-repair-dubai',
    'generator-repair-in-uae',
    'generator-repair-uae',
    'rental-ac-in-abu-dhabi',
    'rental-ac-abu-in-dhabi',
];

foreach ($slugs as $s) {
    echo "--- Slug: $s ---\n";
    $p = Page::where('slug', 'like', "%$s%")->get(['id', 'slug']);
    foreach ($p as $x) echo "  Page {$x->id}: {$x->slug}\n";
    $post = Post::where('slug', 'like', "%$s%")->get(['id', 'slug']);
    foreach ($post as $x) echo "  Post {$x->id}: {$x->slug}\n";
    $rules = RedirectRule::where('source_url', 'like', "%$s%")->get(['id', 'source_url', 'target_url']);
    foreach ($rules as $x) echo "  Rule {$x->id}: {$x->source_url} -> {$x->target_url}\n";
}
