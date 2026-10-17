<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

$c7Posts = Post::where('id', '>=', 863)->where('id', '<', 923)->orderBy('id')->get();
echo 'Cluster 7 posts count: '.$c7Posts->count()."\n";
foreach ($c7Posts as $p) {
    echo "ID {$p->id} | {$p->title} | Slug: {$p->slug}\n";
}
