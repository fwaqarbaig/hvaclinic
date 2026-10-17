<?php

use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

require __DIR__.'/test_article_synthesis.php';

$sampleTopic = [
    'num' => 1,
    'cluster' => 1,
    'title' => 'How to Size a 50 kVA Diesel Generator: Single-Phase vs 3-Phase UAE Guide',
    'slug' => 'size-50-kva-generator-uae',
    'keyword' => '50 kva generator rental',
    'intent' => 'Commercial / Sizing',
];

$art = ArticleSynthesizer::synthesize($sampleTopic);

// Extract FAQs from HTML content
$faqs = [];
if (preg_match_all('/<h4[^>]*class="[^"]*text-slate-900[^"]*"[^>]*>(.*?)<\/h4>\s*<p[^>]*class="[^"]*text-slate-600[^"]*"[^>]*>(.*?)<\/p>/is', $art['content'], $matches, PREG_SET_ORDER)) {
    foreach ($matches as $m) {
        $faqs[] = [
            'q' => trim(strip_tags($m[1])),
            'a' => trim(strip_tags($m[2])),
        ];
    }
}

echo 'Extracted FAQs count: '.count($faqs)."\n";
foreach ($faqs as $i => $f) {
    echo '  Q'.($i + 1).': '.$f['q']."\n";
    echo '  A'.($i + 1).': '.substr($f['a'], 0, 80)."...\n";
}

// Build Schema Graph
$baseUrl = config('app.url', 'https://generatordubai.com');
$postUrl = $baseUrl.'/post/'.$art['slug'];
$imageUrl = $baseUrl.$art['featured_image'];

$graph = [
    [
        '@type' => 'BlogPosting',
        '@id' => $postUrl.'#article',
        'isPartOf' => [
            '@type' => 'WebPage',
            '@id' => $postUrl,
        ],
        'headline' => $art['title'],
        'description' => $art['meta_description'],
        'mainEntityOfPage' => $postUrl,
        'datePublished' => now()->toIso8601String(),
        'dateModified' => now()->toIso8601String(),
        'author' => [
            '@type' => 'Organization',
            'name' => 'Generator Dubai Engineering Team',
            'url' => 'https://generatordubai.com',
        ],
        'publisher' => [
            '@type' => 'HomeAndConstructionBusiness',
            '@id' => 'https://generatordubai.com/#organization',
            'name' => 'Generator Dubai',
            'url' => 'https://generatordubai.com',
            'telephone' => '+971569213754',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Suit 44, King Faisal Street',
                'addressLocality' => 'Sharjah',
                'addressRegion' => 'Sharjah',
                'addressCountry' => 'AE',
            ],
        ],
        'image' => [
            '@type' => 'ImageObject',
            'url' => $imageUrl,
            'caption' => $art['title'],
        ],
        'inLanguage' => 'en-AE',
        'articleSection' => 'Generator Engineering & Power Logistics',
    ],
    [
        '@type' => 'BreadcrumbList',
        '@id' => $postUrl.'#breadcrumb',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => $baseUrl,
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => 'Technical Articles',
                'item' => $baseUrl.'/blog',
            ],
            [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $art['title'],
                'item' => $postUrl,
            ],
        ],
    ],
];

if (! empty($faqs)) {
    $faqEntities = [];
    foreach ($faqs as $f) {
        $faqEntities[] = [
            '@type' => 'Question',
            'name' => $f['q'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $f['a'],
            ],
        ];
    }
    $graph[] = [
        '@type' => 'FAQPage',
        '@id' => $postUrl.'#faq',
        'mainEntity' => $faqEntities,
    ];
}

$schemaJson = json_encode([
    '@context' => 'https://schema.org',
    '@graph' => $graph,
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

echo "\nSchema Graph Valid JSON? ".(json_decode($schemaJson) ? 'YES' : 'NO')."\n";
echo 'Total Entities in Graph: '.count($graph)." (BlogPosting, BreadcrumbList, FAQPage)\n";
