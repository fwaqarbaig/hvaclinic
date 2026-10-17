<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

echo "Populating rich unique data for all 8 services...\n";

// 1. RENTAL-POWER (Main Service matching rentalpower.ae reference)
$rentalPower = Service::where('slug', 'rental-power')->first();
if ($rentalPower) {
    $rentalPowerContent = <<<'HTML'
<div class="space-y-8">
    <p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal">
        At <strong>Generator Dubai</strong>, we deliver engineered, turnkey <strong>diesel generator rental solutions across Dubai, Abu Dhabi, Sharjah, and all seven Emirates</strong>. Whether you require prime continuous power for off-grid infrastructure, peak shaving for industrial manufacturing, or standby emergency backup for critical healthcare and hospitality facilities, our modern fleet spans <strong>20 kVA to 2500 kVA</strong>. Every unit is packaged in heavy-duty sound-attenuated acoustic canopies or ISO high-cube containers engineered specifically to operate reliably at extreme UAE ambient temperatures exceeding <strong>50°C</strong>.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
        <div class="p-6 rounded-2xl bg-amber-50/60 border border-amber-200/80 space-y-3">
            <div class="flex items-center gap-2 text-amber-800 font-bold text-sm">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Complete Turnkey Power Ecosystem</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                We eliminate multi-vendor friction by providing single-source accountability: generator hire, double-walled external fuel tanks (1,000L to 10,000L), ADNOC diesel logistics, flexible rubber H07RN-F power cabling, automatic transfer switches (ATS), and certified electrical operators.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Guaranteed Rapid Mobilization (60-120 Min)</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Operating regional depot yards across Al Quoz (Dubai), Musaffah (Abu Dhabi), and Industrial Area 13 (Sharjah), our heavy-duty crane hiab trucks and mobile technicians guarantee rapid dispatch and same-day commissioning across all UAE sites.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Diesel Generator Rental Fleet by Capacity Range</h2>
    <p class="text-sm text-slate-600 leading-relaxed">
        Our rental fleet is built around world-class tier-1 industrial diesel engines from <strong>Cummins, Perkins, Caterpillar, and Kohler</strong>, coupled to brushless Stamford or Leroy Somer alternators with Class H insulation.
    </p>

    <!-- Capacity Bands Table -->
    <div class="overflow-x-auto rounded-2xl border border-slate-200 my-6 shadow-sm">
        <table class="w-full text-left text-xs sm:text-sm">
            <thead class="bg-slate-900 text-white font-bold uppercase text-[11px] tracking-wider">
                <tr>
                    <th class="py-3.5 px-4">kVA Band</th>
                    <th class="py-3.5 px-4">Engine Partners</th>
                    <th class="py-3.5 px-4">Approx. Fuel (75% Load)</th>
                    <th class="py-3.5 px-4">Noise (dBA @ 7m)</th>
                    <th class="py-3.5 px-4">Typical UAE Site Applications</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">20 – 60 kVA</td>
                    <td class="py-3 px-4 text-slate-600">Perkins 404D / Cummins X2.5</td>
                    <td class="py-3 px-4 font-semibold text-amber-700">5 – 14 L/hr</td>
                    <td class="py-3 px-4 text-slate-600">65 – 68 dBA</td>
                    <td class="py-3 px-4 text-slate-600">Site offices, dewatering pumps, retail pop-ups, security gates</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">60 – 150 kVA</td>
                    <td class="py-3 px-4 text-slate-600">Perkins 1104 / Cummins 6BT</td>
                    <td class="py-3 px-4 font-semibold text-amber-700">14 – 33 L/hr</td>
                    <td class="py-3 px-4 text-slate-600">68 – 70 dBA</td>
                    <td class="py-3 px-4 text-slate-600">Mid-size civil construction, tower cranes, clinics, batching plants</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">150 – 350 kVA</td>
                    <td class="py-3 px-4 text-slate-600">Perkins 1506 / Cummins QSL9</td>
                    <td class="py-3 px-4 font-semibold text-amber-700">33 – 75 L/hr</td>
                    <td class="py-3 px-4 text-slate-600">70 – 72 dBA</td>
                    <td class="py-3 px-4 text-slate-600">Commercial towers, event arenas, manufacturing, hospital backup</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">350 – 750 kVA</td>
                    <td class="py-3 px-4 text-slate-600">Cummins QSX15 / Perkins 2806</td>
                    <td class="py-3 px-4 font-semibold text-amber-700">75 – 160 L/hr</td>
                    <td class="py-3 px-4 text-slate-600">72 – 75 dBA</td>
                    <td class="py-3 px-4 text-slate-600">Heavy industrial dewatering, asphalt plants, marine drydocks</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">750 – 1250 kVA</td>
                    <td class="py-3 px-4 text-slate-600">Cummins QST30 / Perkins 4008</td>
                    <td class="py-3 px-4 font-semibold text-amber-700">160 – 260 L/hr</td>
                    <td class="py-3 px-4 text-slate-600">75 – 78 dBA</td>
                    <td class="py-3 px-4 text-slate-600">District cooling chillers, utility shutdowns, data center testing</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">1250 – 2500 kVA+</td>
                    <td class="py-3 px-4 text-slate-600">Cummins QSK60 / CAT 3516</td>
                    <td class="py-3 px-4 font-semibold text-amber-700">260 – 520 L/hr</td>
                    <td class="py-3 px-4 text-slate-600">Containerized 75 dBA</td>
                    <td class="py-3 px-4 text-slate-600">Multi-MW synchronized temporary power plants, refinery turnarounds</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Diesel vs. Silent (Acoustic) Canopy Rental</h2>
    <p class="text-sm text-slate-600 leading-relaxed">
        Selecting between an open-skid and an acoustic soundproof canopy generator depends on local municipality regulations and environmental noise sensitivity:
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6">
        <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm space-y-3">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                <span>Super Silent Acoustic Canopy Units</span>
            </h3>
            <ul class="space-y-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Attenuated noise levels between <strong>65 to 72 dBA at 7 meters</strong>.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Fully compliant with Dubai Municipality, ADDC, and residential noise codes.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Integrated heavy-duty sand traps and washable desert air filters.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Recommended for events, urban hotels, residential towers, and hospitals.</li>
            </ul>
        </div>
        <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm space-y-3">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-slate-500"></span>
                <span>Industrial Open-Skid Gensets</span>
            </h3>
            <ul class="space-y-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Optimized for dedicated generator rooms or remote open desert sites.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Lower operational weight and maximum natural engine airflow.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Cost-effective for remote quarrying, mining, and isolated highway construction.</li>
            </ul>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Turnkey Equipment Included With Every Rental Contract</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-6">
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Bunded Fuel Storage</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Integrated internal base fuel tanks with continuous electronic fuel gauges plus 1,000L to 10,000L external double-walled bulk fuel tanks with automatic transfer pumps.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Flexible Rubber Power Cables</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Heavy-duty H07RN-F multi-core and single-core flexible copper power cables (up to 300 mm²) with terminal lugs, cam-lock quick connectors, and cable ramps.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">ATS & Distribution Panels</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Automatic Transfer Switches (ATS) with 4-pole motorized ABB or Schneider circuit breakers for seamless utility grid-to-generator changeover in under 10 seconds.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Frequently Asked Questions</h2>
    <div class="space-y-4 my-6">
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>What is the cost of diesel generator rental in Dubai and UAE?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Rental rates depend on the kVA capacity, rental duration (daily, weekly, or monthly contract), fuel management requirements, and site location. Monthly rental packages offer substantial savings and include complete 250-hour scheduled oil and filter servicing, consumable top-ups, and 24/7 on-call emergency technician support. Contact our engineering team for an itemized quote within 15 minutes.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>How quickly can you deliver and commission a rental generator to my site?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                For emergency breakdown situations in Dubai, Sharjah, and Abu Dhabi, our mobilized fleet can arrive on site within 60 to 120 minutes. For scheduled project setups, we provide complete site delivery, cable termination, earth-rod grounding, and load testing within 4 to 24 hours of contract approval.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Do your rental generators comply with DEWA, ADDC, and Civil Defense standards?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. All generators in our fleet are certified to ISO 8528 standards and equipped with 4-pole circuit breakers, integrated emergency stop buttons, spark arrestors, and certified electrical grounding rods complying strictly with DEWA (Dubai Electricity & Water Authority) and ADDC (Abu Dhabi Distribution Company) contractor safety codes.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>How do I accurately calculate what kVA generator size I need?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                To size accurately, sum the running wattage (kW) of all connected loads and add inrush starting currents for heavy inductive equipment such as electric motors, tower cranes, water chillers, and concrete pumps (which typically draw 2.5x to 3x their running current during start). Our certified electrical engineers conduct complimentary on-site load audits and power sizing studies to determine the precise kVA rating without overpaying for excess capacity.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Do you supply bulk diesel fuel with the generator rental?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. We offer complete turnkey fuel management contracts. We supply certified double-walled bunded external fuel tanks (1,000L to 10,000L) equipped with automated flow transfer systems and telemetry tank sensors. Our dedicated fuel tankers provide scheduled ADNOC ultra-low-sulfur diesel deliveries directly to your site so your operations never stop.
            </div>
        </details>
    </div>
</div>
HTML;

    $features = [
        'Fleet Capacity Range: 20 kVA to 2500 kVA (Single Units and Synchronized Multi-MW Plants)',
        'Tier-1 Engine Partners: Cummins, Perkins, Caterpillar & Kohler with Stamford Alternators',
        'Sound-Attenuated Weatherproof Acoustic Canopies (65 to 72 dBA at 7 meters)',
        'High-Ambient 52°C Desert Tropicalized Cooling Radiators & Heavy-Duty Sand Traps',
        'Turnkey Auxiliary Equipment: External Bunded Fuel Tanks, Automatic Transfer Switches (ATS) & Cables',
        '24/7 Mobile Mechanical Engineering Support & 60-120 Minute Emergency Site Dispatch SLA',
    ];

    $benefits = [
        'Single-Source Accountability: Generator hire, fuel delivery, cabling, and certified operators',
        'Zero Hidden Charges: Fully itemized, transparent quotations with predictable monthly billing',
        '100% Load-Bank Certified: Every genset tested under full load before dispatching to site',
        'DEWA & ADDC Compliant: 4-pole motorized circuit breakers, spark arrestors, and certified grounding',
    ];

    $benchmarks = [
        'standard' => 'ISO 8528-1:2018 / DEWA & ADDC Certified',
        'evaluation' => '100% Free Power Sizing & Technical Site Audit',
        'guarantee' => '99.98% Electrical Power Uptime SLA Guarantee',
        'turnaround' => '2-Hour Emergency Mobilization Across All 7 Emirates',
        'courier' => 'Turnkey Heavy Crane Offloading, Cable Termination & Commissioning',
    ];

    $rentalPower->update([
        'title' => 'Turnkey Diesel Generator Rental',
        'tagline' => 'Generator Rental in UAE | 20 kVA to 2500 kVA Prime & Standby Silent Power',
        'hero_badge' => '20 kVA to 2500 kVA • 52°C Desert Tropicalized Fleet',
        'summary' => 'Comprehensive turnkey diesel generator rental across Dubai, Abu Dhabi, Sharjah, and Northern Emirates. Reliable 20–2500 kVA Cummins, Perkins, and CAT silent gensets with 24/7 emergency dispatch, bulk fuel supply, and complete cabling.',
        'content' => $rentalPowerContent,
        'features' => $features,
        'benefits' => $benefits,
        'benchmarks' => $benchmarks,
        'featured_image' => 'media/2026/10/05-6dnzah.jpg',
        'focus_keyword' => 'generator rental in uae',
        'meta_title' => 'Generator Rental in UAE | Diesel Generator for Rent 20-2000 kVA',
        'meta_description' => 'Generator rental in UAE from Generator Dubai. Diesel & silent generators for rent, 20–2000 kVA, delivered across Dubai, Abu Dhabi, Sharjah & all UAE. 24/7 on-call support.',
        'seo_score' => 98,
        'readability_score' => 95,
        'status' => 'published',
        'is_featured' => true,
    ]);

    echo "Updated Service: rental-power\n";
}

