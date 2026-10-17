<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

echo "Enriching all remaining services with comprehensive, crawlable 1,000+ word content...\n";

// 1. POWER-PLANT
$svc = Service::where('slug', 'power-plant')->first();
if ($svc) {
    $content = <<<'HTML'
<div class="space-y-8">
    <p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal">
        <strong>Generator Dubai</strong> engineers and deploys <strong>synchronized multi-megawatt temporary power plants across the UAE</strong>, scalable from <strong>1 Megawatt (1000 kVA) up to 50 Megawatts</strong>. Designed for heavy industrial complexes, utility substations, district cooling plants, remote mining, and oil &amp; gas refinery turnarounds, our temporary power plants deliver utility-grade, continuous prime electricity with N+1 redundancy. Every power plant package integrates digital Deep Sea 8610 MKII load-sharing controllers, containerized acoustic enclosures, high-voltage step-up transformers (415V to 11kV / 22kV / 33kV), and turnkey automated bulk fuel farms.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
        <div class="p-6 rounded-2xl bg-amber-50/60 border border-amber-200/80 space-y-3">
            <div class="flex items-center gap-2 text-amber-800 font-bold text-sm">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Automated N+1 Load Sharing & Peak Shaving</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                By paralleling multiple 1000 kVA to 2000 kVA containerized generator modules, our intelligent control systems dynamically start and stop individual gensets according to real-time site electrical demand. This guarantees optimal fuel efficiency, eliminates wet-stacking, and ensures zero power interruption during maintenance routines.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>High-Voltage Step-Up Transformers (11kV – 33kV)</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                For utility substation grid injection or powering distant industrial loads across large desert perimeters, we supply step-up transformers, vacuum circuit breakers (VCB), and medium-voltage switchgear fully compliant with DEWA, ADDC, and FEWA utility requirements.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Temporary Multi-MW Power Plant Configurations</h2>
    <div class="overflow-x-auto rounded-2xl border border-slate-200 my-6 shadow-sm">
        <table class="w-full text-left text-xs sm:text-sm">
            <thead class="bg-slate-900 text-white font-bold uppercase text-[11px] tracking-wider">
                <tr>
                    <th class="py-3.5 px-4">Plant Output</th>
                    <th class="py-3.5 px-4">Modular Genset Arrangement</th>
                    <th class="py-3.5 px-4">Fuel Consumption (Est.)</th>
                    <th class="py-3.5 px-4">Voltage Options</th>
                    <th class="py-3.5 px-4">Primary Application</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">2.5 MW (3125 kVA)</td>
                    <td class="py-3 px-4 text-slate-600">3x 1250 kVA (2+1 N Redundancy)</td>
                    <td class="py-3 px-4 font-semibold text-amber-700">~550 L/hr @ 75% load</td>
                    <td class="py-3 px-4 text-slate-600">415V / 11kV</td>
                    <td class="py-3 px-4 text-slate-600">District cooling plants, heavy commercial developments</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">5.0 MW (6250 kVA)</td>
                    <td class="py-3 px-4 text-slate-600">5x 1250 kVA or 3x 2000 kVA</td>
                    <td class="py-3 px-4 font-semibold text-amber-700">~1,100 L/hr @ 75% load</td>
                    <td class="py-3 px-4 text-slate-600">415V / 11kV / 22kV</td>
                    <td class="py-3 px-4 text-slate-600">Substation maintenance bypass, hospital expansions</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">10.0 MW (12500 kVA)</td>
                    <td class="py-3 px-4 text-slate-600">6x 2000 kVA High-Cube Containers</td>
                    <td class="py-3 px-4 font-semibold text-amber-700">~2,200 L/hr @ 75% load</td>
                    <td class="py-3 px-4 text-slate-600">11kV / 33kV Step-Up</td>
                    <td class="py-3 px-4 text-slate-600">Oil &amp; gas refineries (Ruwais, Habshan), industrial zones</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">20.0 MW to 50 MW</td>
                    <td class="py-3 px-4 text-slate-600">Custom Multi-Node Grid Array</td>
                    <td class="py-3 px-4 font-semibold text-amber-700">Bulk Pipeline / Telemetry</td>
                    <td class="py-3 px-4 text-slate-600">33kV Grid Tie-In</td>
                    <td class="py-3 px-4 text-slate-600">National grid stability, seasonal summer peak shaving</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Why Modular Power Plants Outperform Single Giant Generators</h2>
    <p class="text-sm text-slate-600 leading-relaxed">
        Relying on a single massive generator creates a dangerous single point of failure and wastes immense amounts of fuel during low-load nighttime hours. Our modular synchronized power plants solve this completely:
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-6">
        <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm space-y-3">
            <h3 class="text-base font-bold text-slate-900">1. Unmatched Reliability (N+1)</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                If any generator requires scheduled oil servicing or experiences an unexpected trip, the remaining units instantly absorb the load without a millisecond of site downtime.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm space-y-3">
            <h3 class="text-base font-bold text-slate-900">2. Dramatic Fuel Savings</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                During off-peak shifts, our Deep Sea synchronizing controllers automatically power down unneeded generators, keeping operating engines at their optimal 75-80% fuel efficiency sweet spot.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-sm space-y-3">
            <h3 class="text-base font-bold text-slate-900">3. Fast Desert Mobilization</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Standard ISO high-cube containerized modules are transported easily across UAE highways without requiring oversized police escort permits, slashing mobilization time from months to days.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Frequently Asked Questions</h2>
    <div class="space-y-4 my-6">
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>How fast can a multi-megawatt temporary power plant be commissioned in UAE?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                For standard 2MW to 10MW plants, our equipment can be mobilized to site within 24 to 48 hours. Turnkey cabling, earth grid testing, step-up transformer integration, and full load commissioning typically take 3 to 5 business days, depending on site civil readiness.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Can your power plant synchronize directly with the DEWA or ADDC grid?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. Our synchronizing switchgear and Deep Sea / ComAp controllers support both island mode (isolated power) and mains parallel mode (soft transfer and peak shaving grid synchronization) adhering strictly to local utility interconnection safety protocols.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Do you provide 24/7 on-site electrical operators for the power plant?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. Every multi-megawatt power plant contract includes dedicated shifts of certified electrical engineers and mechanical technicians stationed on site 24/7/365 to handle telemetry monitoring, scheduled oil filter changes, and continuous fuel logistics.
            </div>
        </details>
    </div>
</div>
HTML;

    $features = [
        'Modular Multi-Megawatt Capacity: 1 MW to 50 MW Synchronized Generation',
        'Deep Sea 8610 MKII & ComAp Digital Automated Load-Sharing Switchgear',
        'High-Voltage Step-Up Transformers: 415V to 11kV, 22kV, and 33kV Output',
        'Containerized ISO High-Cube Acoustic Enclosures Engineered for 52°C Ambient Heat',
        'Turnkey Bulk Fuel Farms: 10,000L to 50,000L Storage with Automated Telemetry',
        '24/7 Dedicated On-Site Shift Engineers & Electrical Maintenance Crew',
    ];

    $benefits = [
        'Zero Single Point of Failure: N+1 Redundancy guarantees 99.99% electrical uptime',
        'Optimized Fuel Economy: Automated start/stop controls match fluctuating site loads',
        'Utility Interconnection Ready: Fully certified for DEWA, ADDC, and FEWA grid tie-in',
        'Rapid Deployment: Containerized modules transport easily across all UAE highways',
    ];

    $svc->update([
        'content' => $content,
        'features' => $features,
        'benefits' => $benefits,
        'tagline' => 'Synchronized Multi-Megawatt Power Plants UAE | 1MW to 50MW Grid & Industrial Power',
        'hero_badge' => '1 MW to 50 MW Modular Power Plants • High Voltage 11kV/33kV',
        'summary' => 'Turnkey synchronized temporary power plants from 1MW to 50MW across Dubai, Abu Dhabi, and UAE. Featuring Deep Sea digital load-sharing, step-up transformers, bulk fuel management, and 24/7 on-site electrical engineering crews.',
        'featured_image' => 'media/2026/10/06-wx9o27.jpg',
    ]);
    echo "Enriched: power-plant\n";
}

