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

echo "========================================================\n";
echo "GENERATOR DUBAI: MASTER MEDIA, SCHEMA & LINK ENRICHMENT\n";
echo "========================================================\n\n";

$companyOrg = [
    '@type' => 'HomeAndConstructionBusiness',
    '@id' => 'https://generatordubai.com/#organization',
    'name' => 'Generator Dubai',
    'legalName' => 'Generator Dubai Temporary Power Solutions LLC',
    'alternateName' => ['Generator Rental Dubai', 'Rental Generator UAE'],
    'url' => 'https://generatordubai.com',
    'logo' => 'https://generatordubai.com/images/logo-original.png',
    'image' => 'https://generatordubai.com/storage/media/2026/09/1-y7ja6x.webp',
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
    'openingHoursSpecification' => [
        [
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            'opens' => '00:00',
            'closes' => '23:59',
        ],
    ],
    'areaServed' => [
        'Dubai', 'Abu Dhabi', 'Sharjah', 'Ajman', 'Ras Al Khaimah', 'Fujairah', 'Umm Al Quwain', 'Oman',
    ],
    'sameAs' => [
        'https://wa.me/971569213754',
    ],
];

// ==========================================
// 1. PRODUCTS (FLEET) ENRICHMENT
// ==========================================
echo "1. Enriching Products (Fleet)...\n";

$productImages = [
    '50-kva' => '/storage/media/2026/10/2-im4l8z.jpg',
    '100-kva' => '/storage/media/2026/10/2-im4l8z.jpg',
    '150-kva' => '/storage/media/2026/10/2-im4l8z.jpg',
    '200-kva' => '/storage/media/2026/10/2-im4l8z.jpg',
    '250-kva' => '/storage/media/2026/10/2-im4l8z.jpg',
    '300-kva' => '/storage/media/2026/10/3-ki2rou.jpg',
    '350-kva' => '/storage/media/2026/10/3-ki2rou.jpg',
    '500-kva' => '/storage/media/2026/10/3-ki2rou.jpg',
    '600-kva' => '/storage/media/2026/10/4-s0ctda.jpg',
    '800-kva' => '/storage/media/2026/10/4-s0ctda.jpg',
    '1000-kva' => '/storage/media/2026/10/5-5gbsbw.jpg',
    '1250-kva' => '/storage/media/2026/10/5-5gbsbw.jpg',
];

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

foreach (Product::all() as $prod) {
    $img = $productImages[$prod->slug] ?? '/storage/media/2026/10/2-im4l8z.jpg';
    $fullImgUrl = 'https://generatordubai.com'.$img;
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
                'image' => [$fullImgUrl],
                'brand' => [
                    '@type' => 'Brand',
                    'name' => 'Generator Dubai',
                ],
                'category' => 'Heavy Duty Soundproof Diesel Generator',
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
        'featured_image' => $img,
        'og_image' => $fullImgUrl,
        'schema_markup' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    ]);
    echo "  [OK] Product #{$prod->id} ({$prod->slug}): Image -> $img, Schema Image -> $fullImgUrl\n";
}

// ==========================================
// 2. SERVICES ENRICHMENT
// ==========================================
echo "\n2. Enriching Services...\n";

$serviceImages = [
    'rental-power' => '/storage/media/2026/10/05-6dnzah.jpg',
    'power-plant' => '/storage/media/2026/10/5-5gbsbw.jpg',
    'amc-generator' => '/storage/media/2026/10/02-xbimnj.jpg',
    'maintenance' => '/storage/media/2026/10/01-lptck9.jpg',
    'portacabin' => '/storage/media/2026/10/06-wx9o27.jpg',
    'we-offer' => '/storage/media/2026/10/04-be9wys.jpg',
    'new-generators' => '/storage/media/2026/10/2-im4l8z.jpg',
    'used-refurbished-generators' => '/storage/media/2026/10/03-8ab0vq.jpg',
];

foreach (Service::all() as $service) {
    $img = $serviceImages[$service->slug] ?? '/storage/media/2026/10/05-6dnzah.jpg';
    $fullImgUrl = 'https://generatordubai.com'.$img;
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
            'image' => $fullImgUrl,
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
        'featured_image' => $img,
        'og_image' => $fullImgUrl,
        'schema_markup' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    ]);
    echo "  [OK] Service #{$service->id} ({$service->slug}): Image -> $img, Schema Image -> $fullImgUrl\n";
}

// ==========================================
// 3. POSTS ENRICHMENT WITH INTERNAL LINKS
// ==========================================
echo "\n3. Enriching Posts with Content Internal Links & Schema Images...\n";