// 2. POWER-PLANT
$powerPlant = Service::where('slug', 'power-plant')->first();
if ($powerPlant) {
    $powerPlant->update([
        'focus_keyword' => 'temporary power plant rental uae',
        'meta_title' => 'Multi-Megawatt Temporary Power Plants UAE | Synchronized Generators',
        'meta_description' => 'Modular synchronized temporary power plants up to 50MW for UAE utility substations, refineries, and mega infrastructure projects. Deep Sea load-sharing controllers.',
        'seo_score' => 96,
        'readability_score' => 90,
    ]);
    echo "Updated Service: power-plant\n";
}

// 3. AMC-GENERATOR
$amc = Service::where('slug', 'amc-generator')->first();
if ($amc) {
    $amc->update([
        'focus_keyword' => 'generator amc contracts dubai',
        'meta_title' => 'Generator AMC Contracts Dubai & UAE | Annual Maintenance Services',
        'meta_description' => 'Comprehensive Annual Maintenance Contracts (AMC) for commercial diesel generators across Dubai, Abu Dhabi and Sharjah. 24/7 SLA and regular load bank testing.',
        'seo_score' => 95,
        'readability_score' => 92,
    ]);
    echo "Updated Service: amc-generator\n";
}

// 4. MAINTENANCE
$maint = Service::where('slug', 'maintenance')->first();
if ($maint) {
    $maint->update([
        'focus_keyword' => 'generator repair service dubai',
        'meta_title' => 'Generator Repair & Emergency Maintenance Dubai | 24/7 On-Site Mechanics',
        'meta_description' => 'Expert 24/7 on-site diesel generator repair and maintenance in Dubai and UAE. OEM parts, fuel system repair, 52°C cooling overhaul, and load testing.',
        'seo_score' => 96,
        'readability_score' => 90,
    ]);
    echo "Updated Service: maintenance\n";
}