// 2. AMC-GENERATOR
$svc = Service::where('slug', 'amc-generator')->first();
if ($svc) {
    $content = <<<'HTML'
<div class="space-y-8">
    <p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal">
        A standby diesel generator is your facility's ultimate line of defense against catastrophic electrical blackouts. At <strong>Generator Dubai</strong>, we provide comprehensive, Civil Defense and municipality-compliant <strong>Annual Maintenance Contracts (AMC) across Dubai, Abu Dhabi, Sharjah, and Northern Emirates</strong>. Serving commercial towers, residential communities, hospitals, data centers, manufacturing plants, and industrial warehouses, our AMC programs ensure your diesel generators start instantaneously and perform flawlessly during unexpected grid outages.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
        <div class="p-6 rounded-2xl bg-amber-50/60 border border-amber-200/80 space-y-3">
            <div class="flex items-center gap-2 text-amber-800 font-bold text-sm">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Civil Defense & Municipality Compliance</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                UAE regulations mandate regular certified inspections of emergency standby power systems. Our AMC contracts include official logbooks, preventive inspection stamps, and compliance documentation required for Dubai Civil Defense, ADDC, and municipality facility renewals.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Guaranteed 2-Hour Emergency Breakdown SLA</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                AMC contract holders enjoy 24/7/365 priority access to our rapid-response mobile engineering vans. In the event of a sudden generator fault or controller failure, our certified technicians arrive on site within 60 to 120 minutes with diagnostic tooling and OEM spare parts.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Generator AMC Service Tiers & Scope</h2>
    <div class="overflow-x-auto rounded-2xl border border-slate-200 my-6 shadow-sm">
        <table class="w-full text-left text-xs sm:text-sm">
            <thead class="bg-slate-900 text-white font-bold uppercase text-[11px] tracking-wider">
                <tr>
                    <th class="py-3.5 px-4">Inspection Level</th>
                    <th class="py-3.5 px-4">Frequency</th>
                    <th class="py-3.5 px-4">Key Technical Procedures Included</th>
                    <th class="py-3.5 px-4">Ideal For</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">Standard Preventive AMC</td>
                    <td class="py-3 px-4 text-slate-600">Monthly or Bi-Monthly</td>
                    <td class="py-3 px-4 text-slate-600">50-point diagnostic check, battery voltage &amp; conductance testing, coolant pH analysis, belt tensioning, ATS test without load</td>
                    <td class="py-3 px-4 text-slate-600">Commercial retail, residential towers, schools</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">Comprehensive Major AMC</td>
                    <td class="py-3 px-4 text-slate-600">Quarterly + Major Overhaul</td>
                    <td class="py-3 px-4 text-slate-600">Complete replacement of engine oil, OEM oil filters, fuel/water separators, air filters, coolant flush, valve lash adjustment</td>
                    <td class="py-3 px-4 text-slate-600">Industrial factories, logistics hubs, hotel towers</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">Mission-Critical Gold AMC</td>
                    <td class="py-3 px-4 text-slate-600">Continuous 24/7 Monitoring</td>
                    <td class="py-3 px-4 text-slate-600">All major consumables included, annual resistive load bank testing, thermal imaging of electrical busbars, priority 1-hour SLA</td>
                    <td class="py-3 px-4 text-slate-600">Hospitals, Tier III/IV data centers, banking servers</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Resistive Load Bank Testing (ISO 8528 Protocol)</h2>
    <p class="text-sm text-slate-600 leading-relaxed">
        Standby generators that run only during brief weekly no-load exercise cycles suffer from severe carbon buildup, unburned diesel accumulation ("wet-stacking"), and cylinder glazing. As part of our comprehensive AMC contracts, we deploy mobile resistive load bank trailers (up to 2000 kW) to test your genset at 25%, 50%, 75%, and 100% full rated load for 2 to 4 hours. This burns away accumulated soot, tests cooling radiator efficiency under 50°C summer conditions, and verifies alternator voltage regulation.
    </p>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Frequently Asked Questions</h2>
    <div class="space-y-4 my-6">
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>What brands of diesel generators do you service under AMC contracts?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Our factory-trained engineers service all leading industrial generator brands, including Cummins, Perkins, Caterpillar (CAT), Kohler, Volvo Penta, MTU, Baudouin, Doosan, and Mitsubishi. We stock genuine OEM filters, sensors, belts, and Deep Sea / ComAp electronic controllers in our UAE central warehouse.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Are spare parts and oil filters included in the AMC contract price?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                We offer both "Labor Only" AMC contracts (where consumables are billed separately upon pre-approval) and "Comprehensive AMC" packages where all scheduled engine lubricants, OEM oil filters, fuel filters, and air elements are bundled into a fixed annual fee.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Do you test Automatic Transfer Switches (ATS) during AMC visits?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. Every preventive maintenance visit includes inspection and electrical testing of ATS contactors, phase-monitoring relays, control wiring, and simulated mains failure transfers to guarantee seamless power changeover during real grid interruptions.
            </div>
        </details>
    </div>
</div>
HTML;

    $features = [
        'Comprehensive Preventive Maintenance Schedules (Monthly, Quarterly, Bi-Annual & Major)',
        'Genuine OEM Spares: Cummins Fleetguard, Perkins Powerpart, CAT, and Donaldson Filters',
        'Annual Full-Load Resistive Load Bank Testing to Prevent Diesel Wet-Stacking',
        'Civil Defense, DEWA & ADDC Approved Compliance Documentation & Inspection Logs',
        'Guaranteed 2-Hour Rapid Emergency Breakdown Dispatch Across All 7 Emirates',
        'Electronic Oil Condition Analysis & Thermal Imaging of Electrical Busbars',
    ];

    $benefits = [
        'Eliminate Unplanned Blackouts: Proactive testing catches failing batteries & sensors before crises',
        'Fixed Predictable Maintenance Budgets: No surprise repair charges or inflated emergency fees',
        'Extend Genset Lifespan: Prevents premature cylinder glazing, cooling sludge & turbo wear',
        'Certified Compliance: Ready for municipality and insurance audits at all times',
    ];

    $svc->update([
        'content' => $content,
        'features' => $features,
        'benefits' => $benefits,
        'tagline' => 'Generator AMC Contracts Dubai & UAE | Annual Maintenance Services & 24/7 SLA',
        'hero_badge' => 'Certified AMC Contracts • Civil Defense Compliant • 24/7 SLA',
        'summary' => 'Comprehensive Annual Maintenance Contracts (AMC) for commercial diesel generators across Dubai, Abu Dhabi, Sharjah, and all UAE. 24/7 emergency response SLA, genuine OEM parts, scheduled load bank testing, and Civil Defense compliance certification.',
        'featured_image' => 'media/2026/10/01-lptck9.jpg',
    ]);
    echo "Enriched: amc-generator\n";
}

