<?php

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$posts = Post::where('status', 'published')->get();
$missingCount = 0;
$noImageCount = 0;

$availableImages = [
    '/storage/media/2026/09/1-y7ja6x.webp',
    '/storage/media/2026/10/01-lptck9.jpg',
    '/storage/media/2026/10/02-xbimnj.jpg',
    '/storage/media/2026/10/03-8ab0vq.jpg',
    '/storage/media/2026/10/04-be9wys.jpg',
    '/storage/media/2026/10/05-6dnzah.jpg',
    '/storage/media/2026/10/06-wx9o27.jpg',
    '/storage/media/2026/10/2-im4l8z.jpg',
    '/storage/media/2026/10/3-ki2rou.jpg',
    '/storage/media/2026/10/4-s0ctda.jpg',
    '/storage/media/2026/10/5-5gbsbw.jpg',
    '/storage/media/2026/10/a-s4fzr8.jpg',
    '/storage/media/2026/10/b-wchmjz.jpg',
    '/storage/media/2026/10/c-br1a7y.jpg',
    '/storage/media/2026/10/d-exewmv.jpg',
    '/storage/media/2026/10/e-sajmqx.jpg',
    '/storage/media/2026/10/blog/ats-switch-guide.jpg',
    '/storage/media/2026/10/blog/fuel-consumption.jpg',
    '/storage/media/2026/10/blog/generator-sizing-guide.jpg',
    '/storage/media/2026/10/blog/high-ambient-50c.jpg',
    '/storage/media/2026/10/blog/portacabin-power-wiring.jpg',
    '/storage/media/2026/10/blog/prime-vs-standby.jpg',
];

$i = 0;
foreach ($posts as $post) {
    $img = $post->featured_image;
    if (empty($img)) {
        $noImageCount++;
        // Assign from pool
        $assigned = $availableImages[$i % count($availableImages)];
        $post->update(['featured_image' => $assigned]);
        $i++;

        continue;
    }

    $clean = ltrim(str_replace('/storage/', '', $img), '/');
    $path = public_path('storage/'.$clean);
    if (! file_exists($path)) {
        $missingCount++;
        $assigned = $availableImages[$i % count($availableImages)];
        $post->update(['featured_image' => $assigned]);
        $i++;
    }
}

echo 'Total published posts: '.$posts->count()."\n";
echo "Fixed missing images: {$missingCount}\n";
echo "Fixed empty images: {$noImageCount}\n";

$recheck = Post::where('status', 'published')->get();
$stillMissing = 0;
foreach ($recheck as $p) {
    $clean = ltrim(str_replace('/storage/', '', $p->featured_image), '/');
    if (! file_exists(public_path('storage/'.$clean))) {
        $stillMissing++;
    }
}
echo "Still missing after check: {$stillMissing}\n";
