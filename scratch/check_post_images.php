<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

$samplePosts = Post::take(10)->get();
foreach ($samplePosts as $p) {
    echo "ID {$p->id}: featured_image = '{$p->featured_image}'".PHP_EOL;
    echo "       accessor featured_image_url = '{$p->featured_image_url}'".PHP_EOL;
}
