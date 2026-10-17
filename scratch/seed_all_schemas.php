<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

echo "Seeding rich Schema.org JSON-LD across all content models...\n\n";

$companyOrg = [
    '@type' => 'HomeAndConstructionBusiness',
    'name' => 'Generator Dubai',
    'legalName' => 'Generator Dubai Temporary Power Solutions LLC',
    'alternateName' => ['Generator Rental Dubai', 'Rental Generator UAE'],
    'url' => 'https://generatordubai.com',
    'telephone' => '+971569213754',
    'email' => 'hello@generatordubai.com',
    'priceRange' => '$$$',
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => 'Suit 44, King Faisal Street',
        'addressLocality' => 'Sharjah',
        'addressRegion' => 'Sharjah',
        'postalCode' => '00000',
        'addressCountry' => 'AE',
    ],
    'geo' => [
        '@type' => 'GeoCoordinates',
        'latitude' => 25.3463,
        'longitude' => 55.4209,
    ],
];

// ==========================================
// 1. SEED POSTS (6 POSTS)
// ==========================================
echo "1. Seeding Posts...\n";
$posts = Post::all();
foreach ($posts as $post) {
    $canonicalUrl = $post->canonical_url ?: route('post.show', $post->slug);
    $imgUrl = $post->featured_image_url ?: 'https://generatordubai.com/storage/media/2026/09/1-y7ja6x.webp';

    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'BlogPosting',
                '@id' => $canonicalUrl.'#article',
                'isPartOf' => [
                    '@type' => 'WebPage',
                    '@id' => $canonicalUrl,
                ],
                'headline' => $post->title,
                'description' => $post->seo_description ?: $post->excerpt,
                'mainEntityOfPage' => $canonicalUrl,
                'datePublished' => $post->published_at ? $post->published_at->toIso8601String() : now()->toIso8601String(),
                'dateModified' => $post->updated_at->toIso8601String(),
                'author' => [
                    '@type' => 'Organization',
                    'name' => 'Generator Dubai Engineering Team',
                    'url' => 'https://generatordubai.com',
                ],
                'publisher' => $companyOrg,
                'image' => [
                    '@type' => 'ImageObject',
                    'url' => $imgUrl,
                ],
                'inLanguage' => 'en-AE',
                'articleSection' => 'Generator Engineering & Power Logistics',
            ],
            [
                '@type' => 'BreadcrumbList',
                '@id' => $canonicalUrl.'#breadcrumb',
                'itemListElement' => [
                    [
                        '@type' => 'ListItem',
                        'position' => 1,
                        'name' => 'Home',
                        'item' => route('home'),
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 2,
                        'name' => 'Technical Articles',
                        'item' => route('blog.index'),
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 3,
                        'name' => $post->title,
                        'item' => $canonicalUrl,
                    ],
                ],
            ],
        ],
    ];

    $post->update([
        'schema_markup' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    ]);
    echo "  - Post ID {$post->id}: {$post->slug} [DONE]\n";
}

// ==========================================
// 2. SEED SERVICES (8 SERVICES)
// ==========================================
echo "\n2. Seeding Services...\n";
$services = Service::all();
foreach ($services as $service) {
    $serviceUrl = route('service.show', $service->slug);
    $faqsList = [];
    if (! empty($service->faqs) && is_array($service->faqs)) {
        foreach ($service->faqs as $faq) {
            $faqsList[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer'],
                ],
            ];
        }
    }

    $graph = [
        [
            '@type' => 'Service',
            '@id' => $serviceUrl.'#service',
            'name' => $service->title,
            'serviceType' => 'Diesel Power Engineering & Rental',
            'description' => $service->seo_description ?: $service->summary,
            'url' => $serviceUrl,
            'provider' => $companyOrg,
            'areaServed' => [
                'Dubai', 'Abu Dhabi', 'Sharjah', 'Ajman', 'Ras Al Khaimah', 'Fujairah', 'Umm Al Quwain', 'Oman',
            ],
            'offers' => [
                '@type' => 'Offer',
                'priceCurrency' => 'AED',
                'price' => '1000',
                'availability' => 'https://schema.org/InStock',
                'validFrom' => '2026-01-01',
            ],
        ],
        [
            '@type' => 'BreadcrumbList',
            '@id' => $serviceUrl.'#breadcrumb',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => route('home'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Services',
                    'item' => route('service.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $service->title,
                    'item' => $serviceUrl,
                ],
            ],
        ],
    ];

    if (! empty($faqsList)) {
        $graph[] = [
            '@type' => 'FAQPage',
            '@id' => $serviceUrl.'#faq',
            'mainEntity' => $faqsList,
        ];
    }

    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => $graph,
    ];

    $service->update([
        'schema_markup' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    ]);
    echo "  - Service ID {$service->id}: {$service->slug} [DONE]\n";
}

// ==========================================
// 3. SEED PRODUCTS (12 FLEET MODELS)
// ==========================================
echo "\n3. Seeding Products...\n";
$products = Product::all();

