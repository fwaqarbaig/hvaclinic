<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\RedirectRule;

echo "=== Pages matching 'rental-chiller' ===\n";
foreach (Page::where('slug', 'like', '%rental-chiller%')->get(['id', 'slug', 'title']) as $p) {
    echo "  Page {$p->id}: {$p->slug} -> {$p->title}\n";
}

echo "=== Services matching 'rental-chiller' ===\n";
foreach (Service::where('slug', 'like', '%rental-chiller%')->get(['id', 'slug', 'title']) as $s) {
    echo "  Service {$s->id}: {$s->slug} -> {$s->title}\n";
}

echo "=== Posts matching 'rental-chiller' ===\n";
foreach (Post::where('slug', 'like', '%rental-chiller%')->get(['id', 'slug', 'title']) as $post) {
    echo "  Post {$post->id}: {$post->slug} -> {$post->title}\n";
}

echo "=== Redirect Rules matching 'rental-chiller' ===\n";
foreach (RedirectRule::where('source_url', 'like', '%rental-chiller%')->orWhere('target_url', 'like', '%rental-chiller%')->get(['id', 'source_url', 'target_url']) as $r) {
    echo "  Redirect {$r->id}: {$r->source_url} -> {$r->target_url}\n";
}
