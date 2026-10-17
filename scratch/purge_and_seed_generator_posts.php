<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

echo "1. Purging 563 old data-recovery posts and pivot records...\n";
DB::table('post_tag')->truncate();
DB::table('category_post')->truncate();
Post::query()->forceDelete();

echo "2. Purging old data-recovery tags...\n";
Tag::query()->forceDelete();

$admin = User::first();
$userId = $admin ? $admin->id : 1;

echo "3. Creating authentic Generator Dubai tags...\n";
$tagNames = [
    'Generator Rental',
    'Diesel Generators',
    'Temporary Power Plants',
    'AMC & Maintenance',
    'Portacabin Offices',
    'Automatic Transfer Switches',
    'Fuel Logistics',
    'Construction Power',
];

$tags = [];
foreach ($tagNames as $name) {
    $tags[$name] = Tag::create([
        'name' => $name,
        'slug' => Str::slug($name),
    ]);
}

echo "4. Seeding 6 authentic Generator Dubai technical power articles...\n";

$articles = [
    [
        'title' => 'Generator Sizing Guide: How to Calculate kVA Requirements for UAE Construction Sites',
        'slug' => 'generator-sizing-guide-dubai-construction-kva',
        'category_slug' => 'rental-power',
        'tags' => ['Generator Rental', 'Diesel Generators', 'Construction Power'],
        'excerpt' => 'A comprehensive engineering guide on calculating starting and running kVA requirements for tower cranes, concrete batching plants, dewatering pumps, and site offices in the UAE.',
        'featured_image' => 'https://images.unsplash.com/photo-1541888946425-d0fbb186156a?auto=format&fit=crop&w=1000&q=80',
        'focus_keyword' => 'generator sizing guide uae',
        'meta_title' => 'Generator Sizing Guide for UAE Construction Sites | kVA Calculations',
        'meta_description' => 'Learn how to size rental diesel generators for UAE construction sites. Calculate inductive motor inrush, power factor (0.8 PF), and N+1 reserve redundancy.',
        'content' => '<h2>Understanding Electrical Load Dynamics on UAE Construction Sites</h2>
<p>Selecting the correct generator capacity is one of the most critical engineering decisions on any construction or infrastructure project in the United Arab Emirates. An undersized generator will trip under peak motor-starting currents, causing crane stoppages and concrete pour delays. Conversely, a significantly oversized unit operating below 30% capacity will suffer from wet stacking, incomplete fuel combustion, and unnecessary diesel expenditure.</p>

<h3>Step 1: Distinguish Between Continuous (Running) kW and Peak (Starting) kVA</h3>
<p>Most electrical equipment on site has two distinct power ratings:</p>
<ul>
    <li><strong>Running Load (kW):</strong> The continuous real power drawn during normal steady-state operation.</li>
    <li><strong>Starting Load (kVA):</strong> The transient surge drawn when electric motors initialize across-the-line (Direct-On-Line or DOL), which can be 300% to 600% higher than running amperage.</li>
</ul>

<h3>Step 2: Accounting for the UAE Power Factor (0.8 PF)</h3>
<p>In standard 3-phase commercial and industrial diesel generators operating at 400V / 50Hz, the power factor is standardly rated at <strong>0.8</strong>. The relationship between apparent power (kVA) and real active power (kW) is:</p>
<blockquote>$$\text{kVA} = \frac{\text{kW}}{\text{Power Factor}} = \frac{\text{kW}}{0.8}$$</blockquote>
<p>For example, if your total site continuous requirement is 160 kW, the minimum prime generator rating required is: $160 \div 0.8 = 200\text{ kVA}$.</p>

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
            <td class="p-3">Requires oversized alternator or heavy 500 kVA+ set</td>
        </tr>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold">Star-Delta Starter</td>
            <td class="p-3">3.0x</td>
            <td class="p-3">Standard generator sizing with 25% safety headroom</td>
        </tr>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold">Variable Frequency Drive (VFD)</td>
            <td class="p-3">1.2x – 1.5x</td>
            <td class="p-3">Optimal efficiency, matches generator rating closely</td>
        </tr>
    </tbody>
</table>

<h3>Step 4: High Ambient Temperature Deration in Summer (50°C+)</h3>
<p>During UAE peak summer months (June to September), ambient temperatures frequently exceed 45°C to 50°C. Standard ISO 8528 conditions assume 25°C ambient temperature. In desert conditions, air density decreases, reducing engine oxygen intake and radiator heat exchange efficiency. Generator Dubai specifies heavy-duty 55°C tropical radiators on all rental sets, ensuring zero deration up to 50°C ambient.</p>

<h3>Need an On-Site Electrical Load Profile?</h3>
<p>Generator Dubai provides complimentary on-site load audits and single-line diagram reviews across Dubai, Abu Dhabi, and Sharjah. Call our engineering hotline at <strong>+971 56 921 3754</strong> or submit your site equipment list for a verified technical proposal within 15 minutes.</p>',
    ],
    [
        'title' => 'Prime vs Standby Power: ISO 8528 Engineering Standards for GCC Projects',
        'slug' => 'prime-vs-standby-generator-power-uae-iso8528',
        'category_slug' => 'power-plant',
        'tags' => ['Diesel Generators', 'Temporary Power Plants', 'Generator Rental'],
        'excerpt' => 'Clear breakdown of ISO 8528 ratings: Prime Power (PRP), Continuous Power (COP), and Emergency Standby Power (ESP) for commercial and utility applications in the UAE.',
        'featured_image' => 'https://images.unsplash.com/photo-1518684079-3c830dcef090?auto=format&fit=crop&w=1000&q=80',
        'focus_keyword' => 'prime vs standby power uae',
        'meta_title' => 'Prime vs Standby Generator Power UAE | ISO 8528 Standards',
        'meta_description' => 'Understand ISO 8528 Prime Power (PRP), Continuous (COP), and Standby (ESP) ratings before renting or purchasing diesel generators in Dubai & UAE.',
        'content' => '<h2>The Critical Difference Between Standby, Prime, and Continuous Generator Ratings</h2>
<p>One of the most frequent specification errors encountered in the UAE plant rental market is deploying an Emergency Standby Power (ESP) rated generator in a continuous or prime role. This misunderstanding leads to engine overheating, premature component wear, and unexpected power outages on mission-critical job sites.</p>

<h3>ISO 8528-1 International Power Classifications</h3>
<ul>
    <li><strong>Emergency Standby Power (ESP):</strong> Maximum power available under variable electrical load conditions for the duration of a municipal grid outage. ESP ratings permit a maximum 200 hours of operation per year with an average load factor not exceeding 70%. ESP sets carry zero overload capability.</li>
    <li><strong>Prime Running Power (PRP):</strong> Unlimited hours of operation per year under variable electrical loads. PRP ratings permit an average 24-hour load factor of 70%, with a 10% overload capacity available for 1 hour every 12 hours. This is the industry standard for UAE construction sites and remote camps.</li>
    <li><strong>Continuous Operating Power (COP):</strong> Unlimited annual operating hours at a constant 100% electrical load. Used for base-load utility substations, island grids, and continuous manufacturing plants.</li>
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
            <td class="p-3">Construction / Plant rental</td>
            <td class="p-3">Multi-MW utility grid feed</td>
        </tr>
    </tbody>
</table>

<h3>Why Generator Dubai Rates Every Fleet Unit at Prime Capacity</h3>
<p>Every generator deployed by Generator Dubai is rated and tested at its true <strong>Prime Power (PRP)</strong> capacity. When you rent a 500 kVA unit from our fleet, you receive 400 kW of continuous prime capability engineered with Stamford alternators and Cummins or Perkins heavy-duty diesel engines.</p>',
    ],
    [
        'title' => 'Diesel Generator Fuel Consumption: Rates, Calculations & Bulk Storage in UAE',
        'slug' => 'diesel-generator-fuel-consumption-optimization-uae',
        'category_slug' => 'maintenance',
        'tags' => ['Diesel Generators', 'Fuel Logistics', 'AMC & Maintenance'],
        'excerpt' => 'A practical guide to diesel consumption curves across 50 to 1250 kVA generators, calculating hourly liters at 50%, 75%, and 100% load, and ADNOC bulk fuel management.',
        'featured_image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1000&q=80',
        'focus_keyword' => 'diesel generator fuel consumption uae',
        'meta_title' => 'Generator Fuel Consumption UAE | Liters Per Hour Sizing Chart',
        'meta_description' => 'Complete fuel consumption reference chart (50 kVA to 1250 kVA) in liters per hour. Calculate diesel expenses and bulk fuel tank requirements in Dubai & UAE.',
        'content' => '<h2>Calculating Fuel Consumption for UAE Generator Operations</h2>
<p>Fuel represents up to 70% of the total operating expenditure of a temporary power installation over a multi-month project. Accurately estimating fuel burn rates is essential for budgeting diesel deliveries, sizing external double-walled bulk tanks, and optimizing operational schedules.</p>

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
            <td class="p-3 font-semibold">50 kVA</td>
            <td class="p-3">40 kW</td>
            <td class="p-3">6.5 L/hr</td>
            <td class="p-3">9.1 L/hr</td>
            <td class="p-3">12.5 L/hr</td>
        </tr>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold">100 kVA</td>
            <td class="p-3">80 kW</td>
            <td class="p-3">11.8 L/hr</td>
            <td class="p-3">16.5 L/hr</td>
            <td class="p-3">22.0 L/hr</td>
        </tr>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold">250 kVA</td>
            <td class="p-3">200 kW</td>
            <td class="p-3">28.0 L/hr</td>
            <td class="p-3">38.2 L/hr</td>
            <td class="p-3">52.0 L/hr</td>
        </tr>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold">500 kVA</td>
            <td class="p-3">400 kW</td>
            <td class="p-3">54.0 L/hr</td>
            <td class="p-3">74.0 L/hr</td>
            <td class="p-3">99.0 L/hr</td>
        </tr>
        <tr class="border-b border-slate-200">
            <td class="p-3 font-semibold">1000 kVA</td>
            <td class="p-3">800 kW</td>
            <td class="p-3">105.0 L/hr</td>
            <td class="p-3">145.0 L/hr</td>
            <td class="p-3">198.0 L/hr</td>
        </tr>
    </tbody>
</table>

<h3>External Bunded Fuel Tanks & Automatic Refilling</h3>
<p>While standard silent canopy units include an internal base fuel tank supporting 8 to 14 hours of continuous operation, remote projects or 24/7 industrial facilities require external double-walled bunded fuel storage (1,000 to 20,000 Liters). Generator Dubai provides turnkey fuel management with digital telemetry and scheduled ADNOC diesel replenishment.</p>',
    ],
    [
        'title' => 'Operating Diesel Generators in 50°C+ Ambient UAE Summer Temperatures',
        'slug' => 'high-ambient-generator-performance-50c-middle-east',
        'category_slug' => 'amc-generator',
        'tags' => ['Diesel Generators', 'AMC & Maintenance', 'Construction Power'],
        'excerpt' => 'Engineering best practices for preventing radiator overheating, managing dust ingress in cooling packs, and maintaining continuous prime power during Middle Eastern summers.',
        'featured_image' => 'https://images.unsplash.com/photo-1509391365360-2e959784a276?auto=format&fit=crop&w=1000&q=80',
        'focus_keyword' => 'generator summer maintenance uae',
        'meta_title' => 'High Ambient Generator Performance 50°C UAE | Overheating Prevention',
        'meta_description' => 'How to run diesel generators reliably during UAE summer heat exceeding 50°C. Heavy tropical radiators, oil viscosity, and radiator core cleaning protocols.',
        'content' => '<h2>Overcoming Extreme Desert Heat in Power Generation</h2>
<p>The Middle East summer presents the most demanding operating environment on the planet for internal combustion diesel engines. Ambient air temperatures reaching 52°C, combined with intense solar radiant heating on steel enclosures and fine particulate desert sand, will quickly cause standard commercial generators to trip on high coolant temperature.</p>

<h3>Key Factors in High-Ambient Power Engineering</h3>
<ul>
    <li><strong>Tropical Radiator Sizing:</strong> Standard European or North American generators use radiators designed for 40°C ambient temperatures. In the UAE, radiators must feature enlarged frontal core areas, wider fin spacing to prevent dust clogging, and high-flow copper-brass or reinforced aluminum construction rated for 55°C.</li>
    <li><strong>Dual-Element Centrifugal Air Filters:</strong> Airborne sand quickly blinds standard paper air filters, starving the engine of air and driving exhaust gas temperatures past safety thresholds. We fit pre-cleaner cyclone vortex units that eject up to 90% of coarse dust before it reaches the secondary micro-filter.</li>
    <li><strong>Synthetic Engine Oil Viscosity:</strong> Extreme sump temperatures break down lower-viscosity motor oils, leading to hydrodynamic bearing failure. Our fleet utilizes high-viscosity synthetic 15W-40 and 20W-50 CJ-4 lubricants with specialized anti-shear additives.</li>
</ul>

<h3>Daily Summer Maintenance Checklist</h3>
<p>Contractors operating their own site generators should enforce daily radiator core blown-downs using compressed air, check coolant mixture ratios (50/50 ethylene glycol to prevent cavitation boiling), and verify that acoustic canopy inlet and discharge louvers remain free of obstructions.</p>',
    ],
    [
        'title' => 'Automatic Transfer Switches (ATS): Ensuring Zero-Downtime Facility Power',
        'slug' => 'ats-automatic-transfer-switch-setup-uae-guide',
        'category_slug' => 'we-offer',
        'tags' => ['Automatic Transfer Switches', 'Temporary Power Plants', 'Generator Rental'],
        'excerpt' => 'How Automatic Transfer Switches (ATS) coordinate with emergency standby generators to provide sub-10 second changeover during municipal power disruptions in Dubai and the UAE.',
        'featured_image' => 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&w=1000&q=80',
        'focus_keyword' => 'ats automatic transfer switch uae',
        'meta_title' => 'Automatic Transfer Switches (ATS) UAE | Sub-10s Power Backup',
        'meta_description' => 'Learn how Automatic Transfer Switches (ATS) restore emergency power in under 10 seconds. 4-pole contactors, motorized MCCBs, and DEWA compliance.',
        'content' => '<h2>Why Every Critical Facility Needs a Certified ATS Panel</h2>
<p>When the municipal power grid fails, human reaction time is too slow to prevent data loss in server rooms, spoilage in refrigerated cold stores, or ventilation failure in high-rise towers. An <strong>Automatic Transfer Switch (ATS)</strong> continuously monitors primary utility voltage and automatically commands the standby generator to start, synchronizes the bus, and transfers the load within seconds.</p>

<h3>How the ATS Changeover Sequence Works</h3>
<ol>
    <li><strong>Mains Sensing:</strong> Digital relays continuously monitor incoming line-to-line voltages and frequency from the utility (DEWA, SEWA, or ADDC). If any phase drops below 80% or experiences brownout conditions, a startup signal is dispatched.</li>
    <li><strong>Engine Cranking:</strong> The diesel engine starts via 24V lead-acid or AGM battery banks and reaches nominal speed (1500 RPM / 50 Hz) and steady 400V terminal voltage within 4 to 8 seconds.</li>
    <li><strong>Mechanically Interlocked Transfer:</strong> The utility contactor or motorized MCCB opens, followed by a momentary dead-band delay to eliminate phase-conflict arching, before the generator contactor closes to re-energize the site switchboard.</li>
    <li><strong>Mains Restoration & Cooldown:</strong> When utility power stabilizes for a preset duration (typically 5 to 15 minutes), the ATS transfers the load back seamlessly to the grid, allowing the generator to run an unloaded cooldown cycle before shutting down.</li>
</ol>

<h3>4-Pole Isolation & Neutral Switching</h3>
<p>In accordance with DEWA and UAE Civil Defense electrical regulations, temporary and permanent transfer switches must incorporate 4-pole switching to completely isolate the utility neutral conductor during generator operation, eliminating ground-loop interference and stray earth fault trips.</p>',
    ],
    [
        'title' => 'Portacabin Site Office Power: Generator Sizing, Electrical Distribution & AC Loads',
        'slug' => 'portacabin-site-office-power-and-ac-wiring-guide',
        'category_slug' => 'portacabin',
        'tags' => ['Portacabin Offices', 'Generator Rental', 'Construction Power'],
        'excerpt' => 'Sizing diesel generators and electrical distribution panels for 20ft and 40ft modular site offices, conference cabins, split AC units, and hygienic ablution blocks.',
        'featured_image' => 'https://images.unsplash.com/photo-1541888946425-d0fbb186156a?auto=format&fit=crop&w=1000&q=80',
        'focus_keyword' => 'portacabin power setup uae',
        'meta_title' => 'Portacabin Site Office Power & AC Sizing UAE | Generator Dubai',
        'meta_description' => 'Complete engineering guide to powering modular portacabins and site offices in UAE. AC cooling power loads, rubberized cables, and turnkey generator packages.',
        'content' => '<h2>Powering Remote Construction Compound Cabins in the UAE</h2>
<p>A well-functioning site compound requires reliable electrical power for executive offices, project management meeting rooms, IT server cabins, staff ablution blocks, and security gatehouses. Because these facilities are often established months before permanent grid substations are energized, temporary diesel power is indispensable.</p>

<h3>Calculating Portacabin Electrical Demand</h3>
<p>The primary power consumer in any UAE portacabin is air conditioning. Due to summer heat, cabins require tropical-spec high-ambient T3 compressor units:</p>
<ul>
    <li><strong>20ft Executive Office (6m x 2.4m):</strong> Typically fitted with one 2-Ton (24,000 BTU) tropical split AC (~2.8 kW running, ~6.5 kW starting) plus LED lighting and IT workstation power (~1.5 kW). Total required: <strong>15–20 kVA generator capacity</strong>.</li>
    <li><strong>40ft Combined Office & Conference Cabin (12m x 3m):</strong> Fitted with two 2.5-Ton split ACs (~6.0 kW running), pantry refrigerator, water heater, and multi-user conference displays. Total required: <strong>30–40 kVA generator capacity</strong>.</li>
    <li><strong>Multi-Cabin Site Camp (5 to 10 Modular Units):</strong> Requires a centralized <strong>100 kVA to 150 kVA silent generator</strong> paired with an IP66 outdoor weatherproof distribution board and rubberized Cam-Lock feeder cables.</li>
</ul>

<h3>Turnkey Cabin + Power Combo Packages</h3>
<p>Generator Dubai provides single-source turnkey cabin and power solutions: we deliver the insulated modular portacabin, crane-position it on site, install the matched silent diesel generator, link armored cabling, and establish scheduled ADNOC diesel replenishment.</p>',
    ],
];

