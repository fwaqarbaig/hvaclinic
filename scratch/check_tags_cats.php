<?php

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo 'Total Tags in DB: '.Tag::count()."\n";
echo 'Total Categories in DB: '.Category::count()."\n";
echo "Categories:\n";
foreach (Category::all() as $cat) {
    echo " - ID: {$cat->id} | {$cat->name} | Slug: {$cat->slug} | Posts: ".$cat->posts()->count()."\n";
}
