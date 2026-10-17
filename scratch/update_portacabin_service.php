<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

echo "=== 1. UPDATING SERVICE ID 20 (PORTACABIN) ===\n";

$service = Service::where('slug', 'portacabin')->first();
if ($service) {
    $serviceContent = <<<'HTML'
<div class="space-y-8">
    <div class="p-6 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-slate-900">
        <h3 class="text-xl font-bold text-amber-900 flex items-center gap-2">
            <span>Specialized Used & Scrap Portacabin Solutions in UAE</span>
        </h3>
        <p class="mt-2 text-sm text-slate-700 leading-relaxed">
            Generator Dubai is a premier industrial equipment specialist across the United Arab Emirates. In our modular site division, <strong>we specialize exclusively in buying used portacabins, purchasing scrap portacabins for instant cash, selling certified pre-owned units, and providing premium refurbished site offices</strong>. Please note: <em>We do not offer portacabin rental services</em>. For temporary site requirements, our <strong>Guaranteed Buyback Program</strong> allows contractors to purchase refurbished cabins and sell them back upon project completion at a locked-in valuation, saving thousands compared to rental fees.
        </p>
    </div>

    <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight font-display">1. Used Portacabin Buy in Dubai & Across UAE</h2>
        <p class="mt-3 text-slate-600 leading-relaxed">
            Have surplus project cabins after completing a construction contract? We provide immediate on-site inspections and <strong>instant cash valuation for used portacabins</strong> across Dubai, Abu Dhabi, Sharjah, Ajman, and Northern Emirates. Our heavy logistics team coordinates full crane rigging, flatbed mobilization, and site clearance within 24 to 48 hours, eliminating site handover delays and municipality penalties.
        </p>
        <ul class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-slate-700">
            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Instant Cash Payment Upon Agreement</li>
            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Free On-Site Inspection & Technical Valuation</li>
            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Heavy Crane Rigging & Flatbed Transport Included</li>
            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Bulk Compound Decommissioning (5 to 50+ Cabins)</li>
        </ul>
    </div>

    <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight font-display">2. Scrap Portacabin Buy in UAE – Certified Site Demolition & Removal</h2>
        <p class="mt-3 text-slate-600 leading-relaxed">
            If your site cabins have suffered severe corrosion, water damage, roof collapse, or structural fatigue, selling them as scrap is the most cost-effective and compliant disposal route. We are a licensed <strong>scrap portacabin buyer in the UAE</strong>. We calculate scrap value based on verified structural steel weight, copper electricals, and aluminum framing while executing safe, Civil Defense compliant dismantling directly on-site.
        </p>
        <div class="mt-4 p-4 rounded-xl bg-slate-50 border border-slate-200 text-sm space-y-2">
            <div class="flex justify-between font-semibold text-slate-900">
                <span>Safe Electrical De-energization:</span>
                <span class="text-emerald-700">100% Certified Handled</span>
            </div>
            <div class="flex justify-between font-semibold text-slate-900">
                <span>Sandwich Panel Core Stripping:</span>
                <span class="text-emerald-700">Environmentally Responsible</span>
            </div>
            <div class="flex justify-between font-semibold text-slate-900">
                <span>Freeport & Freezone Clearance:</span>
                <span class="text-emerald-700">JAFZA, KIZAD, HFZA Gate Permits</span>
            </div>
        </div>
    </div>

    <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight font-display">3. Used Portacabin Sell in UAE – Certified Second-Hand Site Cabins</h2>
        <p class="mt-3 text-slate-600 leading-relaxed">
            Looking for cost-effective, ready-to-deploy modular units? We stock thoroughly tested and certified <strong>used portacabins for sale in UAE</strong> at our Dubai and Sharjah depots. Every used unit undergoes a rigorous 40-point structural, waterproof, and electrical diagnostic check before dispatch.
        </p>
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-4 rounded-xl border border-slate-200 bg-white">
                <h4 class="font-bold text-slate-900 text-sm">Site Offices (20ft & 40ft)</h4>
                <p class="text-xs text-slate-500 mt-1">Insulated sandwich panel offices with pre-wired distribution boards and AC provisions.</p>
            </div>
            <div class="p-4 rounded-xl border border-slate-200 bg-white">
                <h4 class="font-bold text-slate-900 text-sm">Security Guard Houses</h4>
                <p class="text-xs text-slate-500 mt-1">Compact 1.5m x 1.5m to 2.4m x 2.4m guard huts with 360-degree sliding windows.</p>
            </div>
            <div class="p-4 rounded-xl border border-slate-200 bg-white">
                <h4 class="font-bold text-slate-900 text-sm">Ablution & Toilet Units</h4>
                <p class="text-xs text-slate-500 mt-1">Multi-stall hygienic site toilets, urinals, wash basins, and water heater points.</p>
            </div>
        </div>
    </div>

    <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight font-display">4. Refurbished Portacabins in UAE & Dubai</h2>
        <p class="mt-3 text-slate-600 leading-relaxed">
            Our specialized modular engineering facility reconditions damaged site cabins into showroom-grade, long-lifecycle executive units. Our refurbishment protocol replaces degraded polyurethane (PU) or rockwool sandwich panels, applies multi-layer anti-rust epoxy coatings to structural steel chassis, installs high-ambient T3 split air conditioners, and refits heavy-duty industrial vinyl or porcelain tile floors.
        </p>
    </div>

    <div class="p-6 rounded-2xl bg-slate-900 text-white">
        <h3 class="text-xl font-bold font-display text-amber-400">Looking to Buy, Sell, Scrap or Refurbish a Portacabin?</h3>
        <p class="mt-2 text-sm text-slate-300">
            Contact our modular trading team today for an immediate cash offer on your surplus cabins or to inspect our refurbished inventory in Dubai and Sharjah.
        </p>
        <div class="mt-4 flex flex-wrap gap-4 items-center">
            <a href="https://wa.me/971569213754?text=Hello+Generator+Dubai,+I+am+inquiring+about+Buying/Selling/Scrap+Portacabins" target="_blank" class="px-5 py-2.5 rounded-xl font-bold text-xs bg-amber-500 text-slate-950 hover:bg-amber-400 transition">
                WhatsApp Portacabin Desk: +971 56 921 3754
            </a>
            <a href="tel:+971569213754" class="px-5 py-2.5 rounded-xl font-bold text-xs bg-slate-800 text-white hover:bg-slate-700 border border-slate-700 transition">
                Direct Call: +971 56 921 3754
            </a>
        </div>
    </div>
</div>
HTML;

    $service->update([
        'title' => 'Used & Refurbished Portacabins | Scrap Cabin Buying UAE',
        'tagline' => 'Used Portacabins Buy & Sell in Dubai, Scrap Portacabin Buyer UAE & Refurbished Site Offices',
        'summary' => 'Certified buyer & seller of used, scrap and refurbished portacabins across Dubai, Sharjah and UAE. Instant cash valuation, crane dismantling and transport. (Note: We do not offer rental portacabins).',
        'content' => $serviceContent,
        'meta_title' => 'Used Portacabin Buy & Sell Dubai | Scrap Portacabin Buyer UAE | Refurbished Cabins',
        'meta_description' => 'Buy and sell used portacabins in Dubai & UAE. Top scrap portacabin buyer with instant cash payment, crane dismantling, and premium refurbished site offices.',
        'focus_keyword' => 'used portacabin buy in dubai, scrap portacabin buy in uae, refurbished portacabin uae',
        'hero_badge' => 'UAE Modular Equipment Hub • Buy, Sell, Scrap & Refurbished Only',
    ]);
    echo "Service ID 20 successfully updated.\n";
}

