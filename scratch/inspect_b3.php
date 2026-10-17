<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\Post;
use App\Models\Page;

$postIds = [1084, 1088, 1093, 1103, 1148];
foreach ($postIds as $id) {
    $p = Post::find($id);
    if ($p) {
        $count = substr_count($p->content, 'Generator Dubai');
        echo "Post $id ({$p->slug}): $count occurrences of 'Generator Dubai'\n";
    }
}

$page61 = Page::find(61);
if ($page61) {
    $count = substr_count($page61->content, 'Generator Dubai');
    echo "Page 61 ({$page61->slug}): $count occurrences of 'Generator Dubai'\n";
}

// Also check if any OTHER posts or pages have 'Generator Dubai'
echo "\nTotal posts with 'Generator Dubai': " . Post::where('content', 'like', '%Generator Dubai%')->count() . "\n";
foreach (Post::where('content', 'like', '%Generator Dubai%')->get(['id', 'slug']) as $p) {
    echo "  Post {$p->id}: {$p->slug}\n";
}

echo "Total pages with 'Generator Dubai': " . Page::where('content', 'like', '%Generator Dubai%')->count() . "\n";
foreach (Page::where('content', 'like', '%Generator Dubai%')->get(['id', 'slug']) as $p) {
    echo "  Page {$p->id}: {$p->slug}\n";
}
