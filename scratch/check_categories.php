<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use Illuminate\Contracts\Console\Kernel;

foreach (Category::all() as $c) {
    echo "ID: {$c->id} | Slug: {$c->slug} | Name: {$c->name} | Posts: ".$c->posts()->count()."\n";
}
