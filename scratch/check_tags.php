<?php

use App\Models\Tag;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

foreach (Tag::all() as $t) {
    echo "Tag: {$t->name} ({$t->slug}) - Posts: ".$t->posts()->count()."\n";
}