$postEnrichments = [
    'generator-sizing-guide-dubai-construction-kva' => [
        'image' => '/storage/media/2026/10/blog/generator-sizing-guide.jpg',
        'content' => '<h2>Understanding Electrical Load Dynamics on UAE Construction Sites</h2>
<p>Selecting the correct generator capacity is one of the most critical engineering decisions on any construction or infrastructure project in the United Arab Emirates. An undersized generator will trip under peak motor-starting currents, causing crane stoppages and concrete pour delays. Conversely, a significantly oversized unit operating below 30% capacity will suffer from wet stacking, incomplete fuel combustion, and unnecessary diesel expenditure. Learn more about our <a href="/service/rental-power" class="text-amber-600 font-bold hover:underline">turnkey rental power solutions</a> designed to avoid these risks.</p>

<h3>Step 1: Distinguish Between Continuous (Running) kW and Peak (Starting) kVA</h3>
<p>Most electrical equipment on site has two distinct power ratings:</p>
<ul>
    <li><strong>Running Load (kW):</strong> The continuous real power drawn during normal steady-state operation.</li>
    <li><strong>Starting Load (kVA):</strong> The transient surge drawn when electric motors initialize across-the-line (Direct-On-Line or DOL), which can be 300% to 600% higher than running amperage. Check our <a href="/fleet/50-kva" class="text-amber-600 font-bold hover:underline">50 kVA generator</a> for small site loads or scale up to our <a href="/fleet/500-kva" class="text-amber-600 font-bold hover:underline">500 kVA heavy industrial gensets</a> for high-inrush machinery.</li>
</ul>

<h3>Step 2: Accounting for the UAE Power Factor (0.8 PF)</h3>
<p>In standard 3-phase commercial and industrial diesel generators operating at 400V / 50Hz, the power factor is standardly rated at <strong>0.8</strong>. The relationship between apparent power (kVA) and real active power (kW) is:</p>
<blockquote>$$\text{kVA} = \frac{\text{kW}}{\text{Power Factor}} = \frac{\text{kW}}{0.8}$$</blockquote>
<p>For example, if your total site continuous requirement is 160 kW, the minimum prime generator rating required is: $160 \div 0.8 = 200\text{ kVA}$. Explore our <a href="/fleet/200-kva" class="text-amber-600 font-bold hover:underline">200 kVA silent generator fleet</a> for precise specs.</p>

<h3>Step 3: Calculating Motor In-Rush Currents</h3>
<table class="w-full text-left border-collapse my-6 text-sm">
    <thead>
        <tr class="border-b border-slate-300 bg-slate-100">
            <th class="p-3">Motor Starting Method</th>
            <th class="p-3">Multiplier on Full Load Amps</th>
            <th class="p-3">Recommended Generator Capacity</th>
        </tr>
    </thead>
    <tbody>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold">Direct-On-Line (DOL)</td>
            <td class="p-3">6.0x</td>
            <td class="p-3">Requires oversized alternator or heavy <a href="/fleet/500-kva" class="text-amber-600 font-bold hover:underline">500 kVA+ set</a></td>
        </tr>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold">Star-Delta Starter</td>
            <td class="p-3">3.0x</td>
            <td class="p-3">Standard generator sizing with 25% safety headroom (<a href="/fleet/250-kva" class="text-amber-600 font-bold hover:underline">250 kVA model</a>)</td>
        </tr>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold">Variable Frequency Drive (VFD)</td>
            <td class="p-3">1.2x – 1.5x</td>
            <td class="p-3">Optimal efficiency, matches generator rating closely</td>
        </tr>
    </tbody>
</table>

<h3>Step 4: High Ambient Temperature Deration in Summer (50°C+)</h3>
<p>During UAE peak summer months (June to September), ambient temperatures frequently exceed 45°C to 50°C. Standard ISO 8528 conditions assume 25°C ambient temperature. In desert conditions, air density decreases, reducing engine oxygen intake and radiator heat exchange efficiency. Read our comprehensive analysis on <a href="/post/high-ambient-generator-performance-50c-middle-east" class="text-amber-600 font-bold hover:underline">high-ambient 50°C generator performance</a>. Generator Dubai specifies heavy-duty 55°C tropical radiators on all rental sets, ensuring zero deration across our <a href="/locations/dubai" class="text-amber-600 font-bold hover:underline">Dubai hub</a> and <a href="/locations/abu-dhabi" class="text-amber-600 font-bold hover:underline">Abu Dhabi depot</a>.</p>

<div class="my-8 p-6 rounded-2xl bg-amber-50 border border-amber-200">
    <h4 class="text-base font-extrabold text-amber-950 mb-2">Related Engineering Guides & Services:</h4>
    <ul class="space-y-1.5 text-xs text-amber-900 font-medium">
        <li>&bull; Understand ISO 8528 ratings: <a href="/post/prime-vs-standby-generator-power-uae-iso8528" class="font-bold underline hover:text-amber-700">Prime vs Standby Power Standards for GCC Projects</a></li>
        <li>&bull; Optimize operational fuel expenditure: <a href="/post/diesel-generator-fuel-consumption-optimization-uae" class="font-bold underline hover:text-amber-700">Diesel Generator Fuel Consumption Guide</a></li>
        <li>&bull; Powering site compounds & cabins: <a href="/service/portacabin" class="font-bold underline hover:text-amber-700">Portacabin & Site Office Power Packages</a></li>
    </ul>
</div>

<h3>Need an On-Site Electrical Load Profile?</h3>
<p>Generator Dubai provides complimentary on-site load audits and single-line diagram reviews across Dubai, Abu Dhabi, and Sharjah. Call our engineering hotline at <strong>+971 56 921 3754</strong> or <a href="/contact-us" class="text-amber-600 font-bold hover:underline">request an instant engineering proposal</a> within 15 minutes.</p>',
    ],

    'prime-vs-standby-generator-power-uae-iso8528' => [
        'image' => '/storage/media/2026/10/blog/prime-vs-standby.jpg',
        'content' => '<h2>The Critical Difference Between Standby, Prime, and Continuous Generator Ratings</h2>
<p>One of the most frequent specification errors encountered in the UAE plant rental market is deploying an Emergency Standby Power (ESP) rated generator in a continuous or prime role. This misunderstanding leads to engine overheating, premature component wear, and unexpected power outages on mission-critical job sites. Before hiring equipment, review our <a href="/fleet" class="text-amber-600 font-bold hover:underline">complete fleet of ISO 8528 prime-rated generators</a>.</p>

<h3>ISO 8528-1 International Power Classifications</h3>
<ul>
    <li><strong>Emergency Standby Power (ESP):</strong> Maximum power available under variable electrical load conditions for the duration of a municipal grid outage. ESP ratings permit a maximum 200 hours of operation per year with an average load factor not exceeding 70%. ESP sets carry zero overload capability. For facility backup, integrate our <a href="/post/ats-automatic-transfer-switch-setup-uae-guide" class="text-amber-600 font-bold hover:underline">Automatic Transfer Switch (ATS) panels</a>.</li>
    <li><strong>Prime Running Power (PRP):</strong> Unlimited hours of operation per year under variable electrical loads. PRP ratings permit an average 24-hour load factor of 70%, with a 10% overload capacity available for 1 hour every 12 hours. This is the industry standard across all our <a href="/service/rental-power" class="text-amber-600 font-bold hover:underline">temporary power rentals</a>.</li>
    <li><strong>Continuous Operating Power (COP):</strong> Unlimited annual operating hours at a constant 100% electrical load. Used for base-load utility substations, island grids, and synchronized <a href="/service/power-plant" class="text-amber-600 font-bold hover:underline">multi-megawatt temporary power plants</a>.</li>
</ul>

<h3>Comparison Summary</h3>
<table class="w-full text-left border-collapse my-6 text-sm">
    <thead>
        <tr class="border-b border-slate-300 bg-slate-100">
            <th class="p-3">Feature</th>
            <th class="p-3">Standby Power (ESP)</th>
            <th class="p-3">Prime Power (PRP)</th>
            <th class="p-3">Continuous (COP)</th>
        </tr>
    </thead>
    <tbody>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold">Annual Operating Hours</td>
            <td class="p-3">Max 200 hrs/year</td>
            <td class="p-3">Unlimited</td>
            <td class="p-3">Unlimited</td>
        </tr>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold">Average Load Factor</td>
            <td class="p-3">70%</td>
            <td class="p-3">70%</td>
            <td class="p-3">100% continuous</td>
        </tr>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold">10% Overload Margin</td>
            <td class="p-3">No overload permitted</td>
            <td class="p-3">1 hr in 12 hrs permitted</td>
            <td class="p-3">No overload permitted</td>
        </tr>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold">Typical Application</td>
            <td class="p-3">Building backup / DEWA outage</td>
            <td class="p-3"><a href="/industries" class="text-amber-600 font-bold hover:underline">Construction / Plant rental</a></td>
            <td class="p-3">Multi-MW utility grid feed</td>
        </tr>
    </tbody>
</table>

<h3>Why Generator Dubai Rates Every Fleet Unit at Prime Capacity</h3>
<p>Every generator deployed by Generator Dubai is rated and tested at its true <strong>Prime Power (PRP)</strong> capacity. When you rent a <a href="/fleet/500-kva" class="text-amber-600 font-bold hover:underline">500 kVA silent generator</a> or a heavy <a href="/fleet/1250-kva" class="text-amber-600 font-bold hover:underline">1250 kVA containerized unit</a> from our fleet, you receive 100% true prime capability engineered with Stamford alternators and Cummins or Perkins heavy-duty diesel engines. Learn how to calculate your site consumption in our <a href="/post/diesel-generator-fuel-consumption-optimization-uae" class="text-amber-600 font-bold hover:underline">fuel consumption benchmark guide</a>, or contact our team across <a href="/locations/dubai" class="text-amber-600 font-bold hover:underline">Dubai</a> and <a href="/locations/sharjah" class="text-amber-600 font-bold hover:underline">Sharjah</a>.</p>',
    ],

    'diesel-generator-fuel-consumption-optimization-uae' => [
        'image' => '/storage/media/2026/10/blog/fuel-consumption.jpg',
        'content' => '<h2>Calculating Fuel Consumption for UAE Generator Operations</h2>
<p>Fuel represents up to 70% of the total operating expenditure of a temporary power installation over a multi-month project. Accurately estimating fuel burn rates is essential for budgeting diesel deliveries, sizing external double-walled bulk tanks, and optimizing operational schedules. Pair your power rental with our <a href="/service/amc-generator" class="text-amber-600 font-bold hover:underline">annual maintenance contracts (AMC)</a> and routine injector tuning to save up to 15% on diesel expenses.</p>

<h3>Benchmark Fuel Consumption Table (Liters / Hour)</h3>
<table class="w-full text-left border-collapse my-6 text-sm">
    <thead>
        <tr class="border-b border-slate-300 bg-slate-100">
            <th class="p-3">kVA Capacity</th>
            <th class="p-3">kW Output</th>
            <th class="p-3">50% Load (L/hr)</th>
            <th class="p-3">75% Load (L/hr)</th>
            <th class="p-3">100% Load (L/hr)</th>
        </tr>
    </thead>
    <tbody>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold"><a href="/fleet/50-kva" class="text-amber-600 font-bold hover:underline">50 kVA</a></td>
            <td class="p-3">40 kW</td>
            <td class="p-3">6.5 L/hr</td>
            <td class="p-3">9.1 L/hr</td>
            <td class="p-3">12.5 L/hr</td>
        </tr>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold"><a href="/fleet/100-kva" class="text-amber-600 font-bold hover:underline">100 kVA</a></td>
            <td class="p-3">80 kW</td>
            <td class="p-3">11.8 L/hr</td>
            <td class="p-3">16.5 L/hr</td>
            <td class="p-3">22.0 L/hr</td>
        </tr>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold"><a href="/fleet/250-kva" class="text-amber-600 font-bold hover:underline">250 kVA</a></td>
            <td class="p-3">200 kW</td>
            <td class="p-3">28.0 L/hr</td>
            <td class="p-3">38.2 L/hr</td>
            <td class="p-3">52.0 L/hr</td>
        </tr>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold"><a href="/fleet/500-kva" class="text-amber-600 font-bold hover:underline">500 kVA</a></td>
            <td class="p-3">400 kW</td>
            <td class="p-3">54.0 L/hr</td>
            <td class="p-3">74.0 L/hr</td>
            <td class="p-3">99.0 L/hr</td>
        </tr>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold"><a href="/fleet/1000-kva" class="text-amber-600 font-bold hover:underline">1000 kVA</a></td>
            <td class="p-3">800 kW</td>
            <td class="p-3">105.0 L/hr</td>
            <td class="p-3">145.0 L/hr</td>
            <td class="p-3">198.0 L/hr</td>
        </tr>
    </tbody>
</table>

<h3>External Bunded Fuel Tanks & Automatic Refilling</h3>
<p>While standard silent canopy units include an internal base fuel tank supporting 8 to 14 hours of continuous operation, remote projects or 24/7 industrial facilities require external double-walled bunded fuel storage (1,000 to 20,000 Liters). Generator Dubai provides turnkey fuel management with digital telemetry and scheduled ADNOC diesel replenishment. Check our <a href="/service/maintenance" class="text-amber-600 font-bold hover:underline">preventative generator maintenance services</a> or read our <a href="/post/generator-sizing-guide-dubai-construction-kva" class="text-amber-600 font-bold hover:underline">generator sizing calculations guide</a> to ensure your generator is running at the optimal 70–80% load sweet spot.</p>

<p>For operations in remote desert locations, discover our logistics capabilities in <a href="/locations/abu-dhabi" class="text-amber-600 font-bold hover:underline">Abu Dhabi</a> and <a href="/locations/ras-al-khaimah" class="text-amber-600 font-bold hover:underline">Ras Al Khaimah</a>, or <a href="/contact-us" class="text-amber-600 font-bold hover:underline">contact our fueling operations desk</a> for immediate bulk diesel logistics.</p>',
    ],

    'high-ambient-generator-performance-50c-middle-east' => [
        'image' => '/storage/media/2026/10/blog/high-ambient-50c.jpg',
        'content' => '<h2>Overcoming Extreme Desert Heat in Power Generation</h2>
<p>The Middle East summer presents the most demanding operating environment on the planet for internal combustion diesel engines. Ambient air temperatures reaching 52°C, combined with intense solar radiant heating on steel enclosures and fine particulate desert sand, will quickly cause standard commercial generators to trip on high coolant temperature. That is why all units in our <a href="/service/rental-power" class="text-amber-600 font-bold hover:underline">UAE rental fleet</a> are custom engineered for tropical high-ambient service.</p>

<h3>Key Factors in High-Ambient Power Engineering</h3>
<ul>
    <li><strong>Tropical Radiator Sizing:</strong> Standard European or North American generators use radiators designed for 40°C ambient temperatures. In the UAE, radiators must feature enlarged frontal core areas, wider fin spacing to prevent dust clogging, and high-flow copper-brass or reinforced aluminum construction rated for 55°C. See our <a href="/fleet/350-kva" class="text-amber-600 font-bold hover:underline">350 kVA</a> and <a href="/fleet/600-kva" class="text-amber-600 font-bold hover:underline">600 kVA</a> sets equipped with heavy tropical cooling packs.</li>
    <li><strong>Dual-Element Centrifugal Air Filters:</strong> Airborne sand quickly blinds standard paper air filters, starving the engine of air and driving exhaust gas temperatures past safety thresholds. We fit pre-cleaner cyclone vortex units that eject up to 90% of coarse dust before it reaches the secondary micro-filter.</li>
    <li><strong>Synthetic Engine Oil Viscosity:</strong> Extreme sump temperatures break down lower-viscosity motor oils, leading to hydrodynamic bearing failure. Our fleet utilizes high-viscosity synthetic 15W-40 and 20W-50 CJ-4 lubricants with specialized anti-shear additives, checked under our <a href="/service/amc-generator" class="text-amber-600 font-bold hover:underline">AMC maintenance protocol</a>.</li>
</ul>

<h3>Daily Summer Maintenance Checklist</h3>
<p>Contractors operating their own site generators should enforce daily radiator core blown-downs using compressed air, check coolant mixture ratios (50/50 ethylene glycol to prevent cavitation boiling), and verify that acoustic canopy inlet and discharge louvers remain free of obstructions. For full equipment protection, consider our certified <a href="/service/maintenance" class="text-amber-600 font-bold hover:underline">24/7 generator repair & servicing</a>.</p>

<p>Need urgent summer power mobilization in the Northern Emirates? Our depots in <a href="/locations/fujairah" class="text-amber-600 font-bold hover:underline">Fujairah Port</a>, <a href="/locations/ajman" class="text-amber-600 font-bold hover:underline">Ajman</a>, and <a href="/locations/umm-al-quwain" class="text-amber-600 font-bold hover:underline">Umm Al Quwain</a> have emergency crane trucks on standby. <a href="/contact-us" class="text-amber-600 font-bold hover:underline">Speak with a power engineer now</a>.</p>',
    ],

    'ats-automatic-transfer-switch-setup-uae-guide' => [
        'image' => '/storage/media/2026/10/blog/ats-switch-guide.jpg',
        'content' => '<h2>Why Every Critical Facility Needs a Certified ATS Panel</h2>
<p>When the municipal power grid fails, human reaction time is too slow to prevent data loss in server rooms, spoilage in refrigerated cold stores, or ventilation failure in high-rise towers. An <strong>Automatic Transfer Switch (ATS)</strong> continuously monitors primary utility voltage and automatically commands the standby generator to start, synchronizes the bus, and transfers the load within seconds. Explore how Generator Dubai implements ATS synchronization for <a href="/service/power-plant" class="text-amber-600 font-bold hover:underline">multi-megawatt temporary power plants</a>.</p>

<h3>How the ATS Changeover Sequence Works</h3>
<ol>
    <li><strong>Mains Sensing:</strong> Digital relays continuously monitor incoming line-to-line voltages and frequency from the utility (DEWA, SEWA, or ADDC). If any phase drops below 80% or experiences brownout conditions, a startup signal is dispatched.</li>
    <li><strong>Engine Cranking:</strong> The diesel engine starts via 24V lead-acid or AGM battery banks and reaches nominal speed (1500 RPM / 50 Hz) and steady 400V terminal voltage within 4 to 8 seconds. Test this on our <a href="/fleet/150-kva" class="text-amber-600 font-bold hover:underline">150 kVA</a> or <a href="/fleet/300-kva" class="text-amber-600 font-bold hover:underline">300 kVA silent gensets</a>.</li>
    <li><strong>Mechanically Interlocked Transfer:</strong> The utility contactor or motorized MCCB opens, followed by a momentary dead-band delay to eliminate phase-conflict arching, before the generator contactor closes to re-energize the site switchboard.</li>
    <li><strong>Mains Restoration & Cooldown:</strong> When utility power stabilizes for a preset duration (typically 5 to 15 minutes), the ATS transfers the load back seamlessly to the grid, allowing the generator to run an unloaded cooldown cycle before shutting down.</li>
</ol>

<h3>4-Pole Isolation & Neutral Switching</h3>
<p>In accordance with DEWA and UAE Civil Defense electrical regulations, temporary and permanent transfer switches must incorporate 4-pole switching to completely isolate the utility neutral conductor during generator operation, eliminating ground-loop interference and stray earth fault trips. We supply fully compliant ATS enclosures for all <a href="/industries" class="text-amber-600 font-bold hover:underline">commercial and industrial sectors</a>.</p>

<p>Planning site power for modular compounds or executive offices? Read our <a href="/post/portacabin-site-office-power-and-ac-wiring-guide" class="text-amber-600 font-bold hover:underline">Portacabin power distribution guide</a> or <a href="/contact-us" class="text-amber-600 font-bold hover:underline">contact our electrical team</a> for custom ATS panel sizing.</p>',
    ],

    'portacabin-site-office-power-and-ac-wiring-guide' => [
        'image' => '/storage/media/2026/10/blog/portacabin-power-wiring.jpg',
        'content' => '<h2>Powering Remote Construction Compound Cabins in the UAE</h2>
<p>A well-functioning site compound requires reliable electrical power for executive offices, project management meeting rooms, IT server cabins, staff ablution blocks, and security gatehouses. Because these facilities are often established months before permanent grid substations are energized, temporary diesel power is indispensable. Explore our turnkey <a href="/service/portacabin" class="text-amber-600 font-bold hover:underline">portacabin power rental solutions</a>.</p>

<h3>Calculating Portacabin Electrical Demand</h3>
<p>The primary power consumer in any UAE portacabin is air conditioning. Due to summer heat, cabins require tropical-spec high-ambient T3 compressor units:</p>
<ul>
    <li><strong>20ft Executive Office (6m x 2.4m):</strong> Typically fitted with one 2-Ton (24,000 BTU) tropical split AC (~2.8 kW running, ~6.5 kW starting) plus LED lighting and IT workstation power (~1.5 kW). Total required: <strong>15–20 kVA generator capacity</strong>. See our <a href="/fleet/50-kva" class="text-amber-600 font-bold hover:underline">50 kVA silent generator</a> for compact compound setups.</li>
    <li><strong>40ft Combined Office & Conference Cabin (12m x 3m):</strong> Fitted with two 2.5-Ton split ACs (~6.0 kW running), pantry refrigerator, water heater, and multi-user conference displays. Total required: <strong>30–40 kVA generator capacity</strong>.</li>
    <li><strong>Multi-Cabin Site Camp (5 to 10 Modular Units):</strong> Requires a centralized <a href="/fleet/100-kva" class="text-amber-600 font-bold hover:underline">100 kVA</a> to <a href="/fleet/150-kva" class="text-amber-600 font-bold hover:underline">150 kVA silent generator</a> paired with an IP66 outdoor weatherproof distribution board and rubberized Cam-Lock feeder cables.</li>
</ul>

<h3>Turnkey Cabin + Power Combo Packages</h3>
<p>Generator Dubai provides single-source turnkey cabin and power solutions: we deliver the insulated modular portacabin, crane-position it on site, install the matched silent diesel generator, link armored cabling, and establish scheduled ADNOC diesel replenishment. Browse our certified pre-owned units in our <a href="/used-refurbished-generators" class="text-amber-600 font-bold hover:underline">used generators and portacabins inventory</a>.</p>

<p>Need accurate equipment sizing for tower cranes and concrete pumps alongside your offices? Consult our <a href="/post/generator-sizing-guide-dubai-construction-kva" class="text-amber-600 font-bold hover:underline">construction kVA sizing guide</a> or <a href="/contact-us" class="text-amber-600 font-bold hover:underline">get an itemized quote today</a>.</p>',
    ],
];