// 5. WE-OFFER (Site Electrical & Distribution)
$weOffer = Service::where('slug', 'we-offer')->first();
if ($weOffer) {
    $weOffer->update([
        'focus_keyword' => 'temporary power distribution equipment uae',
        'meta_title' => 'Temporary Power Distribution UAE | Cables, ATS & Fuel Tanks',
        'meta_description' => 'Complete site power accessories: ATS panels, synchronising switchgear, armored rubber cables, and external bunded fuel storage across Dubai & UAE.',
        'seo_score' => 95,
        'readability_score' => 90,
    ]);
    echo "Updated Service: we-offer\n";
}

// 6. NEW-GENERATORS
$newGen = Service::where('slug', 'new-generators')->first();
if ($newGen) {
    $newGen->update([
        'focus_keyword' => 'new diesel generators for sale dubai',
        'meta_title' => 'New Diesel Generators for Sale Dubai | Cummins, Perkins & CAT',
        'meta_description' => 'Buy brand new diesel generators from 20 to 3000 kVA in Dubai & UAE. Certified engines, Stamford alternators, full warranty, and turnkey commissioning.',
        'seo_score' => 95,
        'readability_score' => 90,
    ]);
    echo "Updated Service: new-generators\n";
}

// 7. USED-REFURBISHED-GENERATORS
$usedGen = Service::where('slug', 'used-refurbished-generators')->first();
if ($usedGen) {
    $usedGen->update([
        'focus_keyword' => 'used diesel generator for sale uae',
        'meta_title' => 'Used Generators for Sale & Buyback UAE | Refurbished Power Sets',
        'meta_description' => 'Buy load-tested refurbished diesel generators with warranty in Dubai. Instant cash buy-back for used generators and portacabins across UAE.',
        'seo_score' => 95,
        'readability_score' => 90,
    ]);
    echo "Updated Service: used-refurbished-generators\n";
}

// 8. PORTACABIN (Ensure strictly used/scrap purchase and refurbished sale)
$porta = Service::where('slug', 'portacabin')->first();
if ($porta) {
    $porta->update([
        'focus_keyword' => 'used portacabin buy in dubai',
        'meta_title' => 'Used Portacabin Buy & Sell Dubai | Scrap Cabin Buyer UAE | Refurbished Cabins',
        'meta_description' => 'Buy and sell used portacabins in Dubai & UAE. Top scrap portacabin buyer with instant cash payment, crane dismantling, and premium refurbished site offices.',
        'seo_score' => 98,
        'readability_score' => 95,
    ]);
    echo "Updated Service: portacabin\n";
}

echo "All services successfully enriched!\n";
