<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Str;

echo "===============================================================\n";
echo "UPDATING CLUSTER 7 POSTS TO MATCH USER PORTACABIN TRADING FOCUS\n";
echo "===============================================================\n";

$portacabinImages = [
    '/storage/media/2026/10/blog/portacabin-power-wiring.jpg',
    '/storage/media/2026/10/06-wx9o27.jpg',
    '/storage/media/2026/10/03-8ab0vq.jpg',
    '/storage/media/2026/10/04-be9wys.jpg',
    '/storage/media/2026/10/01-lptck9.jpg',
    '/storage/media/2026/10/d-exewmv.jpg',
    '/storage/media/2026/10/e-sajmqx.jpg',
];

$c7Updates = [
    876 => [
        'title' => 'Used Portacabin Buy in Dubai: Structural Sub-Floor, Chassis & Cash Valuation Guide',
        'keyword' => 'used portacabin buy in dubai',
        'intro_q' => 'How does Generator Dubai value and buy used portacabins in Dubai?',
        'aeo_answer' => 'Generator Dubai buys used portacabins in Dubai with instant cash payment based on structural steel chassis integrity, floor condition, PU sandwich panel density, and electrical panel compliance. Free mobile crane dismantling and flatbed transport are provided within 24 to 48 hours.',
        'sec1_title' => 'Instant Cash Valuation Criteria for Surplus Construction Site Cabins',
        'sec1_body' => 'Contractors completing building projects in Dubai often face tight handover deadlines where remaining site offices incur hefty municipality storage fines. We inspect 20ft and 40ft executive offices, security guard shacks, and multi-stall ablution cabins, providing competitive upfront valuations and handling all crane lifting logistics.',
        'sec2_title' => 'Assessing Structural Chassis, Base Joists & Plywood Floor Durability',
        'sec2_body' => 'When buying pre-owned site portacabins across Dubai, our inspectors examine the main longitudinal I-beams, cross-members, and marine plywood subfloors. Cabins showing no structural sag or termite damage command premium cash buyback prices, allowing contractors to recover significant capital.',
        'sec3_title' => 'Fast Crane Mobilization Across Downtown, Dubai South & JAFZA',
        'sec3_body' => 'We coordinate all necessary gate passes, DDA permits, and RTA flatbed transport. Our rigging crews safely disconnect external electrical feeds and position boom cranes to clear entire compounds without disrupting ongoing civil handovers.',
    ],
    886 => [
        'title' => 'Used Portacabin Sell in UAE: Certified Second-Hand Site Cabins with Warranty',
        'keyword' => 'used portacabin sell in uae',
        'intro_q' => 'Where can contractors buy certified used portacabins in the UAE with warranty?',
        'aeo_answer' => 'Generator Dubai sells certified used portacabins across the UAE from our Dubai and Sharjah depots. Every unit features reinforced steel chassis, tested 400V/230V IP65 distribution boards, weatherproof PU insulation, and certified heavy-duty flooring ready for immediate site mobilization.',
        'sec1_title' => '40-Point Pre-Sale Inspection for Second-Hand Site Units in the UAE',
        'sec1_body' => 'Purchasing second-hand portacabins from untrusted sources often leads to hidden water leaks, damaged wiring, or failing air conditioners. Our refurbishment depot conducts a complete 40-point diagnostic check covering roof seal integrity, window tracks, door locks, and electrical insulation resistance before listing units for sale.',
        'sec2_title' => 'Cost Savings: Buying Used vs New Modular Office Units in the UAE',
        'sec2_body' => 'Quality refurbished used portacabins deliver up to 50% cost savings compared to brand-new units while offering identical operational lifespan in harsh 50°C UAE desert conditions. All units feature fire-rated rockwool or polyurethane insulation compliant with local municipality building standards.',
        'sec3_title' => 'Immediate Delivery to Abu Dhabi, Sharjah & Northern Emirates',
        'sec3_body' => 'With dozens of 20ft and 40ft units stocked in our logistics yards, contractors can inspect units today and receive delivery on site tomorrow. We provide turn-key placement with leveling concrete footings and generator cable hookup.',
    ],
    894 => [
        'title' => 'Refurbished Portacabin in UAE: Thermal Insulation & Roof Waterproofing Standards',
        'keyword' => 'refurbished portacabin in uae',
        'intro_q' => 'What engineering standards define a properly refurbished portacabin in the UAE?',
        'aeo_answer' => 'A properly refurbished portacabin in the UAE features non-combustible sandwich panels, seamless elastomeric acrylic or bitumen roof waterproofing, high-ambient T3 split air conditioning, and IP65 weatherproof electrical boards engineered for continuous 50°C desert exposure.',
        'sec1_title' => 'Extending Modular Cabin Service Life in Extreme Middle East Climates',
        'sec1_body' => 'Unprotected modular cabins degrade rapidly under intense GCC solar radiation. Our refurbishment facility strips aged roof coatings, replacing damaged panels with 50mm to 100mm high-density polyurethane (PU) or rockwool sandwich sheets rated for Class 1 flame spread under UAE Civil Defense regulations.',
        'sec2_title' => 'Dual-Layer Corrugated Roof Weatherproofing & Thermal Reflective Coating',
        'sec2_body' => 'Water leaks during rare UAE flash floods can destroy interior drywall and electrical workstations. We seal roofs with reinforced fiberglass mesh and multi-layer elastomeric reflective coatings that reflect up to 85% of solar heat gain, reducing internal cooling energy burn by over 30%.',
        'sec3_title' => 'Electrical Overhaul & High-Ambient T3 Split AC Installation',
        'sec3_body' => 'Old wiring is completely replaced with fire-retardant LSF copper conductors within rigid PVC conduits. We install heavy-duty T3 tropical compressors capable of maintaining comfortable 22°C indoor temperatures even when outdoor ambient surpasses 50°C.',
    ],
    897 => [
        'title' => 'Used Portacabin Buy in UAE: Inspection Checklist for Windows, Doors & Enclosures',
        'keyword' => 'used portacabin buy in uae',
        'intro_q' => 'What should buyers and sellers check when trading used portacabins in the UAE?',
        'aeo_answer' => 'When trading used portacabins in the UAE, inspect aluminum double-glazed window seals, steel door hinges, corner lifting lugs, chassis rust levels, and electrical continuity. Generator Dubai offers instant cash purchase for compliant surplus units with free crane removal.',
        'sec1_title' => 'Comprehensive Exterior & Interior Diagnostic Checklist',
        'sec1_body' => 'Whether you are selling surplus site offices after project handover or purchasing pre-owned cabins for a new contractor compound, evaluating structural integrity prevents costly site replacements. Our inspection engineers evaluate corner lifting brackets for certified crane rigging safety.',
        'sec2_title' => 'Window Double-Glazing & Dust Seal Integrity in Desert Zones',
        'sec2_body' => 'Fine desert dust infiltration damages computer equipment in construction offices. We evaluate heavy-gauge powder-coated aluminum sliding windows with double-pane glass and EPDM rubber weatherstripping, ensuring airtight comfort on active civil construction sites.',
        'sec3_title' => 'Instant Buyback & Transparent Valuation for UAE Contractors',
        'sec3_body' => 'Generator Dubai offers transparent cash buyback agreements. We evaluate site compounds containing 1 to 50+ cabins and provide binding offers within 24 hours, taking care of all municipal disposal formalities and site restoration.',
    ],
    906 => [
        'title' => 'Refurbished Portacabin Buy in UAE, Dubai: Modern VIP Office & Showroom Facades',
        'keyword' => 'refurbished portacabin buy in uae dubai',
        'intro_q' => 'How can refurbished portacabins in Dubai be customized for executive offices and client showrooms?',
        'aeo_answer' => 'Refurbished portacabins in Dubai can be upgraded with modern Aluminum Composite Panel (ACP) cladding, full-height double-glazed glass facades, wood-plastic composite (WPC) accents, and luxury acoustic interior finishes, delivering executive-grade presence at 50% lower cost than new structures.',
        'sec1_title' => 'Transforming Industrial Cabins into Executive Client Presentation Suites',
        'sec1_body' => 'Real estate developers and premier engineering contractors frequently require high-end client presentation suites directly on development sites. Our architectural refurbishment team transforms standard steel shipping frames into striking, contemporary modular pavilions featuring sleek glass curtain walls.',
        'sec2_title' => 'Fire-Rated Non-Combustible Exterior Cladding Options',
        'sec2_body' => 'All architectural cladding installations comply strictly with the UAE Fire and Life Safety Code (FLSC 2018). We utilize non-combustible mineral core ACP panels and UV-stabilized WPC composite slats that withstand coastal salt fog and extreme desert ultraviolet radiation without warping.',
        'sec3_title' => 'Custom Interior Layouts: Conference Rooms, Executive Desks & Restrooms',
        'sec3_body' => 'Interiors feature sound-insulated gypsum partitions, modern recessed LED troffer lighting, concealed CAT6 data network cabling, and designer sanitary ablution fixtures, creating an inspiring corporate workspace on any remote project site.',
    ],
    917 => [
        'title' => 'Scrap Portacabin Buy in UAE: Instant Cash Valuation, Site Dismantling & Metal Recycling',
        'keyword' => 'scrap portacabin buy in uae',
        'intro_q' => 'Who buys scrap, damaged, or non-repairable portacabins in the UAE for cash?',
        'aeo_answer' => 'Generator Dubai is a leading scrap portacabin buyer in the UAE, providing instant cash payment based on verified steel tonnage, copper wiring, and aluminum scrap value. We provide licensed on-site dismantling, heavy crane transport, and total site clearance.',
        'sec1_title' => 'Monetizing Damaged, Fire-Damaged or Condemned Site Cabins',
        'sec1_body' => 'When modular cabins reach the end of their operational lifespan due to severe chassis corrosion, fire damage, or structural collapse, storing them on active sites creates safety hazards and risks municipality fines. We purchase scrap portacabins in any condition across all seven Emirates.',
        'sec2_title' => 'Safe On-Site Demolition & Metal Recovery Procedures',
        'sec2_body' => 'Our dismantling crews are certified in safe oxy-acetylene torch cutting, hydraulic shearing, and heavy equipment rigging. We strip and segregate scrap steel beams, corrugated roof iron, aluminum window profiles, and copper wiring, ensuring maximum recycling recovery and immediate cash payouts.',
        'sec3_title' => 'Free Site Clearance & Municipal Handover Sign-Off',
        'sec3_body' => 'We provide complete turnkey compound removal. Once dismantling is finished, our sweepers clear all debris, concrete blocks, and scrap materials, leaving the terrain cleanly leveled and ready for municipality final inspection and security deposit return.',
    ],
    920 => [
        'title' => 'Used Portacabins Sell in UAE: Chassis Anti-Corrosion Treatment & Storage Preparation',
        'keyword' => 'used portacabins sell in uae',
        'intro_q' => 'How does Generator Dubai ensure the longevity of used portacabins sold in coastal UAE?',
        'aeo_answer' => 'Generator Dubai treats used portacabins sold in the UAE with high-build zinc-rich epoxy primers and polyurethane topcoats on steel chassis frames, preventing marine corrosion in JAFZA, Hamriyah, and Abu Dhabi coastal industrial zones.',
        'sec1_title' => 'Combating Coastal Corrosion on Second-Hand Modular Site Units',
        'sec1_body' => 'The combination of high ambient humidity and airborne sea salt along the Arabian Gulf accelerates steel rust and chassis degradation. Prior to sale, every pre-owned cabin undergoes grit-blasting or mechanical wire-brushing to remove surface oxidation before receiving heavy-duty marine protective coatings.',
        'sec2_title' => 'Anti-Fungal & Anti-Mold Wall Treatment for Extreme Desert Humidity',
        'sec2_body' => 'During coastal UAE summers, indoor condensation behind unsealed wall joints can harbor harmful mildew. We treat interior cavities with anti-microbial sealants and install continuous exhaust ventilation to guarantee pristine air quality for site personnel.',
        'sec3_title' => 'Ready for Inspection at Our Dubai & Sharjah Equipment Depots',
        'sec3_body' => 'Contractors can inspect our wide selection of certified second-hand portacabins 6 days a week. We offer flexible terms, optional refurbished air conditioning packages, and guaranteed buyback clauses for temporary project requirements.',
    ],
];

