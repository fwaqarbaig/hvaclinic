<?php

use App\Models\Media;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "=== MEDIA TABLE CHECK ===\n";
$media = Media::latest()->take(20)->get();
echo 'Total Media records: '.Media::count()."\n";
foreach ($media as $m) {
    $path = public_path('storage/'.ltrim($m->file_path, '/'));
    $exists = file_exists($path) ? 'EXISTS' : "MISSING ($path)";
    echo "ID {$m->id} | {$m->file_name} | {$m->url} | {$exists}\n";
}

echo "\n=== POSTS FEATURED IMAGES ===\n";
foreach (Post::all() as $p) {
    $img = $p->featured_image;
    $clean = ltrim(str_replace('/storage/', '', $img), '/');
    $path = public_path('storage/'.$clean);
    $exists = file_exists($path) ? 'EXISTS' : "MISSING ($path)";
    echo "Post {$p->id} '{$p->title}' | {$img} | {$exists}\n";
}

echo "\n=== PAGES FEATURED IMAGES ===\n";
foreach (Page::all() as $pg) {
    $img = $pg->featured_image;
    if ($img) {
        $clean = ltrim(str_replace('/storage/', '', $img), '/');
        $path = public_path('storage/'.$clean);
        $exists = file_exists($path) ? 'EXISTS' : "MISSING ($path)";
        echo "Page {$pg->id} '{$pg->title}' | {$img} | {$exists}\n";
    }
}

echo "\n=== SERVICES IMAGES ===\n";
foreach (Service::all() as $s) {
    echo "Service {$s->id} '{$s->title}' | icon: {$s->icon}\n";
}