foreach ($articles as $art) {
    $cat = Category::where('slug', $art['category_slug'])->first();
    $catId = $cat ? $cat->id : null;

    $post = Post::create([
        'user_id' => $userId,
        'title' => $art['title'],
        'slug' => $art['slug'],
        'excerpt' => $art['excerpt'],
        'content' => $art['content'],
        'featured_image' => $art['featured_image'],
        'status' => 'published',
        'published_at' => now()->subDays(rand(1, 30)),
        'focus_keyword' => $art['focus_keyword'],
        'meta_title' => $art['meta_title'],
        'meta_description' => $art['meta_description'],
        'canonical_url' => url('/post/'.$art['slug']),
        'og_title' => $art['meta_title'],
        'og_description' => $art['meta_description'],
        'og_image' => $art['featured_image'],
        'is_indexable' => true,
        'seo_score' => 95,
        'readability_score' => 90,
    ]);

    if ($catId) {
        $post->categories()->attach($catId);
    }

    $postTagIds = [];
    foreach ($art['tags'] as $tagName) {
        if (isset($tags[$tagName])) {
            $postTagIds[] = $tags[$tagName]->id;
        }
    }
    if (! empty($postTagIds)) {
        $post->tags()->attach($postTagIds);
    }

    echo "   + Created Post: {$post->title} ({$post->slug})\n";
}

echo "\nFinished! Current Posts count: ".Post::count().', Tags count: '.Tag::count()."\n";