// 3. MAINTENANCE & REPAIR
$svc = Service::where('slug', 'maintenance')->first();
if ($svc) {
    $content = <<<'HTML'
<div class="space-y-8">
    <p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal">
        When an industrial diesel generator trips, overheats, or fails to start, site operations come to an immediate halt. At <strong>Generator Dubai</strong>, our specialized <strong>24/7 Emergency Generator Repair and On-Site Overhaul division</strong> deploys fully equipped mobile workshops with factory-certified diesel mechanics across <strong>Dubai, Abu Dhabi, Sharjah, and all UAE Emirates within 60 to 120 minutes</strong>. From resolving high-ambient desert overheating and fuel injector failures to rewinding Stamford alternators and programming Deep Sea controllers, we resolve the toughest mechanical and electrical faults on site.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
        <div class="p-6 rounded-2xl bg-amber-50/60 border border-amber-200/80 space-y-3">
            <div class="flex items-center gap-2 text-amber-800 font-bold text-sm">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>60–120 Minute Emergency Rapid Dispatch</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Our fleet of mobile service vans carries electronic diagnostic computers (Cummins INSITE, Perkins EST, CAT ET), calibrated load analyzers, replacement starter motors, fuel solenoids, and emergency bypass contactors to get your power restored immediately.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>52°C Desert Overheating Remediation</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Extreme UAE summer ambient heat pushes cooling systems to their limits. We perform chemical radiator core de-scaling, fan clutch rebuilds, high-flow water pump replacements, and auxiliary cooling fan installations to guarantee continuous operation without thermal tripping.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Common Generator Breakdown Symptoms & On-Site Solutions</h2>
    <div class="overflow-x-auto rounded-2xl border border-slate-200 my-6 shadow-sm">
        <table class="w-full text-left text-xs sm:text-sm">
            <thead class="bg-slate-900 text-white font-bold uppercase text-[11px] tracking-wider">
                <tr>
                    <th class="py-3.5 px-4">Fault Symptom</th>
                    <th class="py-3.5 px-4">Likely Root Cause</th>
                    <th class="py-3.5 px-4">Our On-Site Emergency Action</th>
                    <th class="py-3.5 px-4">Standard Resolution Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">Engine Cranks But Won't Start</td>
                    <td class="py-3 px-4 text-slate-600">Air in fuel lines, bad fuel lift pump, tripped emergency stop, or faulty stop solenoid</td>
                    <td class="py-3 px-4 text-slate-600">Bleed common-rail fuel system, test solenoid voltage, replace fuel filters, verify ECU start command</td>
                    <td class="py-3 px-4 font-semibold text-emerald-600">1 – 2 Hours</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">High Engine Temperature (Overheat Trip)</td>
                    <td class="py-3 px-4 text-slate-600">Clogged radiator fins with desert sand, collapsed coolant hose, stuck thermostat, loose fan belt</td>
                    <td class="py-3 px-4 text-slate-600">High-pressure radiator reverse wash, thermostat replacement, heavy-duty belt tensioning, coolant vacuum refill</td>
                    <td class="py-3 px-4 font-semibold text-emerald-600">2 – 3 Hours</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">No Voltage Output (0V on Meter)</td>
                    <td class="py-3 px-4 text-slate-600">Blown Automatic Voltage Regulator (AVR), lost residual magnetism, shorted rotating diodes</td>
                    <td class="py-3 px-4 text-slate-600">AVR replacement &amp; tuning, 12V DC field flashing, bridge rectifier diode testing &amp; replacement</td>
                    <td class="py-3 px-4 font-semibold text-emerald-600">1 – 3 Hours</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">Engine Hunting / Unstable RPM</td>
                    <td class="py-3 px-4 text-slate-600">Dirty fuel filters, faulty electronic governor actuator, sticking throttle linkage</td>
                    <td class="py-3 px-4 text-slate-600">Actuator calibration, magnetic pickup sensor cleaning &amp; gap adjustment, GAC speed controller tuning</td>
                    <td class="py-3 px-4 font-semibold text-emerald-600">1 – 2 Hours</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">Excessive Black or White Smoke</td>
                    <td class="py-3 px-4 text-slate-600">Faulty injectors, turbocharger boost failure, choked air filter, cylinder head gasket leak</td>
                    <td class="py-3 px-4 text-slate-600">Electronic cylinder cutout test, turbo boost pressure check, injector cleaning or replacement</td>
                    <td class="py-3 px-4 font-semibold text-emerald-600">Same-Day</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Complete In-Shop & On-Site Engine Overhauls</h2>
    <p class="text-sm text-slate-600 leading-relaxed">
        For generators that have surpassed 10,000 to 15,000 running hours, our specialized engineering workshop in Sharjah Industrial Area performs complete zero-hour engine overhauls: crankshaft regrinding, cylinder liner replacement, piston and ring renewal, main bearing fitting, cylinder head resurfacing, and full dyno testing before reinstalling and recommissioning on your site.
    </p>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Frequently Asked Questions</h2>
    <div class="space-y-4 my-6">
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Can your technicians repair my generator in the middle of the night?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. Our 24/7 emergency dispatch hotline (+971 56 921 3754) is staffed around the clock. Mobile engineering teams are on active standby across Dubai, Abu Dhabi, and Sharjah every night, weekend, and public holiday to respond immediately to critical power outages.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>What happens if my generator cannot be repaired on site immediately?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                If an engine has suffered catastrophic mechanical failure (such as a thrown rod or cracked block) that requires workshop overhaul, we can immediately dispatch a temporary replacement rental generator from our fleet to your site within 2 hours, keeping your operations powered while the main unit is repaired.
            </div>
        </details>
    </div>
</div>
HTML;

    $features = [
        '24/7/365 Emergency Breakdown Dispatch (60–120 Minute SLA Across Dubai & All UAE)',
        'Factory Diagnostic Software: Cummins INSITE, Perkins EST, CAT ET, Deep Sea DSE Configuration',
        'Tropicalized Cooling System Remediation: Radiator chemical de-scaling & heavy-duty fan upgrades',
        'Electrical Repairs: Automatic Voltage Regulator (AVR) replacement, alternator rewinding & diode testing',
        'Fuel Injection Overhaul: Common-rail pump repair, injector nozzle calibration & fuel polishing',
        'Complete In-House Engine Rebuilds: Cylinder head machining, crankshaft regrinding & dyno testing',
    ];

    $benefits = [
        'Rapid Site Power Restoration: Fully equipped mobile workshop vans with common emergency spares',
        'Zero-Hour Overhauls: Restores tired, high-hour gensets to factory performance at a fraction of new cost',
        'Temporary Replacement Guarantee: Rental genset deployed instantly if in-depth overhaul is required',
        'Transparent Upfront Pricing: Clear diagnostic reports and written repair quotes prior to work',
    ];

    $svc->update([
        'content' => $content,
        'features' => $features,
        'benefits' => $benefits,
        'tagline' => 'Generator Repair & Maintenance Dubai | 24/7 Emergency On-Site Mechanics',
        'hero_badge' => '24/7 Emergency Repair • 60-120 Min On-Site Dispatch • OEM Spares',
        'summary' => 'Expert 24/7 on-site diesel generator repair, troubleshooting, engine overhauls, and preventive maintenance across Dubai, Abu Dhabi, Sharjah, and all UAE. Fast response mobile mechanics equipped with OEM parts and diagnostic tooling.',
        'featured_image' => 'media/2026/10/02-xbimnj.jpg',
    ]);
    echo "Enriched: maintenance\n";
}

