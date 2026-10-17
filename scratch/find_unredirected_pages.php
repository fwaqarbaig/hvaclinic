<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\Page;
use App\Models\Post;
use App\Models\RedirectRule;

$redirects = RedirectRule::where('is_active', true)->pluck('target_url', 'source_url')->toArray();

// Find all pages under services/
$pages = Page::where('status', 'published')->where('slug', 'like', 'services/%')->get();

foreach ($pages as $p) {
    $slugWithSlash = '/' . $p->slug . '/';
    $slugNoSlash = '/' . $p->slug;
    
    $hasRedirect = isset($redirects[$slugNoSlash]) || isset($redirects[$slugWithSlash]);
    if (!$hasRedirect) {
        echo "Live Page (no redirect rule): /{$p->slug}/\n";
    }
}
