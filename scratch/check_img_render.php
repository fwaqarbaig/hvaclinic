<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

$post = Post::first();
echo 'Post ID: '.$post->id."\n";
echo 'featured_image in DB: '.$post->featured_image."\n";
echo 'featured_image_url accessor: '.$post->featured_image_url."\n";

// Check blade files to see how featured_image is rendered
$bladeFiles = [
    'resources/views/frontend/blog/index.blade.php',
    'resources/views/frontend/blog/show.blade.php',
    'resources/views/frontend/home.blade.php',
];

foreach ($bladeFiles as $bf) {
    $path = resource_path('../'.$bf);
    if (file_exists($path)) {
        $c = file_get_contents($path);
        preg_match_all('/(featured_image[^\s"\']*|img[^\n>]*src=[^\n>]*)/i', $c, $matches);
        echo "\nOccurrences in $bf:\n";
        foreach (array_slice($matches[0], 0, 5) as $occ) {
            echo '  '.trim($occ)."\n";
        }
    }
}
