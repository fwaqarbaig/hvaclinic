<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\Page;
use App\Models\Post;
use App\Models\RedirectRule;

$activeRedirectSources = RedirectRule::where('is_active', true)->pluck('source_url')->map(function($u) {
    return trim($u, '/');
})->flip()->toArray();

echo "Active redirect sources count: " . count($activeRedirectSources) . "\n";

$pages = Page::where('status', 'published')->get(['id', 'slug', 'title']);
$posts = Post::where('status', 'published')->get(['id', 'slug', 'title']);

echo "Total published pages: " . $pages->count() . "\n";
echo "Total published posts: " . $posts->count() . "\n\n";

// Check exact or near-match between posts and nested pages
$matches = [];
foreach ($posts as $post) {
    $postSlug = $post->slug;
    $postNorm = str_replace(['-in-uae', '-in-dubai', '-in-abu-dhabi', '-in-sharjah', '-uae', '-dubai', '-abu-dhabi', '-sharjah'], '', $postSlug);
    
    // Check if post is already redirected
    if (isset($activeRedirectSources[$postSlug])) {
        continue;
    }
    
    foreach ($pages as $page) {
        $pageSlug = $page->slug;
        $pageLeaf = basename($pageSlug);
        $pageNorm = str_replace(['-in-uae', '-in-dubai', '-in-abu-dhabi', '-in-sharjah', '-uae', '-dubai', '-abu-dhabi', '-sharjah'], '', $pageLeaf);
        
        // Exact match
        if ($postSlug === $pageLeaf) {
            $matches[] = [
                'type' => 'EXACT',
                'post_id' => $post->id,
                'post_slug' => $postSlug,
                'page_id' => $page->id,
                'page_slug' => $pageSlug,
            ];
        } elseif ($postSlug === 'generator-repair-in-abu-dhabi' && $pageLeaf === 'generator-repair-abu-dhabi') {
            $matches[] = [
                'type' => 'SLUG_IN_PAIR',
                'post_id' => $post->id,
                'post_slug' => $postSlug,
                'page_id' => $page->id,
                'page_slug' => $pageSlug,
            ];
        } elseif ($postNorm === $pageNorm && strlen($postNorm) > 10) {
            // Check similarity
            similar_text($postSlug, $pageLeaf, $percent);
            if ($percent > 70) {
                $matches[] = [
                    'type' => 'SIMILAR (' . round($percent) . '%)',
                    'post_id' => $post->id,
                    'post_slug' => $postSlug,
                    'page_id' => $page->id,
                    'page_slug' => $pageSlug,
                ];
            }
        }
    }
}

foreach ($matches as $m) {
    echo sprintf("[%s] Post #%d (/%s) vs Page #%d (/%s/)\n", $m['type'], $m['post_id'], $m['post_slug'], $m['page_id'], $m['page_slug']);
}
