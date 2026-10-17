<?php

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$keywords = [
    'aluminium',
    'aluminum',
    'sub floor',
    'subfloor',
    'modular',
    'smart technology',
    'rapid de',
    'rapid deployment',
    'ground settlement',
    'ground sattlement',
    'siren',
    'emergency siren',
    'data recovery',
    'hard drive',
    'ssd',
    'cleanroom',
];

echo "=== SEARCHING FOR UNRELATED POSTS ===\n";
foreach ($keywords as $kw) {
    $posts = Post::where('title', 'like', "%{$kw}%")
        ->orWhere('content', 'like', "%{$kw}%")
        ->get();
    echo 'Found '.$posts->count()." posts matching '{$kw}'\n";
    foreach ($posts->take(5) as $p) {
        echo "  - ID {$p->id}: {$p->title}\n";
    }
}
