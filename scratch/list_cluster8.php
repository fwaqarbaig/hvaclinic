<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

$c8Posts = Post::where('id', '>=', 923)->orderBy('id')->get();
echo 'Total posts with ID >= 923: '.$c8Posts->count()."\n";
foreach ($c8Posts as $p) {
    echo "ID {$p->id} | {$p->title} | Slug: {$p->slug}\n";
}
