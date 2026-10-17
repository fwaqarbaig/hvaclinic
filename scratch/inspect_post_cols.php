<?php

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$samplePost = Post::first();
echo 'Post table columns & sample values:'.PHP_EOL;
foreach ($samplePost->toArray() as $k => $v) {
    if (is_string($v) && strlen($v) > 100) {
        $v = substr($v, 0, 100).'...';
    }
    echo "  {$k}: ".(is_array($v) ? json_encode($v) : $v).PHP_EOL;
}