foreach ($c7Updates as $pid => $c7) {
    $p = Post::find($pid);
    if (! $p) {
        continue;
    }

    $imgIndex = ($pid - 876) % count($portacabinImages);
    $img = $portacabinImages[$imgIndex];
    $uniqueSlug = Post::createUniqueSlug($c7['title'], $pid);

    $faqs = [
        [
            'q' => 'What is the process to sell a used or scrap portacabin to Generator Dubai?',
            'a' => 'Send us photos, cabin dimensions, and site location via WhatsApp (+971 56 921 3754). We provide an initial valuation within 2 hours, conduct a free site inspection, pay instant cash upon agreement, and dispatch cranes for removal within 24 to 48 hours.',
        ],
        [
            'q' => 'Do you offer portacabin rental services?',
            'a' => 'No. Generator Dubai specializes exclusively in Buying Used Portacabins, Buying Scrap Portacabins, Selling Used Units, and Providing Refurbished Cabins. For temporary needs, our Guaranteed Buyback Program allows contractors to buy refurbished cabins and sell them back upon project completion, saving up to 40% compared to rental.',
        ],
        [
            'q' => 'What areas in the UAE do you cover for portacabin buy, sell, and scrap removal?',
            'a' => 'We cover all 7 Emirates: Dubai, Abu Dhabi (including Mussafah, ICAD, and Western Region), Sharjah, Ajman, Ras Al Khaimah, Fujairah, and Umm Al Quwain, with full crane rigging and heavy flatbed logistics.',
        ],
    ];

    $html = <<<HTML
<div class="space-y-8 text-slate-700 leading-relaxed">
    <div class="p-6 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-slate-900">
        <h3 class="text-xl font-bold font-display text-slate-950 mb-2">{$c7['intro_q']}</h3>
        <p class="text-sm text-slate-800 leading-relaxed font-medium">
            {$c7['aeo_answer']}
        </p>
    </div>

    <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight font-display mb-3">{$c7['sec1_title']}</h2>
        <p class="text-base text-slate-600 leading-relaxed mb-4">
            {$c7['sec1_body']}
        </p>
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-sm space-y-2 my-4">
            <div class="flex justify-between font-semibold text-slate-900">
                <span>Direct Cash Payment:</span>
                <span class="text-emerald-700">Immediate Bank Transfer or Cash</span>
            </div>
            <div class="flex justify-between font-semibold text-slate-900">
                <span>Free Crane Rigging:</span>
                <span class="text-emerald-700">Certified Riggers & Heavy Boom Cranes</span>
            </div>
            <div class="flex justify-between font-semibold text-slate-900">
                <span>Site Clearance SLA:</span>
                <span class="text-emerald-700">24 - 48 Hours Across Dubai & UAE</span>
            </div>
        </div>
    </div>

    <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight font-display mb-3">{$c7['sec2_title']}</h2>
        <p class="text-base text-slate-600 leading-relaxed mb-4">
            {$c7['sec2_body']}
        </p>
    </div>

    <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight font-display mb-3">{$c7['sec3_title']}</h2>
        <p class="text-base text-slate-600 leading-relaxed mb-4">
            {$c7['sec3_body']}
        </p>
    </div>

    <div class="pt-6 border-t border-slate-200">
        <h3 class="text-xl font-black text-slate-900 font-display mb-4">Frequently Asked Questions</h3>
        <div class="space-y-4">
            <div class="border border-slate-200 rounded-xl p-5 bg-white">
                <h4 class="text-base font-bold text-slate-900">{$faqs[0]['q']}</h4>
                <p class="mt-2 text-sm text-slate-600 leading-relaxed">{$faqs[0]['a']}</p>
            </div>
            <div class="border border-slate-200 rounded-xl p-5 bg-white">
                <h4 class="text-base font-bold text-slate-900">{$faqs[1]['q']}</h4>
                <p class="mt-2 text-sm text-slate-600 leading-relaxed">{$faqs[1]['a']}</p>
            </div>
            <div class="border border-slate-200 rounded-xl p-5 bg-white">
                <h4 class="text-base font-bold text-slate-900">{$faqs[2]['q']}</h4>
                <p class="mt-2 text-sm text-slate-600 leading-relaxed">{$faqs[2]['a']}</p>
            </div>
        </div>
    </div>

    <div class="p-8 rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-slate-900 text-white mt-8 border border-slate-800 shadow-xl">
        <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-400 border border-amber-500/30 mb-4">
                <span>INSTANT PORTACABIN TRADING DESK &bull; ALL 7 EMIRATES</span>
            </div>
            <h3 class="text-2xl sm:text-3xl font-black font-display tracking-tight text-white mb-3">
                Have Used Portacabins to Sell or Need Refurbished Units?
            </h3>
            <p class="text-sm text-slate-300 leading-relaxed mb-6 font-light">
                Get an instant cash valuation on your surplus or scrap cabins, or inspect our certified refurbished inventory ready for delivery today.
            </p>
            <div class="flex flex-wrap gap-4 items-center">
                <a href="https://wa.me/971569213754?text=Hello+Generator+Dubai,+I+want+to+buy/sell/scrap+portacabins" target="_blank" class="px-6 py-3 rounded-xl font-bold text-xs bg-amber-500 hover:bg-amber-400 text-slate-950 transition flex items-center gap-2">
                    <span>Chat on WhatsApp: +971 56 921 3754</span>
                </a>
                <a href="tel:+971569213754" class="px-6 py-3 rounded-xl font-bold text-xs bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition">
                    Call 24/7 Hotline: +971 56 921 3754
                </a>
            </div>
        </div>
    </div>
</div>
HTML;

    $p->update([
        'title' => $c7['title'],
        'slug' => $uniqueSlug,
        'excerpt' => $c7['aeo_answer'],
        'content' => $html,
        'featured_image' => $img,
        'meta_title' => $c7['title'].' | Generator Dubai',
        'meta_description' => Str::limit($c7['aeo_answer'], 155),
        'focus_keyword' => $c7['keyword'],
        'status' => 'published',
        'is_indexable' => true,
    ]);

    echo "Updated Cluster 7 Post #{$pid}: {$c7['title']}\n";
}

echo "\nSuccessfully aligned all target Cluster 7 posts with Portacabin trading focus!\n";
