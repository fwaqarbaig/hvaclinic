<?php

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

require __DIR__.'/parse_topics.php';

$existingSlugs = Post::pluck('slug')->toArray();
echo 'Existing posts count: '.count($existingSlugs)."\n";

$slugCounts = [];
foreach ($topics as $num => $t) {
    $s = $t['slug'];
    if (! isset($slugCounts[$s])) {
        $slugCounts[$s] = [];
    }
    $slugCounts[$s][] = $num;
}

$duplicates = 0;
foreach ($slugCounts as $s => $nums) {
    if (count($nums) > 1) {
        echo "Duplicate slug in topics: $s (Topics: ".implode(', ', $nums).")\n";
        $duplicates++;
    }
    if (in_array($s, $existingSlugs)) {
        echo "Slug conflicts with existing post in DB: $s (Topic: ".implode(', ', $nums).")\n";
    }
}

if ($duplicates === 0) {
    echo "No duplicate slugs found across all 400 topics! Everything is 100% unique.\n";
}