foreach ($postEnrichments as $slug => $data) {
    $post = Post::where('slug', $slug)->first();
    if (! $post) {
        continue;
    }

    $img = $data['image'];
    $fullImgUrl = 'https://generatordubai.com'.$img;
    $canonicalUrl = route('post.show', $post->slug);

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
                'dateModified' => now()->toIso8601String(),
                'author' => [
                    '@type' => 'Organization',
                    'name' => 'Generator Dubai Engineering Team',
                    'url' => 'https://generatordubai.com',
                ],
                'publisher' => $companyOrg,
                'image' => [
                    '@type' => 'ImageObject',
                    'url' => $fullImgUrl,
                    'caption' => $post->title,
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
        'featured_image' => $img,
        'og_image' => $fullImgUrl,
        'content' => $data['content'],
        'schema_markup' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    ]);
    echo "  [OK] Post #{$post->id} ({$post->slug}): Image -> $img, Schema Image -> $fullImgUrl, In-Content Links Added!\n";
}

// ==========================================
// 4. PAGES ENRICHMENT (CMS & LOCATIONS)
// ==========================================
echo "\n4. Enriching Pages (CMS & Locations)...\n";

$pageImages = [
    'home' => '/storage/media/2026/09/1-y7ja6x.webp',
    'about-us' => '/storage/media/2026/10/04-be9wys.jpg',
    'fleet' => '/storage/media/2026/10/5-5gbsbw.jpg',
    'services' => '/storage/media/2026/10/05-6dnzah.jpg',
    'industries' => '/storage/media/2026/10/b-wchmjz.jpg',
    'used-refurbished-generators' => '/storage/media/2026/10/03-8ab0vq.jpg',
    'locations' => '/storage/media/2026/10/a-s4fzr8.jpg',
    'contact-us' => '/storage/media/2026/10/02-xbimnj.jpg',
    'locations/dubai' => '/storage/media/2026/10/a-s4fzr8.jpg',
    'locations/abu-dhabi' => '/storage/media/2026/10/b-wchmjz.jpg',
    'locations/sharjah' => '/storage/media/2026/10/c-br1a7y.jpg',
    'locations/ajman' => '/storage/media/2026/10/d-exewmv.jpg',
    'locations/ras-al-khaimah' => '/storage/media/2026/10/e-sajmqx.jpg',
    'locations/fujairah' => '/storage/media/2026/10/05-6dnzah.jpg',
    'locations/umm-al-quwain' => '/storage/media/2026/10/01-lptck9.jpg',
    'locations/oman' => '/storage/media/2026/10/3-ki2rou.jpg',
];

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