// 4. WE-OFFER (Site Electrical & Distribution)
$svc = Service::where('slug', 'we-offer')->first();
if ($svc) {
    $content = <<<'HTML'
<div class="space-y-8">
    <p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal">
        A generator is only as effective as the distribution network that carries power to your site machinery. At <strong>Generator Dubai</strong>, we supply complete <strong>turnkey site electrical and temporary power distribution packages across the UAE</strong>. From heavy-duty Automatic Transfer Switch (ATS) panels and motorized synchronizing switchboards to flexible H07RN-F rubber power cabling, weather-resistant distribution boards (DBs), step-up/step-down transformers, and double-walled external bulk diesel tanks, we provide everything needed for a safe, code-compliant temporary electrical installation.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
        <div class="p-6 rounded-2xl bg-amber-50/60 border border-amber-200/80 space-y-3">
            <div class="flex items-center gap-2 text-amber-800 font-bold text-sm">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Automated ATS Changeover Panels (100A to 4000A)</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Equipped with motorized ABB or Schneider 4-pole circuit breakers and intelligent microprocessors, our ATS panels detect utility mains brownouts or blackouts and start the generator automatically, transferring the load in under 10 seconds with zero operator intervention.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Heavy-Duty H07RN-F Flexible Rubber Cables</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Ordinary PVC cables crack under intense UAE sun and vehicular site traffic. We provide premium EPR/PCP rubber insulated H07RN-F power cables (35mm² to 300mm²) with compression lugs, cam-lock plugs, and heavy-duty polyurethane drive-over cable ramps.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Site Power Distribution Equipment Matrix</h2>
    <div class="overflow-x-auto rounded-2xl border border-slate-200 my-6 shadow-sm">
        <table class="w-full text-left text-xs sm:text-sm">
            <thead class="bg-slate-900 text-white font-bold uppercase text-[11px] tracking-wider">
                <tr>
                    <th class="py-3.5 px-4">Equipment Category</th>
                    <th class="py-3.5 px-4">Available Capacities / Sizes</th>
                    <th class="py-3.5 px-4">Key Safety Features</th>
                    <th class="py-3.5 px-4">Typical Application</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">Automatic Transfer Switches (ATS)</td>
                    <td class="py-3 px-4 text-slate-600">100A, 250A, 400A, 800A, 1600A, 2500A, 4000A</td>
                    <td class="py-3 px-4 text-slate-600">4-Pole motorized interlocked breakers, phase monitoring, manual bypass handle</td>
                    <td class="py-3 px-4 text-slate-600">Hospitals, commercial buildings, data center utility backup</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">Flexible Power Cabling</td>
                    <td class="py-3 px-4 text-slate-600">Single Core &amp; 4-Core (35mm² to 300mm²)</td>
                    <td class="py-3 px-4 text-slate-600">Oil &amp; UV resistant H07RN-F rubber, Class 5 flexible stranded copper, crimped lugs</td>
                    <td class="py-3 px-4 text-slate-600">Connecting generators to main distribution boards &amp; chillers</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">Site Distribution Boards (MDB / SDB)</td>
                    <td class="py-3 px-4 text-slate-600">63A to 1250A Weatherproof IP65 Panels</td>
                    <td class="py-3 px-4 text-slate-600">Integrated RCD/ELCB 30mA earth leakage protection, MCBs, 16A/32A CEE sockets</td>
                    <td class="py-3 px-4 text-slate-600">Construction site power, tower cranes, outdoor events</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">External Bunded Fuel Storage</td>
                    <td class="py-3 px-4 text-slate-600">1,000L, 2,500L, 5,000L, 10,000L Tanks</td>
                    <td class="py-3 px-4 text-slate-600">Double-walled 110% containment bund, automatic transfer pump, remote fuel telemetry</td>
                    <td class="py-3 px-4 text-slate-600">Long-term continuous prime power, 7-day unattended runtime</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">Step-Up / Step-Down Transformers</td>
                    <td class="py-3 px-4 text-slate-600">500 kVA to 5000 kVA (415V to 11kV / 22kV / 33kV)</td>
                    <td class="py-3 px-4 text-slate-600">Oil-immersed or dry-type, Buchholz relay, high-voltage switchgear</td>
                    <td class="py-3 px-4 text-slate-600">Long-distance desert transmission, utility substation injection</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Frequently Asked Questions</h2>
    <div class="space-y-4 my-6">
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Can you supply cable ramps for high-traffic site roads?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. We provide heavy-duty polyurethane 2-channel, 3-channel, and 5-channel drive-over cable protectors rated up to 40 tons per axle, ensuring safety for dump trucks, concrete mixers, and site vehicles.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Do your distribution boards comply with DEWA site safety regulations?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. All temporary distribution boards feature 4-pole isolating main breakers, 30mA residual current devices (RCD) on all socket outlets, copper earthing bars, and certified IP65 weatherproof powder-coated steel or rubber enclosures.
            </div>
        </details>
    </div>
</div>
HTML;

    $features = [
        'Automatic Transfer Switches (ATS): 100A to 4000A with motorized 4-pole ABB/Schneider breakers',
        'Flexible Rubber Cables: Premium H07RN-F (35mm² to 300mm²) with certified copper lugs & cam-locks',
        'Weatherproof Distribution Boards (IP65): Integrated RCD/ELCB protection & CEE industrial sockets',
        'External Bunded Fuel Storage Tanks: 1,000L to 10,000L double-walled containment with auto-pumps',
        'High-Voltage Step-Up Transformers: 415V to 11kV / 22kV / 33kV for long-distance transmission',
        'Certified DEWA & ADDC Electrical Cable Termination, Earthing Rod Installation & Site Safety Audits',
    ];

    $benefits = [
        'Complete Single-Source Solution: No need to hire cables from one vendor and ATS from another',
        'Maximum Site Safety: Oil-resistant cables, vehicular cable ramps, and sensitive 30mA shock protection',
        'Extended Unattended Runtime: Bunded fuel tanks allow up to 7 to 14 days of continuous operation',
        'Instant On-Site Mobilization: Delivered and connected simultaneously with your rental generator',
    ];

    $svc->update([
        'content' => $content,
        'features' => $features,
        'benefits' => $benefits,
        'tagline' => 'Temporary Power Distribution UAE | Cables, ATS Panels & External Fuel Tanks',
        'hero_badge' => 'Turnkey Electrical Packages • ATS Panels • Rubber Cables • Bunded Tanks',
        'summary' => 'Complete site power electrical distribution rental across Dubai and UAE. Featuring 100A to 4000A Automatic Transfer Switches (ATS), flexible H07RN-F rubber power cables, IP65 distribution boards, step-up transformers, and bunded fuel tanks.',
        'featured_image' => 'media/2026/10/blog/ats-switch-guide.jpg',
    ]);
    echo "Enriched: we-offer\n";
}

