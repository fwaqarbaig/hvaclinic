<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Str;

echo "=== SYNCING 37 SUB-PAGES AS BLOG POSTS ===\n";

$blogCategory = Category::firstOrCreate(
    ['slug' => 'blog'],
    ['name' => 'Blog', 'description' => 'HVAC Clinic Industry Insights, Guides & Project Updates']
);

$author = User::first();
$authorId = $author ? $author->id : 1;

$services = MenuItem::where('location', 'header')->where('title', 'Services')->first();
$syncedCount = 0;

if ($services) {
    foreach ($services->children as $cat) {
        foreach ($cat->children as $sub) {
            $path = trim($sub->url, '/');
            $page = Page::where('slug', $path)->first();
            if (! $page) {
                echo "[SKIP] Page not found for: {$path}\n";

                continue;
            }

            $leafSlug = basename($path);

            // Check if post already exists with this slug
            $existingPost = Post::where('slug', $leafSlug)->first();

            if ($existingPost) {
                // Ensure it's in the blog category
                if (! $existingPost->categories->contains($blogCategory->id)) {
                    $existingPost->categories()->attach($blogCategory->id);
                }
                echo "[EXISTS] Post already exists: {$leafSlug} (ID: {$existingPost->id})\n";
            } else {
                // Pick an appropriate featured image
                $featuredImage = $page->featured_image;
                if (! $featuredImage) {
                    // Default to high quality relevant asset
                    $featuredImage = '/wp-content/uploads/2026/03/g-2.jpg';
                }

                $excerpt = ! empty($page->meta_description)
                    ? $page->meta_description
                    : Str::limit(strip_tags($page->content), 180);

                $post = Post::create([
                    'user_id' => $authorId,
                    'title' => $page->title,
                    'slug' => $leafSlug,
                    'excerpt' => $excerpt,
                    'content' => $page->content,
                    'featured_image' => $featuredImage,
                    'status' => 'published',
                    'published_at' => $page->created_at ?? now(),
                    'meta_title' => $page->meta_title ?? $page->title,
                    'meta_description' => $page->meta_description ?? $excerpt,
                    'meta_keywords' => $page->meta_keywords,
                    'canonical_url' => url('/'.$leafSlug.'/'),
                    'is_indexable' => true,
                    'seo_score' => $page->seo_score ?? 85,
                    'readability_score' => $page->readability_score ?? 80,
                ]);

                $post->categories()->syncWithoutDetaching([$blogCategory->id]);
                echo "[CREATED] Post created: {$leafSlug} -> ID: {$post->id} (Title: {$post->title})\n";
                $syncedCount++;
            }
        }
    }
}

echo "\nSync Complete! Created {$syncedCount} new blog posts.\n";
echo 'Total posts in DB: '.Post::count()."\n";
echo "Total posts in 'Blog' category: ".$blogCategory->posts()->count()."\n";