foreach (Page::all() as $page) {
    $img = $pageImages[$page->slug] ?? '/storage/media/2026/10/a-s4fzr8.jpg';
    $fullImgUrl = 'https://generatordubai.com'.$img;
    $schema = [];

    if ($page->slug === 'home') {
        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                $companyOrg,
                [
                    '@type' => 'WebSite',
                    '@id' => route('home').'#website',
                    'name' => 'Generator Dubai',
                    'url' => route('home'),
                    'image' => $fullImgUrl,
                    'description' => 'Turnkey diesel generator rental, sales & power plant engineering across UAE.',
                    'inLanguage' => 'en-AE',
                ],
            ],
        ];
    } elseif ($page->slug === 'about-us') {
        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'AboutPage',
                    '@id' => route('about').'#about',
                    'name' => 'About Generator Dubai',
                    'description' => $page->seo_description ?: 'UAE certified temporary power supplier and diesel generator fleet engineering.',
                    'url' => route('about'),
                    'image' => $fullImgUrl,
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
    } elseif ($page->slug === 'fleet') {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Diesel Generator Rental Fleet in UAE (50 kVA - 1250 kVA)',
            'url' => route('fleet.index'),
            'image' => $fullImgUrl,
            'description' => 'Browse our modern acoustic soundproof diesel generator rental fleet.',
            'provider' => $companyOrg,
        ];
    } elseif ($page->slug === 'services') {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Turnkey Temporary Power & Generator Services',
            'url' => route('service.index'),
            'image' => $fullImgUrl,
            'description' => 'Comprehensive generator hire, AMC contracts, 24/7 repair, synchronization, and portacabin power in UAE.',
            'provider' => $companyOrg,
        ];
    } elseif ($page->slug === 'industries') {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Industries Powered by Generator Dubai',
            'url' => route('page.industries'),
            'image' => $fullImgUrl,
            'description' => 'Specialized power generation for Construction, Events, Marine, Healthcare, Oil & Gas, and Data Centers in the UAE.',
            'provider' => $companyOrg,
        ];
    } elseif ($page->slug === 'used-refurbished-generators') {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Used & Refurbished Diesel Generators For Sale in UAE',
            'url' => route('page.used-generators'),
            'image' => $fullImgUrl,
            'description' => 'Certified pre-owned diesel generators load-bank tested with warranty coverage in UAE.',
            'provider' => $companyOrg,
        ];
    } elseif ($page->slug === 'locations') {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Generator Dubai Regional Operational Hubs Across UAE & GCC',
            'url' => route('locations.index'),
            'image' => $fullImgUrl,
            'description' => '24/7 localized generator dispatch hubs in Dubai, Abu Dhabi, Sharjah, Ajman, RAK, Fujairah, UAQ, and Oman.',
            'provider' => $companyOrg,
        ];
    } elseif ($page->slug === 'contact-us') {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'ContactPage',
            'name' => 'Contact Generator Dubai 24/7 Emergency Dispatch',
            'url' => route('contact'),
            'image' => $fullImgUrl,
            'description' => 'Direct contact line and technical engineering consultations for temporary power projects across UAE.',
            'mainEntity' => $companyOrg,
        ];
    } elseif (str_starts_with($page->slug, 'locations/')) {
        $city = str_replace('locations/', '', $page->slug);
        $meta = $cityCoords[$city] ?? ['name' => ucfirst($city), 'lat' => 25.2, 'lon' => 55.3, 'street' => 'Regional Hub'];

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => 'Generator Dubai - '.$meta['name'].' Hub',
            'image' => $fullImgUrl,
            'telephone' => '+971569213754',
            'email' => 'hello@generatordubai.com',
            'url' => route('locations.show', $city),
            'priceRange' => '$$$',
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
            'areaServed' => $meta['name'],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    'opens' => '00:00',
                    'closes' => '23:59',
                ],
            ],
            'parentOrganization' => $companyOrg,
        ];
    }

    $page->update([
        'featured_image' => $img,
        'og_image' => $fullImgUrl,
        'schema_markup' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    ]);
    echo "  [OK] Page #{$page->id} ({$page->slug}): Image -> $img, Schema Image -> $fullImgUrl\n";
}