// 5. NEW-GENERATORS
$svc = Service::where('slug', 'new-generators')->first();
if ($svc) {
    $content = <<<'HTML'
<div class="space-y-8">
    <p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal">
        Investing in a permanent standby or continuous prime power generator requires engineering precision and long-term reliability. At <strong>Generator Dubai</strong>, we supply <strong>brand new industrial diesel generators from 20 kVA to 3000 kVA across Dubai, Abu Dhabi, Sharjah, and all UAE Emirates</strong>. As authorized distributors and engineering partners for premier engine manufacturers—including <strong>Cummins (USA/UK), Perkins (UK), Caterpillar (USA), and Kohler (USA)</strong>—we deliver factory-tested power generation sets paired with brushless Stamford or Leroy Somer alternators and digital Deep Sea Electronics controllers.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
        <div class="p-6 rounded-2xl bg-amber-50/60 border border-amber-200/80 space-y-3">
            <div class="flex items-center gap-2 text-amber-800 font-bold text-sm">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Full Manufacturer Warranty & Commissioning</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Every new generator comes with an official 1 to 2-year manufacturer warranty (or 1,000 to 2,000 running hours), factory test certificates, and complete turnkey on-site installation, exhaust ducting, and DEWA/ADDC commissioning by our certified engineers.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>50°C Heavy-Duty Tropicalized Radiator Packages</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                European standard radiators overheat in Middle East summers. We supply all new units equipped with upgraded 50°C-rated high-ambient copper/brass cooling radiators, sand-trap louvers, and anti-vibration isolators engineered specifically for the UAE climate.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">New Generator Engine Series & Specifications</h2>
    <div class="overflow-x-auto rounded-2xl border border-slate-200 my-6 shadow-sm">
        <table class="w-full text-left text-xs sm:text-sm">
            <thead class="bg-slate-900 text-white font-bold uppercase text-[11px] tracking-wider">
                <tr>
                    <th class="py-3.5 px-4">Engine Brand</th>
                    <th class="py-3.5 px-4">Engine Family Series</th>
                    <th class="py-3.5 px-4">kVA Power Range</th>
                    <th class="py-3.5 px-4">Alternator Model</th>
                    <th class="py-3.5 px-4">Standard Warranty</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">Perkins (UK)</td>
                    <td class="py-3 px-4 text-slate-600">404D, 1104A, 1106A, 1506A, 2506A, 4008</td>
                    <td class="py-3 px-4 font-semibold text-amber-700">20 kVA – 2500 kVA</td>
                    <td class="py-3 px-4 text-slate-600">Stamford Brushless, Class H</td>
                    <td class="py-3 px-4 text-slate-600">1 Year / 1,000 Hours (Extendable)</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">Cummins (USA/UK)</td>
                    <td class="py-3 px-4 text-slate-600">4B3.9, 6BT5.9, 6CTA8.3, QSL9, QSX15, QSK60</td>
                    <td class="py-3 px-4 font-semibold text-amber-700">30 kVA – 3000 kVA</td>
                    <td class="py-3 px-4 text-slate-600">Stamford or Leroy Somer</td>
                    <td class="py-3 px-4 text-slate-600">2 Years / 2,000 Hours Standby</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">Caterpillar (CAT)</td>
                    <td class="py-3 px-4 text-slate-600">C4.4, C7.1, C9, C15, C18, C32</td>
                    <td class="py-3 px-4 font-semibold text-amber-700">100 kVA – 2000 kVA</td>
                    <td class="py-3 px-4 text-slate-600">CAT Brushless SR4B</td>
                    <td class="py-3 px-4 text-slate-600">Standard CAT Manufacturer Warranty</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">Kohler / Baudouin</td>
                    <td class="py-3 px-4 text-slate-600">KD Series / M26 &amp; M33 Series</td>
                    <td class="py-3 px-4 font-semibold text-amber-700">25 kVA – 2000 kVA</td>
                    <td class="py-3 px-4 text-slate-600">Mecc Alte / Leroy Somer</td>
                    <td class="py-3 px-4 text-slate-600">1 to 2 Years Manufacturer Warranty</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Turnkey Engineering Services Included with New Purchases</h2>
    <p class="text-sm text-slate-600 leading-relaxed">
        We do not just drop a crate at your facility; we handle the complete turnkey engineering installation:
    </p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-6">
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Site Sizing & Foundation</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Concrete plinth calculation, vibration spring isolators, and spatial planning for sound attenuation and ventilation.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Exhaust & Fuel Systems</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Stainless steel acoustic residential silencers, thermal exhaust lagging, external bulk fuel tank piping, and motorized fuel transfer.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Testing & DEWA Handover</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Full resistive load bank testing, insulation resistance megger testing, and official Civil Defense and DEWA/ADDC inspection sign-off.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Frequently Asked Questions</h2>
    <div class="space-y-4 my-6">
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Are your new generators supplied with soundproof acoustic canopies?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. We offer both open-skid gensets (for dedicated plant rooms) and factory-built acoustic soundproof canopies (68 to 72 dBA at 7 meters) with electrostatic powder coating, stainless steel lockable handles, and weatherproof intake/exhaust louvers.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Do you stock spare parts for the generators you sell?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. Our central parts distribution warehouse in Sharjah maintains extensive inventories of genuine filters, water pumps, injectors, AVRs, starters, alternators, and electronic sensors for every model we distribute.
            </div>
        </details>
    </div>
</div>
HTML;

    $features = [
        'Brand New Factory-Certified Generators: 20 kVA to 3000 kVA with official manufacturer warranties',
        'Tier-1 Engine Partnerships: Cummins, Perkins, Caterpillar & Kohler with Stamford Alternators',
        'Upgraded 50°C Tropicalized Radiator Packages with Sand Traps for Harsh UAE Desert Climates',
        'Deep Sea Electronics (DSE) Auto-Start Digital Controllers with RS485 & Telemetry Modbus',
        'Turnkey Engineering Installation: Concrete foundation, acoustic exhaust ducting & cabling',
        'Full Civil Defense, DEWA, ADDC & Municipality Authority Approval Assistance',
    ];

    $benefits = [
        'Factory Direct Pricing: Highly competitive commercial rates without intermediary markups',
        '100% Genuine OEM Equipment: Zero counterfeit or cloned engines, complete factory certificates',
        'Complete Turnkey Handover: From site power sizing study to final DEWA utility sign-off',
        'Local After-Sales Support: Backed by our fleet of mobile service vans and preventive AMC contracts',
    ];

    $svc->update([
        'content' => $content,
        'features' => $features,
        'benefits' => $benefits,
        'tagline' => 'New Diesel Generators for Sale Dubai | Cummins, Perkins & CAT 20–3000 kVA',
        'hero_badge' => 'New Diesel Generators • Cummins, Perkins & CAT • Full Warranty',
        'summary' => 'Authorized distributor of brand new Cummins, Perkins, Caterpillar, and Kohler diesel generators from 20 kVA to 3000 kVA in Dubai & UAE. Factory warranty, Stamford alternators, DEWA approval, and turnkey installation.',
        'featured_image' => 'media/2026/10/03-8ab0vq.jpg',
    ]);
    echo "Enriched: new-generators\n";
}

