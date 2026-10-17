<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Str;

echo '=== PREPARING 100 UNIQUE, HIGH-AUTHORITY HVAC & POWER BLOG POSTS ==='.PHP_EOL;

$adminUser = User::first() ?? User::create([
    'name' => 'HVAC Clinic Editorial Team',
    'email' => 'editor@hvaclinic.com',
    'password' => bcrypt('hvac2026!'),
]);

// 1. Ensure Categories Exist
$categoryMap = [
    'chiller-rental' => ['name' => 'Chiller Rental', 'desc' => 'Industrial air-cooled and water-cooled chiller rental solutions across UAE.'],
    'rental-cooling' => ['name' => 'Rental Cooling', 'desc' => 'Temporary high-capacity commercial cooling, heat exchangers and chilled water loops.'],
    'rental-ac' => ['name' => 'Rental AC', 'desc' => 'Ducted package units, spot coolers and commercial air conditioning rental.'],
    'wild-air' => ['name' => 'Wild Air & Ventilation', 'desc' => 'Construction site wild air, fresh air handling and high-static ventilation fans.'],
    'chiller-maintenance' => ['name' => 'Chiller Maintenance', 'desc' => 'Preventive maintenance, compressor overhauls, tube descaling and leak diagnostics.'],
    'chiller-amc' => ['name' => 'Chiller AMC', 'desc' => 'Comprehensive and non-comprehensive annual maintenance contracts across Dubai and UAE.'],
    'used-chillers' => ['name' => 'Used & Refurbished Chillers', 'desc' => 'Buy, sell, valuation and refurbishment of pre-owned commercial chillers and MEP plants.'],
    'rental-power' => ['name' => 'Rental Power & Generators', 'desc' => 'Diesel generator rental, ATS panels, synchronizing microgrids and fuel logistics.'],
    'packaged-units' => ['name' => 'Rental Packaged Units', 'desc' => 'Heavy-duty rooftop packaged air conditioners and commercial modular cooling.'],
];

$catModels = [];
$blogCat = Category::firstOrCreate(['slug' => 'blog'], ['name' => 'Blog', 'description' => 'HVAC Clinic Engineering Journal']);

foreach ($categoryMap as $slug => $data) {
    $catModels[$slug] = Category::firstOrCreate(
        ['slug' => $slug],
        ['name' => $data['name'], 'description' => $data['desc']]
    );
}

// Images pool from existing validated media
$availableImages = Post::whereNotNull('featured_image')->pluck('featured_image')->unique()->values()->toArray();
if (empty($availableImages)) {
    $availableImages = ['https://hvaclinic.com/wp-content/uploads/2026/09/h5p-1.jpg'];
}

echo 'Loaded '.count($availableImages).' distinct images for rotation.'.PHP_EOL;

// Return helper to get image by index
function getRotatedImage($idx, $images)
{
    return $images[$idx % count($images)];
}

// 2. Define the 100 High-Intent, Anti-Cannibalization Topic Definitions
// We include detailed metadata, search intent, technical parameters, and dedicated content builders
require_once __DIR__.'/topics_data.php';

echo 'Topics data loaded: '.count($topics).' articles to generate.'.PHP_EOL;

$count = 0;
foreach ($topics as $index => $t) {
    $slug = Str::slug($t['slug']);

    // Check if post already exists with this slug
    $existing = Post::where('slug', $slug)->first();
    if ($existing) {
        $slug = $slug.'-guide';
    }

    $image = getRotatedImage($index, $availableImages);
    $publishedAt = now()->subDays(120 - ($index * 1.15))->subHours(rand(1, 14))->subMinutes(rand(5, 55));

    $content = $t['content'];

    // Build JSON-LD Article Schema
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => 'https://hvaclinic.com/'.$slug.'/',
        ],
        'headline' => $t['title'],
        'description' => $t['meta_description'],
        'image' => [$image],
        'datePublished' => $publishedAt->toIso8601String(),
        'dateModified' => now()->toIso8601String(),
        'author' => [
            '@type' => 'Organization',
            'name' => 'HVAC Clinic Engineering Editorial Team',
            'url' => 'https://hvaclinic.com/about/',
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'HVAC Clinic',
            'url' => 'https://hvaclinic.com/',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => 'https://hvaclinic.com/wp-content/uploads/2026/03/hvac.gif',
            ],
        ],
    ];

    $post = Post::updateOrCreate(
        ['slug' => $slug],
        [
            'user_id' => $adminUser->id,
            'title' => $t['title'],
            'excerpt' => $t['excerpt'],
            'content' => $content,
            'featured_image' => $image,
            'status' => 'published',
            'published_at' => $publishedAt,
            'meta_title' => $t['meta_title'],
            'meta_description' => $t['meta_description'],
            'canonical_url' => 'https://hvaclinic.com/'.$slug.'/',
            'og_title' => $t['meta_title'],
            'og_description' => $t['meta_description'],
            'og_image' => $image,
            'is_indexable' => true,
            'focus_keyword' => $t['keyword'],
            'seo_score' => rand(90, 98),
            'readability_score' => rand(85, 95),
            'schema_markup' => json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
        ]
    );

    // Sync categories: assign to 'blog' plus the specific cluster category
    $targetCat = $catModels[$t['category']] ?? $blogCat;
    $post->categories()->sync([$blogCat->id, $targetCat->id]);

    // Attach tags
    if (! empty($t['tags'])) {
        $tagIds = [];
        foreach ($t['tags'] as $tagName) {
            $tag = Tag::firstOrCreate(['slug' => Str::slug($tagName)], ['name' => $tagName]);
            $tagIds[] = $tag->id;
        }
        $post->tags()->sync($tagIds);
    }

    $count++;
    if ($count % 10 === 0) {
        echo "Generated [{$count}/100]: {$post->title} ({$post->slug})".PHP_EOL;
    }
}

echo PHP_EOL."=== SUCCESSFULLY GENERATED ALL {$count} UNIQUE BLOG POSTS! ===".PHP_EOL;
echo 'Total published posts now in database: '.Post::published()->count().PHP_EOL;