// ==========================================
// 5. CATEGORIES ENRICHMENT
// ==========================================
echo "\n5. Enriching Categories Schemas with Images...\n";

$catImageMap = [
    'abu-dhabi' => 'https://generatordubai.com/storage/media/2026/10/b-wchmjz.jpg',
    'dubai' => 'https://generatordubai.com/storage/media/2026/10/a-s4fzr8.jpg',
    'sharjah' => 'https://generatordubai.com/storage/media/2026/10/c-br1a7y.jpg',
    'ajman' => 'https://generatordubai.com/storage/media/2026/10/d-exewmv.jpg',
    'ras-al-khaimah' => 'https://generatordubai.com/storage/media/2026/10/e-sajmqx.jpg',
    'fujairah' => 'https://generatordubai.com/storage/media/2026/10/05-6dnzah.jpg',
    'umm-al-quwain' => 'https://generatordubai.com/storage/media/2026/10/01-lptck9.jpg',
    'oman' => 'https://generatordubai.com/storage/media/2026/10/3-ki2rou.jpg',
    'rental-power' => 'https://generatordubai.com/storage/media/2026/10/05-6dnzah.jpg',
    'power-plant' => 'https://generatordubai.com/storage/media/2026/10/5-5gbsbw.jpg',
    'amc-generator' => 'https://generatordubai.com/storage/media/2026/10/02-xbimnj.jpg',
    'maintenance' => 'https://generatordubai.com/storage/media/2026/10/01-lptck9.jpg',
    'portacabin' => 'https://generatordubai.com/storage/media/2026/10/06-wx9o27.jpg',
    'we-offer' => 'https://generatordubai.com/storage/media/2026/10/04-be9wys.jpg',
    'new-generators' => 'https://generatordubai.com/storage/media/2026/10/2-im4l8z.jpg',
    'used-refurbished-generators' => 'https://generatordubai.com/storage/media/2026/10/03-8ab0vq.jpg',
    'services' => 'https://generatordubai.com/storage/media/2026/10/05-6dnzah.jpg',
];

foreach (Category::all() as $cat) {
    $img = $catImageMap[$cat->slug] ?? 'https://generatordubai.com/storage/media/2026/10/05-6dnzah.jpg';
    $catUrl = route('category.show', $cat->slug);

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => $cat->name.' - Generator Dubai Power Category',
        'url' => $catUrl,
        'image' => $img,
        'description' => $cat->description ?: ('Articles and power resources in '.$cat->name),
        'provider' => $companyOrg,
    ];

    $cat->update([
        'schema_markup' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    ]);
    echo "  [OK] Category #{$cat->id} ({$cat->slug}): Schema Image -> $img\n";
}

echo "\n========================================================\n";
echo "MASTER ENRICHMENT COMPLETED SUCCESSFULLY!\n";
echo "========================================================\n";