$priceMap = [
    '50-kva' => ['low' => 600, 'high' => 3500],
    '100-kva' => ['low' => 900, 'high' => 5000],
    '150-kva' => ['low' => 1200, 'high' => 6500],
    '200-kva' => ['low' => 1500, 'high' => 8000],
    '250-kva' => ['low' => 1800, 'high' => 9500],
    '300-kva' => ['low' => 2100, 'high' => 11000],
    '350-kva' => ['low' => 2400, 'high' => 13000],
    '500-kva' => ['low' => 3200, 'high' => 18000],
    '600-kva' => ['low' => 3800, 'high' => 22000],
    '800-kva' => ['low' => 4800, 'high' => 28000],
    '1000-kva' => ['low' => 6000, 'high' => 35000],
    '1250-kva' => ['low' => 7500, 'high' => 45000],
];

foreach ($products as $prod) {
    $fleetUrl = route('fleet.show', $prod->slug);
    $price = $priceMap[$prod->slug] ?? ['low' => 1500, 'high' => 10000];

    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Product',
                '@id' => $fleetUrl.'#product',
                'name' => $prod->title,
                'description' => $prod->seo_description ?: $prod->summary,
                'brand' => [
                    '@type' => 'Brand',
                    'name' => 'Generator Dubai',
                ],
                'category' => 'Heavy Duty Soundproof Diesel Generator',
                'image' => $prod->featured_image_url ? [$prod->featured_image_url] : [],
                'offers' => [
                    '@type' => 'AggregateOffer',
                    'priceCurrency' => 'AED',
                    'lowPrice' => (string) $price['low'],
                    'highPrice' => (string) $price['high'],
                    'offerCount' => '10',
                    'availability' => 'https://schema.org/InStock',
                    'seller' => $companyOrg,
                    'areaServed' => [
                        'Dubai', 'Abu Dhabi', 'Sharjah', 'Ajman', 'Ras Al Khaimah', 'Fujairah', 'Umm Al Quwain',
                    ],
                ],
                'additionalProperty' => [
                    [
                        '@type' => 'PropertyValue',
                        'name' => 'Operating Temperature',
                        'value' => '50°C High-Ambient Rated',
                    ],
                    [
                        '@type' => 'PropertyValue',
                        'name' => 'Noise Level',
                        'value' => '65 dBA @ 7 meters (Super Silent)',
                    ],
                    [
                        '@type' => 'PropertyValue',
                        'name' => 'Compliance',
                        'value' => 'ISO 8528, ISO 9001, CE Certified',
                    ],
                ],
            ],
            [
                '@type' => 'BreadcrumbList',
                '@id' => $fleetUrl.'#breadcrumb',
                'itemListElement' => [
                    [
                        '@type' => 'ListItem',
                        'position' => 1,
                        'name' => 'Home',
                        'item' => route('home'),
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 2,
                        'name' => 'Fleet',
                        'item' => route('fleet.index'),
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 3,
                        'name' => $prod->title,
                        'item' => $fleetUrl,
                    ],
                ],
            ],
        ],
    ];

    $prod->update([
        'schema_markup' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    ]);
    echo "  - Product ID {$prod->id}: {$prod->slug} [DONE]\n";
}

// ==========================================
// 4. SEED PAGES (16 PAGES)
// ==========================================
echo "\n4. Seeding Pages...\n";
$pages = Page::all();

$cityCoords = [
    'dubai' => ['name' => 'Dubai', 'lat' => 25.2048, 'lon' => 55.2708, 'street' => 'Al Quoz Industrial Area 3'],
    'abu-dhabi' => ['name' => 'Abu Dhabi', 'lat' => 24.4539, 'lon' => 54.3773, 'street' => 'Mussafah Industrial Area'],
    'sharjah' => ['name' => 'Sharjah', 'lat' => 25.3463, 'lon' => 55.4209, 'street' => 'Industrial Area 10 & King Faisal St'],
    'ajman' => ['name' => 'Ajman', 'lat' => 25.4052, 'lon' => 55.5136, 'street' => 'New Industrial Area 2'],
    'ras-al-khaimah' => ['name' => 'Ras Al Khaimah', 'lat' => 25.7895, 'lon' => 55.9432, 'street' => 'Al Hamra & Al Ghail Industrial'],
    'fujairah' => ['name' => 'Fujairah', 'lat' => 25.1288, 'lon' => 56.3265, 'street' => 'Fujairah Free Zone & Port Logistics'],
    'umm-al-quwain' => ['name' => 'Umm Al Quwain', 'lat' => 25.5647, 'lon' => 55.5552, 'street' => 'Old Town Industrial Zone'],
    'oman' => ['name' => 'Oman Border / Sohar', 'lat' => 24.3644, 'lon' => 56.7469, 'street' => 'Wajajah Border & Sohar Industrial Port'],
];

