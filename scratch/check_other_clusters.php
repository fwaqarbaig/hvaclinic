<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\Page;
use App\Models\Post;

echo "=== AC Maintenance Pages vs Posts ===\n";
foreach (Page::where('slug', 'like', 'services/ac-maintenance%')->get() as $p) {
    $leaf = basename($p->slug);
    $post = Post::where('slug', $leaf)->first();
    echo "  Page {$p->id} ({$p->slug}) -> Post: " . ($post ? "FOUND (#{$post->id}: {$post->slug})" : "NONE") . "\n";
}

echo "=== Rental Chiller Pages vs Posts ===\n";
foreach (Page::where('slug', 'like', 'services/rental-chiller%')->get() as $p) {
    $leaf = basename($p->slug);
    $post = Post::where('slug', $leaf)->first();
    echo "  Page {$p->id} ({$p->slug}) -> Post: " . ($post ? "FOUND (#{$post->id}: {$post->slug})" : "NONE") . "\n";
}
