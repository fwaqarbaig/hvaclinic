<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

$slugs = [
    'rental-cooling-in-uae',
    'rental-cooling-in-dubai',
    'rental-cooling-in-abu-dhabi',
    'rental-ac-in-dubai',
    'rental-ac-in-sharjah',
    'rental-ac-abu-in-dhabi',
    'portable-ac-rental-in-dubai',
    'floor-standing-ac-rental-in-uae',
    'wild-air-in-uae',
    'wild-air-dubai',
    'chiller-maintenance-in-dubai',
    'generator-rental-dubai',
    'generator-maintenance-in-dubai',
    'used-chiller-for-sale-in-dubai',
];

foreach ($slugs as $slug) {
    $post = Post::where('slug', $slug)->first();
    if ($post) {
        $cats = $post->categories->pluck('name')->implode(', ');
        echo "[FOUND] {$slug} -> Title: {$post->title} | Categories: [{$cats}] | Status: {$post->status}\n";
    } else {
        echo "[NOT FOUND] {$slug}\n";
    }
}
