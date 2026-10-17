<?php

use App\Models\Category;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

foreach (Category::all() as $c) {
    echo $c->id.': '.$c->name.' ('.$c->slug.') - posts: '.$c->posts()->count().PHP_EOL;
}
