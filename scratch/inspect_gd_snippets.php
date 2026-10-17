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
        echo "=== Post $id ({$p->slug}) ===\n";
        preg_match_all('/.{0,50}generator dubai.{0,50}/i', $p->content, $matches);
        foreach ($matches[0] as $snippet) {
            echo "  ... " . trim(preg_replace('/\s+/', ' ', $snippet)) . " ...\n";
        }
    }
}

$page61 = Page::find(61);
if ($page61) {
    echo "=== Page 61 ({$page61->slug}) ===\n";
    preg_match_all('/.{0,50}generator dubai.{0,50}/i', $page61->content, $matches);
    foreach ($matches[0] as $snippet) {
        echo "  ... " . trim(preg_replace('/\s+/', ' ', $snippet)) . " ...\n";
    }
}
