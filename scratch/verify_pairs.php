<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\Page;
use App\Models\Post;
use App\Models\RedirectRule;

$existingRules = RedirectRule::pluck('source_url')->map(fn($u) => trim($u, '/'))->flip()->toArray();

$pairs = [
    // [source_page_path, target_post_path]
    ['services/generator-rental-in-uae/generator-repair-abu-dhabi', 'generator-repair-in-abu-dhabi'],
    ['services/generator-rental-in-uae/generator-amc-uae', 'generator-amc-in-uae'],
    ['services/generator-maintenance-repair-in-uae/generator-repair-in-dubai', 'generator-repair-dubai'],
    ['services/generator-maintenance-repair-in-uae/generator-repair-uae', 'generator-repair-in-uae'],
    ['services/rental-ac-in-uae/rental-ac-in-abu-dhabi', 'rental-ac-in-abu-dhabi'],
];

foreach ($pairs as [$src, $tgt]) {
    $srcPage = Page::where('slug', $src)->first();
    $tgtPost = Post::where('slug', $tgt)->first();
    echo "Pair: /$src/ -> /$tgt/\n";
    echo "  Source Page exists: " . ($srcPage ? "YES (#{$srcPage->id})" : "NO") . "\n";
    echo "  Target Post exists: " . ($tgtPost ? "YES (#{$tgtPost->id})" : "NO") . "\n";
}