echo "\n=== 2. UPDATING PAGE ID 32 (used-refurbished-generators) ===\n";
$page = Page::where('slug', 'used-refurbished-generators')->first();
if ($page) {
    $page->update([
        'meta_title' => 'Used & Refurbished Generators UAE | Used & Scrap Portacabin Buyer Dubai',
        'meta_description' => 'Certified load-tested used diesel generators for sale & buyback. Top buyer of used and scrap portacabins in UAE with instant cash payment and crane removal.',
        'focus_keyword' => 'used generator buy in dubai, scrap portacabin buy in uae, refurbished portacabin dubai',
    ]);
    echo "Page ID 32 meta updated.\n";
}

echo "\n=== 3. UPDATING CATEGORY ID 16 (portacabin) ===\n";
$cat = Category::where('slug', 'portacabin')->first();
if ($cat) {
    $cat->update([
        'name' => 'Used & Scrap Portacabin Trading UAE',
        'description' => 'Expert guides on buying used portacabins in Dubai, selling surplus site units, scrap portacabin valuation, crane demolition, and refurbished modular offices across UAE.',
    ]);
    echo "Category ID 16 updated.\n";
}

echo "\n=== 4. UPDATING POSTS 880 & 898 (RENTAL CABIN SLUGS) ===\n";
$p880 = Post::find(880);
if ($p880) {
    $p880->update([
        'title' => 'Turnkey Generator Power & Used Site Portacabin Packages: One Setup Solution',
        'slug' => 'turnkey-generator-power-used-portacabin-packages-uae',
        'meta_title' => 'Turnkey Generator Power & Used Portacabin Packages UAE | One Setup Solution',
        'meta_description' => 'Combine reliable temporary generator power rental with certified pre-owned or refurbished site portacabins in Dubai & UAE under one coordinated mobilization contract.',
    ]);
    echo "Post 880 updated.\n";
}

$p898 = Post::find(898);
if ($p898) {
    $p898->update([
        'title' => 'Buying Surplus Pre-Owned vs Contractor-Built Portacabins: What Lasts Longer?',
        'slug' => 'buying-surplus-preowned-vs-contractor-built-portacabin-uae',
        'meta_title' => 'Buying Surplus Pre-Owned vs Contractor-Built Portacabins UAE Comparison',
        'meta_description' => 'Engineering evaluation comparing surplus refurbished portacabins against temporary contractor-built plywood cabins for long-term UAE climate durability.',
    ]);
    echo "Post 898 updated.\n";
}

echo "\nCompleted Portacabin alignment!\n";
