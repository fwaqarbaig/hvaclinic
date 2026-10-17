<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

$p = Post::find(923);
echo "ID: {$p->id}\n";
echo "Title: {$p->title}\n";
echo "Slug: '{$p->slug}'\n";
echo "Status: {$p->status}\n";
echo 'Published at: '.($p->published_at ? $p->published_at->toDateTimeString() : 'NULL')."\n";
echo 'Now: '.now()->toDateTimeString()."\n";

// Check BlogController::show logic
echo "\nChecking scopePublished:\n";
$publishedCount = Post::where('slug', $p->slug)->published()->count();
echo "Post::where('slug', '{$p->slug}')->published()->count(): {$publishedCount}\n";
