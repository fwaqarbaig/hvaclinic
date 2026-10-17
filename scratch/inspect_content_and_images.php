<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

echo "=== INSPECTING PUBLIC STORAGE MEDIA IMAGES ===\n";
$files = glob(public_path('storage/media/2026/10/*.*'));
foreach ($files as $f) {
    $info = @getimagesize($f);
    echo basename($f).': '.($info ? ($info[0].'x'.$info[1].' '.$info['mime']) : 'invalid')."\n";
}

echo "\n=== INSPECTING POSTS INTERNAL LINKS IN CONTENT ===\n";
foreach (Post::all() as $post) {
    preg_match_all('/href=[\'"]([^\'"]+)[\'"]/', $post->content, $matches);
    $links = $matches[1] ?? [];
    echo "Post #{$post->id} ({$post->slug}) has ".count($links)." links:\n";
    foreach ($links as $l) {
        echo "   - $l\n";
    }
}