foreach ($pages as $p) {
    $schema = [];

    if ($p->slug === 'home') {
        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                $companyOrg,
                [
                    '@type' => 'WebSite',
                    '@id' => route('home').'#website',
                    'name' => 'Generator Dubai',
                    'url' => route('home'),
                    'description' => 'Turnkey diesel generator rental, sales & power plant engineering across UAE.',
                    'inLanguage' => 'en-AE',
                ],
            ],
        ];
    } elseif ($p->slug === 'about-us') {
        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'AboutPage',
                    '@id' => route('about').'#about',
                    'name' => 'About Generator Dubai',
                    'description' => $p->seo_description ?: 'UAE certified temporary power supplier and diesel generator fleet engineering.',
                    'url' => route('about'),
                    'publisher' => $companyOrg,
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'About Us', 'item' => route('about')],
                    ],
                ],
            ],
        ];
    } elseif ($p->slug === 'fleet') {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Diesel Generator Rental Fleet in UAE (50 kVA - 1250 kVA)',
            'url' => route('fleet.index'),
            'description' => 'Browse our modern acoustic soundproof diesel generator rental fleet.',
            'provider' => $companyOrg,
        ];
    } elseif ($p->slug === 'services') {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Turnkey Temporary Power & Generator Services',
            'url' => route('service.index'),
            'description' => 'Comprehensive generator hire, AMC contracts, 24/7 repair, synchronization, and portacabin power in UAE.',
            'provider' => $companyOrg,
        ];
    } elseif ($p->slug === 'industries') {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Industries Powered by Generator Dubai',
            'url' => route('page.industries'),
            'description' => 'Specialized power generation for Construction, Events, Marine, Healthcare, Oil & Gas, and Data Centers in the UAE.',
            'provider' => $companyOrg,
        ];
    } elseif ($p->slug === 'used-refurbished-generators') {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Used & Refurbished Diesel Generators For Sale in UAE',
            'url' => route('page.used-generators'),
            'description' => 'Certified pre-owned diesel generators load-bank tested with warranty coverage in UAE.',
            'provider' => $companyOrg,
        ];
    } elseif ($p->slug === 'locations') {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Generator Dubai Regional Operational Hubs Across UAE & GCC',
            'url' => route('locations.index'),
            'description' => '24/7 localized generator dispatch hubs in Dubai, Abu Dhabi, Sharjah, Ajman, RAK, Fujairah, UAQ, and Oman.',
            'provider' => $companyOrg,
        ];
    } elseif ($p->slug === 'contact-us') {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'ContactPage',
            'name' => 'Contact Generator Dubai 24/7 Emergency Dispatch',
            'url' => route('contact'),
            'description' => 'Direct contact line and technical engineering consultations for temporary power projects across UAE.',
            'mainEntity' => $companyOrg,
        ];
    } elseif (str_starts_with($p->slug, 'locations/')) {
        $city = str_replace('locations/', '', $p->slug);
        $meta = $cityCoords[$city] ?? ['name' => ucfirst($city), 'lat' => 25.2, 'lon' => 55.3, 'street' => 'Regional Hub'];

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => 'Generator Dubai - '.$meta['name'].' Hub',
            'image' => 'https://generatordubai.com/storage/media/2026/09/1-y7ja6x.webp',
            'telephone' => '+971569213754',
            'email' => 'hello@generatordubai.com',
            'url' => route('locations.show', $city),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $meta['street'],
                'addressLocality' => $meta['name'],
                'addressRegion' => $meta['name'],
                'addressCountry' => ($city === 'oman' ? 'OM' : 'AE'),
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $meta['lat'],
                'longitude' => $meta['lon'],
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    'opens' => '00:00',
                    'closes' => '23:59',
                ],
            ],
            'areaServed' => $meta['name'],
        ];
    } else {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $p->title,
            'description' => $p->seo_description ?: $p->title,
            'url' => url('/page/'.$p->slug),
            'publisher' => $companyOrg,
        ];
    }

    $p->update([
        'schema_markup' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    ]);
    echo "  - Page ID {$p->id}: {$p->slug} [DONE]\n";
}

// ==========================================
// 5. SEED CATEGORIES (17 CATEGORIES)
// ==========================================
echo "\n5. Seeding Categories...\n";
$categories = Category::all();
foreach ($categories as $cat) {
    $catUrl = route('category.show', $cat->slug);

    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'CollectionPage',
                '@id' => $catUrl.'#collection',
                'name' => $cat->name.' - Technical Resource Archive',
                'description' => $cat->description ?: ('Explore generator rental and power engineering articles in category '.$cat->name),
                'url' => $catUrl,
                'publisher' => $companyOrg,
                'inLanguage' => 'en-AE',
            ],
            [
                '@type' => 'BreadcrumbList',
                '@id' => $catUrl.'#breadcrumb',
                'itemListElement' => [
                    [
                        '@type' => 'ListItem',
                        'position' => 1,
                        'name' => 'Home',
                        'item' => route('home'),
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 2,
                        'name' => 'Categories',
                        'item' => route('blog.index'),
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 3,
                        'name' => $cat->name,
                        'item' => $catUrl,
                    ],
                ],
            ],
        ],
    ];

    $cat->update([
        'schema_markup' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    ]);
    echo "  - Category ID {$cat->id}: {$cat->slug} [DONE]\n";
}

echo "\nAll Schema.org JSON-LD seedings successfully finished!\n";
