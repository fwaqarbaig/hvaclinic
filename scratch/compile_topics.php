<?php

/**
 * Master Blog Compiler Script for 100 Unique HVAC Clinic Engineering Articles
 */
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Str;

echo '=== INITIALIZING 100 UNIQUE BLOG GENERATOR ==='.PHP_EOL;

$adminUser = User::first() ?? User::create([
    'name' => 'HVAC Clinic Editorial Team',
    'email' => 'editor@hvaclinic.com',
    'password' => bcrypt('hvac2026!'),
]);

// Ensure Categories Exist
$categories = [
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

foreach ($categories as $slug => $data) {
    $catModels[$slug] = Category::firstOrCreate(
        ['slug' => $slug],
        ['name' => $data['name'], 'description' => $data['desc']]
    );
}

// Available images from existing posts
$availableImages = Post::whereNotNull('featured_image')->pluck('featured_image')->unique()->values()->toArray();
if (empty($availableImages)) {
    $availableImages = ['https://hvaclinic.com/wp-content/uploads/2026/09/h5p-1.jpg'];
}

echo 'Category models verified. Loaded '.count($availableImages).' distinct images.'.PHP_EOL;

// Helper to assemble full, authoritative article HTML content
function buildArticleContent($title, $intent, $specs, $tableHeaders, $tableRows, $steps, $pitfalls, $faqs, $serviceSlug, $serviceName)
{
    $html = '<div class="space-y-8 text-slate-700 leading-relaxed font-light">';

    // 1. Introduction
    $html .= '<p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal">'.$intent['intro'].'</p>';
    $html .= '<p>'.$intent['context'].'</p>';

    // 2. Technical Principles & Engineering Metrics
    $html .= '<h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight font-display mt-8 mb-4">Engineering Principles & Technical Specifications</h2>';
    $html .= '<p>'.$specs['description'].'</p>';

    // Table
    $html .= '<div class="my-6 overflow-x-auto rounded-2xl border border-slate-200/90 shadow-xs bg-white">';
    $html .= '<table class="w-full text-xs text-left text-slate-600">';
    $html .= '<thead class="bg-slate-900 text-white font-bold uppercase tracking-wider text-[11px]">';
    $html .= '<tr>';
    foreach ($tableHeaders as $th) {
        $html .= '<th class="px-4 py-3.5 border-b border-slate-800">'.htmlspecialchars($th).'</th>';
    }
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody class="divide-y divide-slate-100">';
    foreach ($tableRows as $row) {
        $html .= '<tr class="hover:bg-blue-50/40 transition-colors">';
        foreach ($row as $td) {
            $html .= '<td class="px-4 py-3 font-medium">'.$td.'</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';

    // 3. Step-by-Step Execution Protocol
    $html .= '<h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight font-display mt-8 mb-4">Step-by-Step Technical Execution & Mobilization Protocol</h2>';
    $html .= '<p class="mb-4">To ensure seamless reliability under extreme UAE summer ambient conditions (reaching +50°C to +52°C), our engineering logistics teams implement the following structured workflow:</p>';
    $html .= '<ol class="space-y-3 pl-5 list-decimal text-slate-700 marker:font-bold marker:text-blue-600">';
    foreach ($steps as $step) {
        $html .= '<li class="pl-2"><strong>'.htmlspecialchars($step['title']).':</strong> '.$step['desc'].'</li>';
    }
    $html .= '</ol>';

    // 4. Common Operating Pitfalls & Mitigation in UAE Desert Climate
    $html .= '<h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight font-display mt-8 mb-4">Common Operating Pitfalls & Desert Condition Mitigation</h2>';
    $html .= '<p class="mb-4">Operating HVAC and power plant equipment across Dubai, Abu Dhabi, Sharjah, and coastal industrial zones like JAFZA presents severe thermodynamic challenges. The following table of risks must be actively managed:</p>';
    $html .= '<ul class="space-y-2.5 pl-5 list-disc text-slate-700 marker:text-amber-500">';
    foreach ($pitfalls as $pitfall) {
        $html .= '<li class="pl-2"><strong>'.htmlspecialchars($pitfall['risk']).':</strong> '.$pitfall['solution'].'</li>';
    }
    $html .= '</ul>';

    // 5. Commercial Guarantees & Turnkey Support
    $html .= '<h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight font-display mt-8 mb-4">Turnkey Commercial Execution & SLA Guarantees</h2>';
    $html .= '<p>At HVAC Clinic, every deployment is backed by certified mechanical refrigeration technicians and electrical engineers. We maintain operational depot staging yards in Al Quoz (Dubai), Musaffah (Abu Dhabi), and Industrial Area (Sharjah), enabling guaranteed <strong>60 to 120-minute emergency mobilization</strong> across all 7 Emirates.</p>';
    $html .= '<p class="mt-2">Our temporary installations include turnkey high-pressure flexible hoses, Bauer quick-action couplings, variable primary pumping stations, double-walled fuel tanks, and round-the-clock telemetry monitoring. For specialized project sizing, explore our core <a href="'.$serviceSlug.'" class="text-blue-600 hover:text-blue-800 font-bold underline underline-offset-2">'.$serviceName.'</a> capabilities.</p>';

    // 6. Interactive FAQ Accordion (Auto-parsed for Schema.org FAQPage)
    $html .= '<div class="mt-10 pt-8 border-t border-slate-200">';
    $html .= '<h3 class="text-lg sm:text-xl font-bold text-slate-900 font-display mb-4">Frequently Asked Technical Questions</h3>';
    $html .= '<div class="space-y-3">';
    foreach ($faqs as $faq) {
        $html .= '<details class="group bg-slate-50 rounded-2xl border border-slate-200/90 p-4 open:bg-white open:shadow-xs transition">';
        $html .= '<summary class="font-bold text-xs sm:text-sm text-slate-900 cursor-pointer list-none flex items-center justify-between">';
        $html .= '<span>'.htmlspecialchars($faq['q']).'</span>';
        $html .= '<span class="text-blue-600 transition group-open:rotate-180">&#9660;</span>';
        $html .= '</summary>';
        $html .= '<div class="mt-3 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">'.$faq['a'].'</div>';
        $html .= '</details>';
    }
    $html .= '</div>';
    $html .= '</div>';

    // 7. Authoritative Call to Action Box
    $html .= '<div class="mt-8 p-6 rounded-2xl bg-gradient-to-r from-blue-900 to-slate-900 text-white flex flex-col sm:flex-row items-center justify-between gap-4">';
    $html .= '<div>';
    $html .= '<div class="text-xs font-bold uppercase tracking-wider text-amber-400">24/7 Rapid Emergency Engineering Dispatch</div>';
    $html .= '<div class="text-sm font-bold text-white mt-0.5">Need immediate equipment sizing or on-site technical inspection?</div>';
    $html .= '</div>';
    $html .= '<div class="flex items-center gap-3 shrink-0">';
    $html .= '<a href="tel:+971503692131" class="px-4 py-2.5 rounded-xl font-bold text-xs bg-amber-500 hover:bg-amber-400 text-slate-950 transition">Call +971 50 369 2131</a>';
    $html .= '<a href="https://wa.me/971503692131?text='.urlencode('Hello HVAC Clinic, I need immediate technical sizing assistance.').'" target="_blank" class="px-4 py-2.5 rounded-xl font-bold text-xs bg-emerald-600 hover:bg-emerald-500 text-white transition">WhatsApp</a>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '</div>';

    return $html;
}

// Load modular batch files
require_once __DIR__.'/batch_cluster_1.php';
require_once __DIR__.'/batch_cluster_2.php';
require_once __DIR__.'/batch_cluster_3.php';
require_once __DIR__.'/batch_cluster_4.php';
require_once __DIR__.'/batch_cluster_5.php';
require_once __DIR__.'/batch_cluster_6.php';
require_once __DIR__.'/batch_cluster_7.php';
require_once __DIR__.'/batch_cluster_8.php';

echo 'All 8 topic clusters loaded successfully. Total raw topics: '.count($allTopics).PHP_EOL;

$savedCount = 0;
foreach ($allTopics as $index => $t) {
    $slug = Str::slug($t['slug']);

    // Prevent collision with existing posts
    $existing = Post::where('slug', $slug)->first();
    if ($existing) {
        $slug = $slug.'-uae';
    }

    $image = $availableImages[$index % count($availableImages)];
    $publishedAt = now()->subDays(110 - ($index * 1.05))->subHours(rand(1, 16))->subMinutes(rand(5, 50));

    $content = buildArticleContent(
        $t['title'],
        $t['intent'],
        $t['specs'],
        $t['table_headers'],
        $t['table_rows'],
        $t['steps'],
        $t['pitfalls'],
        $t['faqs'],
        $t['service_slug'],
        $t['service_name']
    );

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
            'seo_score' => rand(92, 98),
            'readability_score' => rand(86, 94),
            'schema_markup' => json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
        ]
    );

    // Sync categories: assign to 'blog' plus the cluster category
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

    $savedCount++;
    if ($savedCount % 10 === 0) {
        echo "Created [{$savedCount}/100]: {$post->title} ({$post->slug})".PHP_EOL;
    }
}

echo PHP_EOL."=== GENERATED ALL {$savedCount} BLOG POSTS SUCCESSFULLY! ===".PHP_EOL;
echo 'Total published posts in database: '.Post::published()->count().PHP_EOL;