// 6. USED-REFURBISHED-GENERATORS
$svc = Service::where('slug', 'used-refurbished-generators')->first();
if ($svc) {
    $content = <<<'HTML'
<div class="space-y-8">
    <p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal">
        Looking for a cost-effective alternative to purchasing new equipment without compromising on operational reliability? <strong>Generator Dubai</strong> is the UAE's trusted specialist in <strong>used and refurbished diesel generator sales, purchases, and instant cash buyback</strong>. From <strong>30 kVA up to 1500 kVA</strong>, every pre-owned generator in our inventory undergoes a rigorous <strong>80-point engineering overhaul</strong> and complete <strong>resistive load-bank certification</strong> inside our Sharjah testing facility, backed by our comprehensive warranty.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
        <div class="p-6 rounded-2xl bg-amber-50/60 border border-amber-200/80 space-y-3">
            <div class="flex items-center gap-2 text-amber-800 font-bold text-sm">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>100% Load-Bank Certified with Written Warranty</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                We never sell untested equipment. Every refurbished generator is coupled to our industrial resistive load bank and tested at 100% rated capacity for 2 hours, verifying oil pressure, temperature stability, and alternator voltage regulation under simulated desert heat.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Instant Cash Buyback for Surplus Contractor Fleet</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Completed your civil project and have surplus diesel generators or decommissioned site equipment? We offer fair market evaluations, instant bank transfer payment, and provide our own crane trucks to safely remove equipment from your site anywhere in the UAE.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Our 80-Point Refurbishment & Inspection Protocol</h2>
    <div class="overflow-x-auto rounded-2xl border border-slate-200 my-6 shadow-sm">
        <table class="w-full text-left text-xs sm:text-sm">
            <thead class="bg-slate-900 text-white font-bold uppercase text-[11px] tracking-wider">
                <tr>
                    <th class="py-3.5 px-4">Inspection Phase</th>
                    <th class="py-3.5 px-4">Critical Mechanical / Electrical Tests</th>
                    <th class="py-3.5 px-4">Parts Replacement Standard</th>
                    <th class="py-3.5 px-4">Quality Sign-Off</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">1. Engine Compression &amp; Boroscope</td>
                    <td class="py-3 px-4 text-slate-600">Individual cylinder compression test, internal boroscope inspection of liner walls &amp; pistons</td>
                    <td class="py-3 px-4 text-slate-600">New piston rings, rod bearings, or complete re-ring if compression is &lt;90%</td>
                    <td class="py-3 px-4 font-semibold text-emerald-600">Certified Passed</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">2. Fuel &amp; Air Induction Systems</td>
                    <td class="py-3 px-4 text-slate-600">Fuel injection pump pressure calibration, injector pop testing, turbocharger shaft play check</td>
                    <td class="py-3 px-4 text-slate-600">New Fleetguard filters, ultrasonic injector cleaning, rebuilt turbo seals</td>
                    <td class="py-3 px-4 font-semibold text-emerald-600">Certified Passed</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">3. Cooling Radiator &amp; Water Flow</td>
                    <td class="py-3 px-4 text-slate-600">Chemical flushing of radiator tubes, pressure testing under 15 PSI, water pump impeller audit</td>
                    <td class="py-3 px-4 text-slate-600">New silicon hoses, high-temp thermostats, fresh OAT heavy-duty coolant</td>
                    <td class="py-3 px-4 font-semibold text-emerald-600">Certified Passed</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">4. Alternator &amp; Electrical Testing</td>
                    <td class="py-3 px-4 text-slate-600">1000V Megger insulation resistance test, rotating diode bridge test, AVR voltage stability check</td>
                    <td class="py-3 px-4 text-slate-600">Re-varnished Class H windings if insulation &lt;5MΩ, brand new SX460/MX321 AVR</td>
                    <td class="py-3 px-4 font-semibold text-emerald-600">Certified Passed</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">5. Acoustic Canopy Restoration</td>
                    <td class="py-3 px-4 text-slate-600">Sandblasting of surface rust, industrial zinc-primer recoating, sound-dampening foam replacement</td>
                    <td class="py-3 px-4 text-slate-600">New door gaskets, stainless lock latches, fresh weather-resistant polyurethane paint</td>
                    <td class="py-3 px-4 font-semibold text-emerald-600">Certified Passed</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Frequently Asked Questions</h2>
    <div class="space-y-4 my-6">
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Do you offer a warranty on refurbished used generators?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. All certified refurbished generators sold by Generator Dubai come with a written 3-month to 12-month mechanical and electrical warranty (or 500 to 1,000 running hours), including on-site service support.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>How do you calculate the purchase value of my used generator?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">▼</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                We assess the engine brand (Cummins, Perkins, and CAT retain the highest resale value), total hour-meter reading, canopy physical condition, alternator health, and current UAE market demand. Our technicians provide same-day valuation and instant cash or bank transfer payment.
            </div>
        </details>
    </div>
</div>
HTML;

    $features = [
        'Certified Pre-Owned Fleet: 30 kVA to 1500 kVA Genuine Cummins, Perkins & CAT Gensets',
        'Rigorous 80-Point Overhaul Protocol: Engine compression, fuel pump calibration & alternator megger test',
        '100% Resistive Load-Bank Tested: Every unit load-tested for 2 hours under full capacity prior to sale',
        'Written Warranty Coverage: 3 to 12 Months Warranty with on-site technician service support',
        'Instant Cash Buyback & Fleet Trade-In: Highest market valuation for surplus contractor equipment',
        'Turnkey Crane Logistics: Safe on-site removal and crane transport across all 7 Emirates',
    ];

    $benefits = [
        '40% to 60% Cost Savings: Heavy-duty industrial reliability at a fraction of brand-new prices',
        'Immediate Equipment Availability: In-stock units ready for same-day delivery without factory lead times',
        'Risk-Free Purchase: Load test certificates provided with every unit; view live load testing in our yard',
        'Hassle-Free Asset Liquidation: Convert idle surplus equipment into immediate cash liquidity',
    ];

    $svc->update([
        'content' => $content,
        'features' => $features,
        'benefits' => $benefits,
        'tagline' => 'Used Generators for Sale & Buyback UAE | Refurbished Power Sets with Warranty',
        'hero_badge' => 'Certified Pre-Owned • 100% Load-Bank Tested • Instant Buyback',
        'summary' => 'Buy load-tested refurbished diesel generators with warranty in Dubai and UAE. Certified pre-owned Cummins, Perkins, and Caterpillar units from 30 to 1500 kVA. Instant cash buy-back and fleet trade-ins for contractors.',
        'featured_image' => 'media/2026/10/04-be9wys.jpg',
    ]);
    echo "Enriched: used-refurbished-generators\n";
}

echo "All 8 services enriched successfully with comprehensive content and specs!\n";
