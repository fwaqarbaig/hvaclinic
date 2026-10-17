<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\File;

$posts = Post::all();
$images = [];
foreach ($posts as $p) {
    $img = $p->featured_image;
    $images[$img] = ($images[$img] ?? 0) + 1;
}

echo 'Total posts: '.$posts->count()."\n";
echo 'Unique images used across posts: '.count($images)."\n";
foreach ($images as $img => $count) {
    $exists1 = File::exists(public_path('storage/'.$img)) ? 'YES' : 'NO';
    $exists2 = File::exists(public_path($img)) ? 'YES' : 'NO';
    echo "  - [Used in {$count} posts] '{$img}' | Exists in storage: {$exists1} | Exists in public: {$exists2}\n";
}

echo "\n--- All image files in public/ and storage/ ---\n";
$pubFiles = File::allFiles(public_path());
$mediaPub = [];
foreach ($pubFiles as $f) {
    if (in_array(strtolower($f->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'svg'])) {
        $rel = str_replace(public_path().DIRECTORY_SEPARATOR, '', $f->getPathname());
        $mediaPub[] = $rel;
    }
}
echo 'Total image files in public: '.count($mediaPub)."\n";
foreach (array_slice($mediaPub, 0, 30) as $mp) {
    echo "   * {$mp}\n";
}
