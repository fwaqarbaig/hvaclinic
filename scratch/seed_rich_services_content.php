<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

echo "=== SEEDING COMPREHENSIVE UNIQUE CONTENT FOR ALL 7 CORE SERVICES ===\n";

$servicesData = [
    // 1. Rental Cooling
    [
        'title' => 'Rental Cooling',
        'slug' => 'rental-cooling',
        'tagline' => 'Industrial & Commercial Chiller Rental in UAE | 50 TR to 1500 TR Turnkey Temporary Cooling Fleet',
        'hero_badge' => '50 TR to 1500 TR Modular Chiller Fleet • 52°C Desert Tropicalized • 2-Hour Rapid Dispatch',
        'icon' => 'snowflake',
        'summary' => 'Engineered temporary cooling solutions across Dubai, Abu Dhabi, Sharjah, and Northern Emirates. High-efficiency air-cooled and water-cooled rental chillers from 50 to 1500 TR with turnkey piping, secondary booster pumps, heat exchangers, and 24/7 on-site engineering support.',
        'focus_keyword' => 'rental cooling uae',
        'meta_title' => 'Rental Cooling & Chiller Hire in UAE (50-1500 TR) | HVAC Clinic',
        'meta_description' => 'Turnkey commercial & industrial rental cooling in Dubai, Abu Dhabi and UAE. 50 TR to 1500 TR air-cooled chillers, pumps, heat exchangers & 2-hour emergency dispatch.',
        'meta_keywords' => 'rental cooling uae, chiller rental dubai, temporary chiller hire abu dhabi, industrial cooling rental sharjah, air cooled chiller rental uae, emergency cooling services dubai, district cooling augmentation',
        'featured_image' => '/wp-content/uploads/2026/03/g-2.jpg',
        'order' => 1,
        'is_featured' => true,
        'features' => [
            'Capacity Fleet Range: 50 TR to 1500 TR Modular Chillers (Single Units and Multi-Megawatt Synchronized Clusters)',
            'Tier-1 OEM Fleets: Trane, Carrier, York (Johnson Controls) and Daikin Applied with Dual Semi-Hermetic Screw Compressors',
            '52°C High-Ambient Desert Tropicalization with Blygold Anti-Corrosion Hydrophilic Marine Coil Protection',
            'Environmentally Friendly Low-GWP Refrigerants (R134a, R410A, and R32 with Zero Ozone Depletion Potential)',
            'Turnkey Hydraulic Ancillaries: Dual-Pump Booster Skids (PN16), Buffer Expansion Tanks, and Plate Heat Exchangers',
            '24/7 Remote Telemetry GSM Monitoring, Instant Fault Diagnostics, and Guaranteed 2-Hour UAE Site Dispatch SLA',
        ],
        'benefits' => [
            'Single-Source Turnkey Accountability: Equipment rental, crane rigging, flexible piping, electrical hookup, and fuel/power synchronization',
            'Zero Capital Expenditure (CapEx): 100% tax-deductible operational expense with transparent, itemized weekly and monthly contracts',
            'Rapid 2-Hour Emergency Dispatch: Strategically mobilized yards in Al Quoz (Dubai), Musaffah (Abu Dhabi), and Industrial 13 (Sharjah)',
            'DEWA, ADDC & Civil Defense Compliant: Pre-certified electrical switchgear, 4-pole breakers, and tested earthing rods (<5 ohms)',
        ],
        'benchmarks' => [
            'standard' => 'AHRI 550/590 & Eurovent Certified Fleet',
            'evaluation' => 'Complimentary On-Site Heat Load Audit & Flow Sizing',
            'guarantee' => '99.98% Continuous Cooling Uptime SLA',
            'turnaround' => 'Under 2-Hour Emergency Dispatch Across UAE',
            'support' => '24/7 On-Site Mechanical & Certified HVAC Engineers',
        ],
        'content' => <<<'HTML'
<div class="space-y-8 text-slate-700">
    <p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal">
        At <strong>HVAC Clinic (HVAC & Power Solution FZE)</strong>, we engineer and deploy high-capacity <strong>rental cooling and temporary chiller systems across Dubai, Abu Dhabi, Sharjah, and all seven Emirates</strong>. When extreme summer temperatures exceed 48°C, permanent cooling infrastructure experiences severe thermal derating, district cooling plants face peak capacity limits, and industrial processes risk catastrophic thermal shutdowns. Our specialized fleet of <strong>50 TR to 1500 TR air-cooled and water-cooled rental chillers</strong> delivers instant, reliable temperature control engineered specifically for the harsh Arabian Gulf climate.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
        <div class="p-6 rounded-2xl bg-blue-50/70 border border-blue-200/80 space-y-3">
            <div class="flex items-center gap-2 text-blue-900 font-bold text-sm">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Turnkey Hydraulic & Piping Ecosystem</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                We eliminate multi-vendor delays by providing complete turnkey packages: certified rental chillers, heavy-duty secondary chilled water pumps (up to 350 m³/hr head), buffer expansion tanks, food-grade plate heat exchangers, flexible rubber hoses with Cam-Lock fittings, and automated power switchboards.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Rapid Mobilization (<2 Hours Across UAE)</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Operating regional depot yards across Al Quoz (Dubai), Musaffah (Abu Dhabi), and Sharjah Industrial Area, our flatbed hiab crane fleet and field engineers guarantee same-day delivery, hydraulic connection, pressure testing, and system commissioning.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Rental Chiller Fleet Technical Specifications by Capacity Band</h2>
    <p class="text-sm text-slate-600 leading-relaxed">
        Our rental cooling fleet is built around premium tier-1 OEM manufacturers including <strong>Trane, Carrier, York (Johnson Controls), and Daikin Applied</strong>. Every unit features dual independent refrigeration circuits, variable-speed condenser fans, and microprocessor control panels.
    </p>

    <!-- Technical Specification Table -->
    <div class="overflow-x-auto rounded-2xl border border-slate-200 my-6 shadow-xs">
        <table class="w-full text-left text-xs sm:text-sm">
            <thead class="bg-slate-900 text-white font-bold uppercase text-[11px] tracking-wider">
                <tr>
                    <th class="py-3.5 px-4">Capacity Range</th>
                    <th class="py-3.5 px-4">Compressor Type</th>
                    <th class="py-3.5 px-4">Water Flow (m³/hr)</th>
                    <th class="py-3.5 px-4">Noise (dBA @ 10m)</th>
                    <th class="py-3.5 px-4">Typical UAE Applications</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-blue-900">50 – 100 TR</td>
                    <td class="py-3 px-4 text-slate-600">Dual Hermetic Scroll</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">25 – 55 m³/hr</td>
                    <td class="py-3 px-4 text-slate-600">65 – 68 dBA</td>
                    <td class="py-3 px-4 text-slate-600">Commercial retail, clinics, server rooms, small events, bakery cooling</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-blue-900">150 – 250 TR</td>
                    <td class="py-3 px-4 text-slate-600">Semi-Hermetic Screw</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">80 – 135 m³/hr</td>
                    <td class="py-3 px-4 text-slate-600">68 – 72 dBA</td>
                    <td class="py-3 px-4 text-slate-600">Hotel air conditioning backup, mid-rise towers, hospital outpatient wings</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-blue-900">300 – 500 TR</td>
                    <td class="py-3 px-4 text-slate-600">Twin VFD Screw</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">160 – 270 m³/hr</td>
                    <td class="py-3 px-4 text-slate-600">72 – 74 dBA</td>
                    <td class="py-3 px-4 text-slate-600">District cooling augmentation, concrete batching plants, manufacturing</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-blue-900">600 – 1000 TR</td>
                    <td class="py-3 px-4 text-slate-600">Multi-Compressor Screw</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">320 – 540 m³/hr</td>
                    <td class="py-3 px-4 text-slate-600">74 – 77 dBA</td>
                    <td class="py-3 px-4 text-slate-600">Refinery turnarounds, petrochemical shutdowns, power generation stations</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-blue-900">1000 – 1500 TR+</td>
                    <td class="py-3 px-4 text-slate-600">Synchronized Containerized</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">540 – 810 m³/hr</td>
                    <td class="py-3 px-4 text-slate-600">Acoustic 75 dBA</td>
                    <td class="py-3 px-4 text-slate-600">Utility district cooling emergency bridge, mega-events (DWTC, Expo City)</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Air-Cooled vs. Water-Cooled Rental Chillers in the UAE</h2>
    <p class="text-sm text-slate-600 leading-relaxed">
        Selecting the correct chiller architecture depends on site footprint, water availability, and project timeline:
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6">
        <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs space-y-3">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                <span>Air-Cooled Rental Chillers (Most Popular)</span>
            </h3>
            <ul class="space-y-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> 100% dry operation requiring zero external cooling water or makeup tanks.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Plug-and-play installation; can be fully operational within 2 hours of arrival.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Desert-engineered with Blygold hydrophilic coating to withstand coastal Gulf salt spray.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Ideal for rooftop installations, parking lots, and emergency commercial building backups.</li>
            </ul>
        </div>
        <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs space-y-3">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-cyan-600"></span>
                <span>Water-Cooled Rental Chillers (High Efficiency)</span>
            </h3>
            <ul class="space-y-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Highest energy efficiency (kW/TR) for long-term multi-month industrial deployments.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Compact footprint per cooling ton, ideal where ground space is severely constrained.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Can integrate with existing cooling towers or modular rental cooling tower packages.</li>
                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Preferred for district cooling central plants, basements, and maritime dry docks.</li>
            </ul>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Turnkey Ancillaries Included with Every Rental Package</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-6">
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Flexible Chilled Water Hoses</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Food-grade, reinforced EPDM rubber flexible hoses rated for 16 Bar (PN16) with quick-connect Bauer or Cam-Lock aluminium couplings in 2", 4", 6", and 8" diameters.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Secondary Dual-Pump Skids</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Skid-mounted duty/standby variable speed pumps with integrated isolation valves, strainers, and digital pressure differential gauges to guarantee required building delta-P.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Plate Heat Exchangers (PHE)</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Certified stainless steel plate heat exchangers that isolate rental cooling loops from permanent building circuits, preventing cross-contamination or glycol dilution.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Frequently Asked Questions: Rental Cooling in UAE</h2>
    <div class="space-y-4 my-6">
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>What is the cost of renting a commercial chiller in Dubai and the UAE?</span>
                <span class="text-blue-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Chiller rental rates depend on required tonnage (TR), duration of the hire (daily emergency, weekly, or discounted monthly/seasonal contracts), piping distance, and secondary pump requirements. Long-term monthly contracts include complete 24/7 preventive maintenance, chemical water treatment checks, remote telemetry, and round-the-clock emergency replacement guarantees. Contact our engineering team for an itemized proposal within 15 minutes.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>How fast can you deliver an emergency chiller to our site in Dubai or Abu Dhabi?</span>
                <span class="text-blue-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                For emergency cooling breakdowns in Dubai, Abu Dhabi, and Sharjah, our pre-rigged mobile chiller fleet can be dispatched to your site within 60 to 120 minutes. Our certified rigging and HVAC technicians handle crane placement, cam-lock hose connection, hydraulic pressure testing, and flow balancing for same-day cooling restoration.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>What electrical power supply is required for rental chillers?</span>
                <span class="text-blue-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                All our chillers operate on standard UAE 380V – 415V, 3-Phase, 50 Hz power supply. If your facility does not have sufficient spare electrical capacity on your main distribution board, HVAC Clinic provides synchronized temporary diesel generators (50 kVA to 1500 kVA), cabling, and fuel tanks as a single turnkey package.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Can rental chillers achieve low-temperature glycol cooling for industrial processes?</span>
                <span class="text-blue-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. While standard HVAC comfort cooling produces chilled water at 6°C to 12°C, our specialized process chillers can be charged with food-grade polypropylene or ethylene glycol to deliver sub-zero leaving fluid temperatures down to -10°C, tailored for concrete batching, chemical jacket cooling, cold storage, and food manufacturing.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Do your chillers comply with Dubai Municipality, DEWA, and Estidama standards?</span>
                <span class="text-blue-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. All equipment in our rental cooling inventory is AHRI certified, utilizes non-ozone-depleting refrigerants, and features acoustic attenuation compliant with Dubai Municipality residential and commercial noise regulations (under 72 dBA at 10 meters).
            </div>
        </details>
    </div>
</div>
HTML,
    ],

    // 2. Rental AC
    [
        'title' => 'Rental AC',
        'slug' => 'rental-ac-in-uae',
        'tagline' => 'Commercial Rental AC & Spot Cooler Hire in UAE | 5 to 50 TR Packaged Units & Portable Climate Control',
        'hero_badge' => '5 to 50 TR Packaged & Spot Cooler Fleet • Plug-and-Play Quick Setup • 24/7 Rapid Mobilization',
        'icon' => 'wind',
        'summary' => 'Comprehensive commercial air conditioner rental across Dubai, Abu Dhabi, and the UAE. Packaged rooftop units, floor-standing tower ACs, portable spot coolers, and modular flexible ducting for events, warehouses, server rooms, and construction fit-outs.',
        'focus_keyword' => 'rental ac in uae',
        'meta_title' => 'Commercial Rental AC & Spot Coolers in UAE (5-50 TR) | HVAC Clinic',
        'meta_description' => 'Rent commercial air conditioning units in Dubai, Abu Dhabi & Sharjah. 5 to 50 TR packaged AC, portable spot coolers, flexible ducting & 24/7 fast setup.',
        'meta_keywords' => 'rental ac in uae, portable ac rental dubai, commercial ac rental sharjah, spot cooler rental abu dhabi, event ac hire dubai, package unit ac rental uae, warehouse air conditioning rental',
        'featured_image' => '/wp-content/uploads/2026/03/hvac.gif',
        'order' => 2,
        'is_featured' => true,
        'features' => [
            'Capacity Fleet Range: 1 TR to 50 TR Modular Packaged Air Conditioners and Portable Spot Coolers',
            'Heavy-Duty Commercial Scroll Compressors Built for 54°C Ambient UAE Summer Heat Waves',
            'Modular Flexible Air Ducting (Insulated Spiral Canvas & Lay-Flat Plastic Ducts up to 50 meters)',
            'Plug-and-Play Quick Electrical Hookup: Single-Phase 220V (1–5 TR) and Three-Phase 415V (10–50 TR)',
            'Integrated High-Lift Condensate Evacuation Pumps & Washable High-Efficiency G4 Dust Filters',
            'Low-Noise Acoustic Centrifugal Blowers (Under 62 dBA for VIP Corporate Events & Exhibitions)',
        ],
        'benefits' => [
            'Instant Rapid Climate Relief: Plug-and-play spot coolers operational in under 15 minutes from site delivery',
            'Full Turnkey Event Logistics: Free site layout planning, power distribution, and duct balancing across Dubai & Abu Dhabi',
            'Zero Maintenance Worries: 100% replacement guarantee with 24/7 on-call certified HVAC service technicians',
            'High Energy Efficiency: Modern inverter and multi-stage compressor technology reduces fuel and electricity usage',
        ],
        'benchmarks' => [
            'standard' => 'ISO 9001:2015 & CE Certified Fleet',
            'evaluation' => 'Free Site CFM & Heat Load Calculation',
            'guarantee' => '100% Operational Uptime & Instant Swap Warranty',
            'turnaround' => 'Under 60 Minutes Rapid Mobilization in Dubai',
            'support' => '24/7 Standby HVAC Technicians & Duct Specialists',
        ],
        'content' => <<<'HTML'
<div class="space-y-8 text-slate-700">
    <p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal">
        At <strong>HVAC Clinic</strong>, we provide professional <strong>commercial air conditioner rental and portable spot cooling across Dubai, Abu Dhabi, Sharjah, and all Emirates</strong>. Whether you need emergency cooling for an overheated data center, climate control for a temporary exhibition tent at Dubai World Trade Centre, or supplementary cooling for a warehouse in JAFZA, our versatile fleet of <strong>5 TR to 50 TR packaged AC units and portable spot coolers</strong> delivers instant, high-velocity chilled airflow.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
        <div class="p-6 rounded-2xl bg-sky-50/70 border border-sky-200/80 space-y-3">
            <div class="flex items-center gap-2 text-sky-900 font-bold text-sm">
                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Complete Air Distribution Packages</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Every rental package includes certified heavy-duty power cables, insulated flexible spiral air ducting, supply air diffusers, return air plenums, and automatic condensate removal pumps for hassle-free 24/7 continuous operation.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Same-Day Rapid Dispatch & Setup</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                With regional equipment hubs throughout the UAE, our specialized technicians deliver and commission packaged cooling systems within hours, minimizing business disruption and protecting critical operations.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Rental AC Fleet Sizing & Technical Specifications</h2>
    <p class="text-sm text-slate-600 leading-relaxed">
        Our commercial AC rental fleet is categorized by application and cooling capacity to match exact project requirements:
    </p>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 my-6 shadow-xs">
        <table class="w-full text-left text-xs sm:text-sm">
            <thead class="bg-slate-900 text-white font-bold uppercase text-[11px] tracking-wider">
                <tr>
                    <th class="py-3.5 px-4">Model Class</th>
                    <th class="py-3.5 px-4">Cooling Capacity</th>
                    <th class="py-3.5 px-4">Airflow (CFM)</th>
                    <th class="py-3.5 px-4">Power Requirement</th>
                    <th class="py-3.5 px-4">Ideal Site Applications</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-sky-900">Portable Spot Cooler</td>
                    <td class="py-3 px-4 text-slate-600">1 – 3 TR (12k–36k BTU)</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">450 – 1,100 CFM</td>
                    <td class="py-3 px-4 text-slate-600">220V Single-Phase (13A/16A)</td>
                    <td class="py-3 px-4 text-slate-600">Server rooms, retail shops, executive cabins, production lines</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-sky-900">Floor-Standing Commercial AC</td>
                    <td class="py-3 px-4 text-slate-600">5 – 10 TR (60k–120k BTU)</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">2,000 – 3,800 CFM</td>
                    <td class="py-3 px-4 text-slate-600">415V Three-Phase (16A/32A)</td>
                    <td class="py-3 px-4 text-slate-600">Workshops, showrooms, restaurants, wedding halls, site camps</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-sky-900">Ducted Rooftop Package Unit</td>
                    <td class="py-3 px-4 text-slate-600">15 – 30 TR (180k–360k BTU)</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">6,000 – 12,000 CFM</td>
                    <td class="py-3 px-4 text-slate-600">415V Three-Phase (63A)</td>
                    <td class="py-3 px-4 text-slate-600">Temporary warehouses, industrial fit-outs, manufacturing plants</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-sky-900">Heavy-Duty Event Climate Pack</td>
                    <td class="py-3 px-4 text-slate-600">40 – 50 TR (480k–600k BTU)</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">16,000 – 20,000 CFM</td>
                    <td class="py-3 px-4 text-slate-600">415V Three-Phase (125A)</td>
                    <td class="py-3 px-4 text-slate-600">Mega exhibition domes, sports arenas, outdoor desert festivals</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Why UAE Events & Industrial Contractors Choose HVAC Clinic</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6">
        <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs space-y-3">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-sky-500"></span>
                <span>Events, Exhibitions & VIP Tents</span>
            </h3>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                We specialize in silent, aesthetic climate control for high-profile gatherings across the UAE. Our ultra-quiet packaged units are positioned outside the venue with color-matched internal flexible ducting or under-floor distribution to deliver whisper-quiet comfort without visual clutter.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs space-y-3">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                <span>Data Center & Server Room Contingency</span>
            </h3>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                When precision CRAC or in-row units trip in IT server rooms, temperatures can skyrocket past critical thresholds within 10 minutes. Our portable spot coolers roll through standard commercial doorways and plug into standard electrical sockets for instant emergency heat extraction.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Frequently Asked Questions: Commercial Rental AC</h2>
    <div class="space-y-4 my-6">
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>How many tons of rental AC do I need for a temporary event tent?</span>
                <span class="text-sky-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                In UAE peak summer, outdoor tents require approximately 1 TR of cooling per 8 to 12 square meters (depending on fabric insulation, occupancy, lighting, and solar exposure). For example, a 500 m² event tent typically requires 40 to 60 TR of packaged air conditioning. Our HVAC engineers provide complimentary on-site heat load calculations to size the exact capacity required.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Can rental AC units be installed inside an office without ducting outside?</span>
                <span class="text-sky-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                All air conditioning systems extract heat and must discharge warm condenser exhaust air. Portable spot coolers feature flexible exhaust ducts that can be vented through drop ceilings, sliding windows, or adjacent unoccupied spaces. For larger areas, packaged units sit outdoors and deliver cooled air inside via supply ducting.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Do you supply generator power with rental air conditioners?</span>
                <span class="text-sky-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. If your event venue or construction site lacks sufficient electrical power, HVAC Clinic provides synchronized silent diesel generators (50 kVA to 1500 kVA), distribution panels, fuel tanks, and ADNOC diesel management as a combined turnkey package.
            </div>
        </details>
    </div>
</div>
HTML,
    ],

    // 3. Wild Air Rental
    [
        'title' => 'Wild Air Rental',
        'slug' => 'wild-air-rental-in-uae',
        'tagline' => 'Wild Air Rental & Construction Fit-Out Climate Solutions in UAE | Temporary High-CFM Space Conditioning',
        'hero_badge' => 'High-CFM Fit-Out Cooling • Active Moisture Control • OSHA Heat Stress Compliant',
        'icon' => 'fan',
        'summary' => 'Specialized temporary climate control and wild air cooling solutions for construction projects, interior fit-outs, and MEP pre-commissioning across the UAE. Protects delicate architectural finishes, gypsum, and parquet flooring from warping in extreme summer heat.',
        'focus_keyword' => 'wild air rental in uae',
        'meta_title' => 'Wild Air Rental & Construction Cooling UAE | HVAC Clinic',
        'meta_description' => 'Temporary wild air cooling for fit-out contractors in Dubai, Abu Dhabi & UAE. High-velocity air handling, moisture extraction & MEP pre-commissioning.',
        'meta_keywords' => 'wild air rental in uae, wild air cooling dubai, temporary fit out cooling abu dhabi, construction climate control sharjah, gypsum drying cooling uae, parquet floor climate control dubai, temporary ahu rental',
        'featured_image' => '/wp-content/uploads/2026/03/g-2.jpg',
        'order' => 3,
        'is_featured' => true,
        'features' => [
            'High-Velocity Air Handling Units (AHUs) Delivering 5,000 to 45,000 CFM Airflow per Unit',
            'Integrated Low-Temperature Chiller & AHU Loops for Rapid Core Building Heat Extraction',
            'Active Dehumidification Packages Mitigating Relative Humidity Below 55% RH',
            'Multi-Stage High-Capacity Particulate Filtration (G4 & F7) Preventing Dust Infiltration',
            'Modular Multi-Story Temporary Riser Canvas Ducting Reaching up to 30 Floors',
            'Compliant with Dubai Municipality, Civil Defense, and Contractor Environmental Codes',
        ],
        'benefits' => [
            'Protects High-Value Fit-Outs: Prevents warping of expensive timber parquet, gypsum cracking, and paint bubbling',
            'Accelerates Project Handover: Facilitates rapid joint compound drying, epoxy curing, and MEP testing before district cooling hookup',
            'OSHA & Labour Safety Compliance: Reduces interior site temperatures from 48°C to a workable 24°C–28°C',
            'Flexible Turnkey Rental Terms: Daily, weekly, or multi-month contracts with 24/7 on-site technician monitoring',
        ],
        'benchmarks' => [
            'standard' => 'ASHRAE 55 & 62.1 Indoor Air Standards',
            'evaluation' => 'Comprehensive Fit-Out Humidity & CFM Audit',
            'guarantee' => 'Guaranteed Temperature & Humidity Band SLA',
            'turnaround' => 'Rapid Deployment Across All 7 Emirates',
            'support' => '24/7 Dedicated MEP Site Commissioning Support',
        ],
        'content' => <<<'HTML'
<div class="space-y-8 text-slate-700">
    <p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal">
        In the UAE construction and commercial fit-out industry, <strong>"Wild Air" (temporary space cooling and humidity control)</strong> is an indispensable engineering requirement. When luxury hotels, residential high-rises, shopping malls, and corporate headquarters undergo high-end interior finishes, permanent district cooling (such as Empower or Tabreed) is rarely energized until final civil defense and building completion certificates are issued. <strong>HVAC Clinic's Wild Air Rental solutions across Dubai, Abu Dhabi, and Sharjah</strong> bridge this critical gap, providing high-volume conditioned airflow to protect delicate materials and accelerate handover deadlines.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
        <div class="p-6 rounded-2xl bg-teal-50/70 border border-teal-200/80 space-y-3">
            <div class="flex items-center gap-2 text-teal-900 font-bold text-sm">
                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Protecting High-End Architectural Finishes</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Extreme ambient humidity (often exceeding 85% RH in summer) causes catastrophic warping of imported Italian hardwood floors, blistering of acoustic wall panels, sagging of ceiling gypsum tiles, and delamination of commercial wallpapers. Wild air maintains continuous climate stability.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Workforce Heat Stress Mitigation</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Complying with UAE Ministry of Human Resources mid-day working regulations, wild air cooling brings suffocating indoor temperatures down to a comfortable 24°C–28°C, boosting labor productivity by over 40% and preventing heat-related safety incidents.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">How Wild Air Cooling Systems Operate on High-Rise Sites</h2>
    <p class="text-sm text-slate-600 leading-relaxed">
        Our engineered wild air methodology uses a modular closed-loop hydraulic and air distribution architecture:
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-6">
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <div class="w-8 h-8 rounded-xl bg-teal-600 text-white font-black flex items-center justify-center text-sm">1</div>
            <h4 class="font-bold text-slate-900 text-sm">Ground Chiller Skid</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                A high-efficiency air-cooled rental chiller (100–500 TR) is positioned at ground or podium level, powered by temporary generator power or early-stage temporary site electricity.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <div class="w-8 h-8 rounded-xl bg-teal-600 text-white font-black flex items-center justify-center text-sm">2</div>
            <h4 class="font-bold text-slate-900 text-sm">Hydraulic Riser Lines</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Pre-insulated flexible rubber hoses (PN16) are run up elevator shafts, facade scaffolding, or stairwells to feed intermediate floor levels with cold chilled water.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <div class="w-8 h-8 rounded-xl bg-teal-600 text-white font-black flex items-center justify-center text-sm">3</div>
            <h4 class="font-bold text-slate-900 text-sm">Strategic AHU Distribution</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                High-CFM temporary Air Handling Units (AHUs) on target floors distribute conditioned, dehumidified, and filtered air through lay-flat canvas ducts across the entire floor plate.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Frequently Asked Questions: Wild Air Rental</h2>
    <div class="space-y-4 my-6">
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>At what stage of a fit-out project should wild air be energized?</span>
                <span class="text-teal-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Wild air should ideally be commissioned immediately after the building envelope (curtain wall glazing and external doors) is sealed, and before sensitive architectural materials—such as gypsum false ceilings, dry walling, natural timber doors, and wood parquet—are delivered to site.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Can wild air use the building's permanent ductwork?</span>
                <span class="text-teal-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                We strongly advise against using permanent building ductwork because construction dust (gypsum powder, silica, paint overspray) will contaminate internal insulation and require expensive duct re-cleaning before final handover. Instead, HVAC Clinic supplies dedicated temporary lay-flat canvas ducts that can be moved as fit-out milestones progress.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>What temperature and humidity levels can wild air achieve?</span>
                <span class="text-teal-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Under normal closed envelope conditions with ambient temperatures up to 48°C, our wild air packages reliably maintain internal conditions between 22°C to 26°C with relative humidity controlled between 45% and 55% RH, well within international architectural warranty standards.
            </div>
        </details>
    </div>
</div>
HTML,
    ],

    // 4. Chiller Maintenance
    [
        'title' => 'Chiller Maintenance',
        'slug' => 'chiller-maintenance-in-uae',
        'tagline' => 'Chiller Maintenance, Overhaul & 24/7 AMC in UAE | Certified Technicians for Trane, Carrier, York & Daikin',
        'hero_badge' => 'Certified OEM Technicians • Eddy Current & Laser Alignment • 24/7 Emergency Breakdown SLA',
        'icon' => 'wrench',
        'summary' => 'Comprehensive industrial and commercial chiller maintenance services across Dubai, Abu Dhabi, Sharjah, and the UAE. Annual Maintenance Contracts (AMC), emergency compressor overhauls, vibration analysis, eddy current tube inspection, and micro-channel coil cleaning.',
        'focus_keyword' => 'chiller maintenance in uae',
        'meta_title' => 'Chiller Maintenance, Repair & AMC in UAE | HVAC Clinic',
        'meta_description' => 'Certified chiller maintenance & repair in Dubai, Abu Dhabi & UAE. Comprehensive AMC, compressor overhauls, tube testing & 24/7 emergency response.',
        'meta_keywords' => 'chiller maintenance in uae, chiller repair dubai, chiller amc contracts abu dhabi, trane chiller maintenance sharjah, carrier chiller repair uae, york chiller overhaul dubai, eddy current tube testing uae',
        'featured_image' => '/wp-content/uploads/2026/03/g-2.jpg',
        'order' => 4,
        'is_featured' => true,
        'features' => [
            'Multi-Brand Factory Certified Technicians: Trane, Carrier, York (Johnson Controls), Daikin, SKM, and Dunham-Bush',
            'Full Screw & Centrifugal Compressor Overhauls: Bearing replacements, rotor balancing, and mechanical seal rebuilds',
            'Non-Destructive Testing (NDT): Eddy current inspection of copper condenser and evaporator heat exchanger tubes',
            'Laser Precision Shaft Alignment and Dynamic Frequency Vibration Analysis (ISO 10816 standards)',
            'Comprehensive EPA-Compliant Refrigerant Recovery, Deep Evacuation (Down to 500 Microns), and Moisture Purging',
            'Micro-Channel Aluminum and Copper-Fin High-Pressure Chemical Wash Restoring Heat Transfer Efficiency',
        ],
        'benefits' => [
            'Slashing Energy Consumption: Professional descaling and tube cleaning lowers chiller kW/TR consumption by up to 25%',
            'Zero Unscheduled Downtime: Predictive thermography and oil spectrometry catch electrical and mechanical faults before catastrophic failure',
            'Extended Asset Lifespan: Certified OEM procedures extend chiller operational life from 10–12 years to over 20+ years',
            '24/7 Rapid Emergency Response: Guaranteed on-site emergency technician arrival within 60 minutes across Dubai and Sharjah',
        ],
        'benchmarks' => [
            'standard' => 'ISO 9001:2015 & OHSAS 18001 Certified',
            'evaluation' => 'Complimentary 50-Point Chiller Health Check',
            'guarantee' => '100% Genuine OEM Replacement Spare Parts',
            'turnaround' => '60-Minute Emergency Breakdown Response SLA',
            'support' => 'Dedicated 24/7 Technical Support Desk & Spare Depot',
        ],
        'content' => <<<'HTML'
<div class="space-y-8 text-slate-700">
    <p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal">
        Operating chillers in the United Arab Emirates presents extraordinary mechanical challenges. Ambient summer heat reaching 50°C, airborne desert dust, coastal humidity, and elevated water hardness cause severe condenser fouling, scale build-up, and compressor stress. <strong>HVAC Clinic provides elite industrial and commercial chiller maintenance, emergency overhaul, and Annual Maintenance Contracts (AMC) across Dubai, Abu Dhabi, Sharjah, and all seven Emirates</strong>. Our factory-trained HVAC engineers optimize chiller reliability, reduce energy consumption, and guarantee continuous facility uptime.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
        <div class="p-6 rounded-2xl bg-indigo-50/70 border border-indigo-200/80 space-y-3">
            <div class="flex items-center gap-2 text-indigo-900 font-bold text-sm">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Predictive Condition Monitoring</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Rather than waiting for high-pressure trips, our certified technicians deploy infrared thermal imaging, laser shaft alignment, acoustic bearing analysis, and laboratory oil spectrometry to detect mechanical anomalies weeks before failure occurs.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Comprehensive Chiller AMC Packages</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Our tailored Annual Maintenance Contracts include quarterly scheduled overhauls, 24/7 unlimited emergency breakdown callouts, priority OEM spare parts stocking, and free backup rental chiller guarantees during major overhauls.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Comprehensive Scope of Chiller Maintenance Services</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-6">
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Compressor Overhaul & Rebuild</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Full mechanical rebuilding of screw, scroll, and centrifugal compressors: bearing replacements, clearance adjustments, dynamic rotor balancing, motor winding varnishing, and shaft seal refurbishment.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Eddy Current Tube Testing</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Non-destructive electromagnetic testing of internal copper condenser and evaporator tubes to detect pitting, wall thinning, erosion, and stress fractures, preventing catastrophic refrigerant-to-water cross-leaks.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Chemical Descaling & Washing</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Specialized inhibited chemical descaling of water-cooled shell-and-tube barrels, paired with high-pressure neutralizing wash of air-cooled aluminum micro-channel fins to restore factory heat transfer delta-T.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Supported OEM Chiller Brands Across the UAE</h2>
    <p class="text-sm text-slate-600 leading-relaxed">
        Our senior refrigeration engineers maintain direct technical competence and genuine spare parts supply chains for all leading global chiller manufacturers:
    </p>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 my-6">
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-center font-bold text-xs text-slate-800">Trane (RTAF, RTAC, RTHD)</div>
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-center font-bold text-xs text-slate-800">Carrier (30XA, 30XW, 19XR)</div>
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-center font-bold text-xs text-slate-800">York / JCI (YVAA, YVWA, YK)</div>
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-center font-bold text-xs text-slate-800">Daikin Applied (EWAD, EWAQ)</div>
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-center font-bold text-xs text-slate-800">Dunham-Bush (AVCX, WCFX)</div>
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-center font-bold text-xs text-slate-800">SKM Air Conditioning</div>
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-center font-bold text-xs text-slate-800">Clivet & Blue Star</div>
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-center font-bold text-xs text-slate-800">Smardt Oil-Free Magnetic</div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Frequently Asked Questions: Chiller Maintenance in UAE</h2>
    <div class="space-y-4 my-6">
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>What is included in an HVAC Clinic Chiller Annual Maintenance Contract (AMC)?</span>
                <span class="text-indigo-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Our standard AMC includes four comprehensive quarterly preventive services, monthly operational parameter logging, chemical coil cleaning, oil/acid testing, electrical tightening and contactor inspection, unlimited emergency breakdown callouts (24/7), guaranteed 60-minute response time, and detailed engineering health reports after each visit.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>How often should condenser coils be cleaned in Dubai?</span>
                <span class="text-indigo-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Due to extreme sandstorms and sticky coastal moisture in the UAE, air-cooled condenser coils should undergo high-pressure washing every 4 to 6 weeks during the summer peak (May to October), and quarterly during winter. Neglected coils cause discharge pressures to skyrocket, leading to high-pressure compressor trips and a 20% to 35% spike in DEWA electricity bills.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Do you supply temporary backup chillers if our chiller requires major overhaul?</span>
                <span class="text-indigo-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. Because HVAC Clinic operates one of the UAE's largest commercial rental chiller fleets, we provide immediate temporary cooling hookups during major compressor rebuilds or tube replacements, ensuring your building occupants or factory processes experience zero downtime.
            </div>
        </details>
    </div>
</div>
HTML,
    ],

    // 5. Rental Generator
    [
        'title' => 'Rental Generator',
        'slug' => 'generator-rental-in-uae',
        'tagline' => 'Commercial Diesel Generator Rental in UAE | 20 kVA to 2500 kVA Prime & Standby Silent Power Fleet',
        'hero_badge' => '20 kVA to 2500 kVA Diesel Generator Fleet • 52°C Desert Tropicalized • 60-120 Min UAE SLA',
        'icon' => 'zap',
        'summary' => 'Turnkey commercial diesel generator rental across Dubai, Abu Dhabi, Sharjah, and all Northern Emirates. Super silent acoustic canopy gensets powered by Cummins, Perkins, CAT, and Kohler with 24/7 emergency dispatch, bulk ADNOC fuel delivery, and complete cabling.',
        'focus_keyword' => 'generator rental in uae',
        'meta_title' => 'Commercial Diesel Generator Rental in UAE (20-2500 kVA) | HVAC Clinic',
        'meta_description' => 'Rent silent diesel generators in Dubai, Abu Dhabi & Sharjah. 20 kVA to 2500 kVA Cummins & Perkins gensets, fuel management, cables & 24/7 fast dispatch.',
        'meta_keywords' => 'generator rental in uae, diesel generator rental dubai, silent generator hire abu dhabi, commercial generator rental sharjah, emergency power rental uae, cummins generator rental dubai, cat generator hire uae',
        'featured_image' => '/wp-content/uploads/2026/03/hvac.gif',
        'order' => 5,
        'is_featured' => true,
        'features' => [
            'Capacity Fleet Range: 20 kVA to 2500 kVA (Single Silent Units and Multi-MW Synchronized Fleets)',
            'Tier-1 Factory Engine Fleets: Cummins (USA/UK), Perkins (UK), Caterpillar (CAT), and Kohler',
            'Super Silent Weatherproof Acoustic Canopies Attenuated to 65–72 dBA @ 7m for Urban & Event Sites',
            'Heavy-Duty 52°C Desert Tropicalized Radiators & Dual-Stage Washable Sand Filtration Systems',
            'Deep Sea Electronics (DSE 7320 / DSE 8610) Digital AMF Controllers with Auto-Sync & Remote Telemetry',
            'Complete Turnkey Auxiliaries: External Bunded Fuel Tanks (1,000L–10,000L), ATS Panels, and Flexible Cabling',
        ],
        'benefits' => [
            'Single-Source Power Package: Generator hire, ADNOC diesel tankers, rubber cabling, and certified operators',
            'Zero Capital Outlay: 100% operational expense with flexible daily, weekly, and deeply discounted monthly billing',
            'Load-Bank Tested Reliability: Every generator is verified under 100% full resistive load bank before dispatching',
            'Compliant with DEWA, ADDC & Civil Defense: 4-pole motorized breakers, spark arrestors, and certified grounding',
        ],
        'benchmarks' => [
            'standard' => 'ISO 8528-1:2018 & DEWA Certified Fleet',
            'evaluation' => 'Complimentary Site Load Audit & kVA Sizing',
            'guarantee' => '99.98% Continuous Electrical Uptime Guarantee',
            'turnaround' => '60 to 120 Minutes Emergency Site Dispatch SLA',
            'support' => '24/7 Mobile Mechanical & Electrical Engineers',
        ],
        'content' => <<<'HTML'
<div class="space-y-8 text-slate-700">
    <p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal">
        At <strong>HVAC Clinic</strong>, we provide engineered, turnkey <strong>diesel generator rental solutions across Dubai, Abu Dhabi, Sharjah, and all seven Emirates</strong>. Whether you require prime continuous power for off-grid infrastructure, peak-shaving for industrial manufacturing, or standby emergency backup for critical healthcare and hospitality facilities, our modern fleet spans <strong>20 kVA to 2500 kVA</strong>. Every unit is packaged in heavy-duty sound-attenuated acoustic canopies or ISO containers engineered specifically to operate reliably at extreme UAE ambient temperatures exceeding <strong>50°C</strong>.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
        <div class="p-6 rounded-2xl bg-amber-50/70 border border-amber-200/80 space-y-3">
            <div class="flex items-center gap-2 text-amber-900 font-bold text-sm">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Complete Turnkey Power Ecosystem</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                We eliminate multi-vendor friction by providing single-source accountability: generator hire, double-walled external fuel tanks (1,000L to 10,000L), scheduled ADNOC ultra-low-sulfur diesel logistics, flexible rubber H07RN-F power cabling, automatic transfer switches (ATS), and certified operators.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Rapid Mobilization (60–120 Minutes)</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Operating regional depot yards across Al Quoz (Dubai), Musaffah (Abu Dhabi), and Industrial Area 13 (Sharjah), our heavy-duty crane hiab trucks and mobile technicians guarantee rapid dispatch and same-day commissioning across all UAE sites.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Diesel Generator Rental Fleet by Capacity Range</h2>
    <div class="overflow-x-auto rounded-2xl border border-slate-200 my-6 shadow-xs">
        <table class="w-full text-left text-xs sm:text-sm">
            <thead class="bg-slate-900 text-white font-bold uppercase text-[11px] tracking-wider">
                <tr>
                    <th class="py-3.5 px-4">kVA Band</th>
                    <th class="py-3.5 px-4">Engine Partners</th>
                    <th class="py-3.5 px-4">Fuel Burn (75% Load)</th>
                    <th class="py-3.5 px-4">Noise (dBA @ 7m)</th>
                    <th class="py-3.5 px-4">Typical UAE Site Applications</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-amber-900">20 – 60 kVA</td>
                    <td class="py-3 px-4 text-slate-600">Perkins 404D / Cummins X2.5</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">5 – 14 L/hr</td>
                    <td class="py-3 px-4 text-slate-600">65 – 68 dBA</td>
                    <td class="py-3 px-4 text-slate-600">Site offices, dewatering pumps, retail pop-ups, security gates</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-amber-900">60 – 150 kVA</td>
                    <td class="py-3 px-4 text-slate-600">Perkins 1104 / Cummins 6BT</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">14 – 33 L/hr</td>
                    <td class="py-3 px-4 text-slate-600">68 – 70 dBA</td>
                    <td class="py-3 px-4 text-slate-600">Mid-size civil construction, tower cranes, clinics, batching plants</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-amber-900">150 – 350 kVA</td>
                    <td class="py-3 px-4 text-slate-600">Perkins 1506 / Cummins QSL9</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">33 – 75 L/hr</td>
                    <td class="py-3 px-4 text-slate-600">70 – 72 dBA</td>
                    <td class="py-3 px-4 text-slate-600">Commercial towers, event arenas, manufacturing, hospital backup</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-amber-900">350 – 750 kVA</td>
                    <td class="py-3 px-4 text-slate-600">Cummins QSX15 / Perkins 2806</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">75 – 160 L/hr</td>
                    <td class="py-3 px-4 text-slate-600">72 – 75 dBA</td>
                    <td class="py-3 px-4 text-slate-600">Heavy industrial dewatering, asphalt plants, marine drydocks</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-amber-900">750 – 1250 kVA</td>
                    <td class="py-3 px-4 text-slate-600">Cummins QST30 / Perkins 4008</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">160 – 260 L/hr</td>
                    <td class="py-3 px-4 text-slate-600">75 – 78 dBA</td>
                    <td class="py-3 px-4 text-slate-600">District cooling chillers, utility shutdowns, data center testing</td>
                </tr>
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-amber-900">1250 – 2500 kVA+</td>
                    <td class="py-3 px-4 text-slate-600">Cummins QSK60 / CAT 3516</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">260 – 520 L/hr</td>
                    <td class="py-3 px-4 text-slate-600">Containerized 75 dBA</td>
                    <td class="py-3 px-4 text-slate-600">Multi-MW synchronized temporary power plants, refinery turnarounds</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Turnkey Equipment Included With Every Generator Rental</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-6">
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Bunded Fuel Storage Tanks</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Integrated base tanks plus external 1,000L to 10,000L double-walled bunded bulk fuel tanks equipped with electric transfer pumps and digital level gauges.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Flexible Rubber Power Cables</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                H07RN-F multi-core and single-core flexible copper power cables (up to 300 mm²) with terminal lugs, quick-connect cam-locks, and heavy-duty cable protective ramps.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">ATS & Synchronization Panels</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Automatic Transfer Switches (ATS) with 4-pole motorized ABB or Schneider circuit breakers for seamless utility grid-to-generator changeover in under 10 seconds.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Frequently Asked Questions: Generator Rental in UAE</h2>
    <div class="space-y-4 my-6">
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>What is the cost of renting a diesel generator in Dubai and the UAE?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Rental rates depend on the kVA capacity, hire duration (daily, weekly, or monthly contract), fuel management requirements, and site location. Monthly rental packages offer substantial savings and include complete 250-hour scheduled oil and filter servicing, consumable top-ups, and 24/7 on-call emergency technician support. Contact our team for an itemized quote within 15 minutes.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>How quickly can you deliver and commission a rental generator to my site?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                For emergency breakdown situations in Dubai, Sharjah, and Abu Dhabi, our mobilized fleet can arrive on site within 60 to 120 minutes. For scheduled project setups, we provide complete site delivery, cable termination, earth-rod grounding, and load testing within 4 to 24 hours of contract approval.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Do your rental generators comply with DEWA, ADDC, and Civil Defense standards?</span>
                <span class="text-amber-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. All generators in our fleet are certified to ISO 8528 standards and equipped with 4-pole circuit breakers, integrated emergency stop buttons, spark arrestors, and certified electrical grounding rods complying strictly with DEWA (Dubai Electricity & Water Authority) and ADDC (Abu Dhabi Distribution Company) contractor safety codes.
            </div>
        </details>
    </div>
</div>
HTML,
    ],

    // 6. Rental Power
    [
        'title' => 'Rental Power',
        'slug' => 'generator-maintenance-repair-in-uae',
        'tagline' => 'Turnkey Temporary Power Plants, Transformers & Electrical Distribution in UAE | Multi-MW Synchronization',
        'hero_badge' => 'Synchronized Multi-MW Power Plants • High Voltage Transformers • Turnkey Electrical Distribution',
        'icon' => 'plug',
        'summary' => 'Comprehensive temporary power generation, high-voltage distribution, and electrical engineering solutions across the UAE. Synchronized power plants up to 50 MW, step-up transformers (11kV / 33kV), distribution switchboards, and 24/7 fuel management.',
        'focus_keyword' => 'rental power uae',
        'meta_title' => 'Temporary Rental Power & Distribution Plants in UAE | HVAC Clinic',
        'meta_description' => 'Multi-MW synchronized temporary power plants, step-up transformers (11kV/33kV), distribution panels & turnkey power hire across Dubai, Abu Dhabi & UAE.',
        'meta_keywords' => 'rental power uae, temporary power rental dubai, multi mw power plant hire abu dhabi, step up transformer rental uae, temporary electrical distribution dubai, deep sea synchronization uae',
        'featured_image' => '/wp-content/uploads/2026/03/hvac.gif',
        'order' => 6,
        'is_featured' => true,
        'features' => [
            'Multi-Megawatt Temporary Power Plants Engineered from 1 MW to 50 MW Synchronized Capacities',
            'Step-Up & Step-Down Oil-Immersed Transformers (415V to 11kV, 22kV, and 33kV Grid Connections)',
            'Digital Automatic Load Sharing & Peak Shaving with Deep Sea DSE 8610 Multi-Set Synchronizers',
            'Full Turnkey Fuel Infrastructure: Bulk Fuel Storage Farms (up to 100,000L) with Automated Telemetry',
            'Heavy-Duty Medium & Low Voltage Switchgear with Motorized Air Circuit Breakers (ACB / MCCB)',
            'Turnkey High-Current Cable Management: Flexible H07RN-F Rubber Lines, Trenching & Heavy-Duty Ramps',
        ],
        'benefits' => [
            'N+1 & N+2 Redundancy Architectures: Continuous uninterrupted power even during single-engine servicing',
            'High-Voltage Grid Support: Direct connection to utility substation buses during scheduled maintenance shutdowns',
            'Zero Downtime Guarantee: Round-the-clock on-site electrical engineers, switchgear operators, and fuel technicians',
            'Certified DEWA & ADDC Compliance: Full protection relay coordination, earth leakage, and third-party inspection reports',
        ],
        'benchmarks' => [
            'standard' => 'IEC 60076 & IEEE 519 Power Quality Standards',
            'evaluation' => 'Comprehensive Short-Circuit & Harmonic Study',
            'guarantee' => '99.99% Continuous Grid-Scale Uptime SLA',
            'turnaround' => 'Rapid Modular Deployment Across the GCC',
            'support' => '24/7 Dedicated Power Station Operators & Engineers',
        ],
        'content' => <<<'HTML'
<div class="space-y-8 text-slate-700">
    <p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal">
        When major industrial projects, utility substations, island developments, and mining concessions require massive, grid-scale electricity without waiting years for permanent utility energization, <strong>HVAC Clinic delivers turnkey Rental Power plants and temporary electrical distribution infrastructure across the UAE</strong>. Spanning <strong>1 MW to 50 MW synchronized temporary power stations</strong>, high-voltage step-up transformers (11kV / 22kV / 33kV), and complete fuel logistics, our engineered power packages guarantee uninterrupted electricity under the most demanding environmental conditions.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
        <div class="p-6 rounded-2xl bg-orange-50/70 border border-orange-200/80 space-y-3">
            <div class="flex items-center gap-2 text-orange-900 font-bold text-sm">
                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Synchronized Multi-Megawatt Power</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Utilizing digital Deep Sea DSE 8610 controllers, our containerized generators automatically synchronize onto a common busbar, dynamically adding or shedding sets based on instantaneous site load to maximize fuel economy.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>High-Voltage Step-Up Substations</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Our fleet includes oil-immersed step-up transformers transforming low-voltage 415V generation up to 11,000V (11kV) and 33,000V (33kV), enabling low-loss transmission over kilometers to remote industrial sites.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Turnkey Power Plant Engineering & Auxiliary Fleet</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-6">
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Bulk Fuel Management Farms</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Automated ISO containerized bulk fuel storage farms (up to 100,000 Liters) with redundant fuel polishing filtration, digital flow meters, and scheduled ADNOC tanker logistics.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Medium-Voltage Switchgear</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Pre-commissioned 11kV/33kV vacuum circuit breaker (VCB) kiosks with digital protection relays (overcurrent, earth fault, differential), certified to international utility standards.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Resistive & Reactive Load Banks</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Trailer-mounted mobile load banks (up to 3000 kW / 0.8 PF) for electrical commissioning, data center factory acceptance testing (FAT), and continuous generator de-carbonization.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Frequently Asked Questions: Temporary Rental Power</h2>
    <div class="space-y-4 my-6">
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>How does generator load-sharing and synchronization work?</span>
                <span class="text-orange-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Our generators communicate over high-speed CANbus networks via Deep Sea controllers. The system automatically matches voltage, frequency, and phase angle before closing motorized breakers. When site power demand increases, additional generators start and ramp up automatically; when load drops, idle units safely shut down to conserve fuel.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Can your rental power systems connect directly into DEWA or ADDC substations?</span>
                <span class="text-orange-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Yes. We regularly supply temporary power plants to bridge utility substation turnarounds. Our systems include compliant 11kV/33kV switchgear, protection relays, sync check relays, and neutral grounding resistors (NGR) matching local utility authority grid connection codes.
            </div>
        </details>
    </div>
</div>
HTML,
    ],

    // 7. Used & Refurbished Equipment
    [
        'title' => 'Used & Refurbished',
        'slug' => 'used-refurbished-equipment-in-uae',
        'tagline' => 'Certified Used & Refurbished Chillers & Generators in UAE | 100% Load-Bank Tested with Warranty',
        'hero_badge' => 'Pre-Owned Chillers & Generators • 100% Load-Bank Certified • 6-12 Month Warranty Included',
        'icon' => 'refresh-cw',
        'summary' => 'Premium certified pre-owned and refurbished industrial chillers (Trane, Carrier, York, Daikin) and diesel generators (Cummins, CAT, Perkins) for sale or buyout across the UAE. Complete 100-point inspection, full load-bank testing, warranty, and cash buyout for old equipment.',
        'focus_keyword' => 'used refurbished equipment in uae',
        'meta_title' => 'Used & Refurbished Chillers & Generators in UAE | HVAC Clinic',
        'meta_description' => 'Buy or sell used chillers and diesel generators in Dubai, Abu Dhabi & UAE. 100% load tested, refurbished Trane, Carrier & Cummins with warranty.',
        'meta_keywords' => 'used refurbished equipment in uae, used chiller for sale dubai, refurbished chiller uae, used generator for sale dubai, sell old chiller dubai, pre owned generator sharjah, buy used trane chiller uae',
        'featured_image' => '/wp-content/uploads/2026/03/g-2.jpg',
        'order' => 7,
        'is_featured' => true,
        'features' => [
            'Comprehensive 100-Point Mechanical & Electrical Overhaul Protocol for Every Pre-Owned Unit',
            'Full Full-Load Testing on Certified Resistive Load Banks with Verifiable kW/TR Performance Reports',
            'Reconditioned Compressors & Factory-Approved Rewound Alternators with Class H Insulation',
            '6 to 12-Month Operational Warranty on Major Components (Compressors, Engines, and Alternators)',
            'Instant Cash Buyout & Trade-In for Decommissioned Plant Chillers, Boilers, and Generators',
            'Turnkey Turnkey Logistics: Crane Rigging, Heavy Transport, and Installation Support Across the GCC',
        ],
        'benefits' => [
            'Tremendous Cost Savings: Premium tier-1 OEM equipment available at 40% to 60% below new factory purchase prices',
            'Zero Factory Lead Times: Immediate dispatch and installation versus 24–36 week manufacturer factory delays',
            'Guaranteed Verified Performance: We provide complete eddy current reports, oil spectrometry, and load-test logs',
            'Cash Offers for Surplus Assets: Turn decommissioned equipment into immediate working capital with free crane extraction',
        ],
        'benchmarks' => [
            'standard' => '100% Full Load-Bank Performance Certified',
            'evaluation' => 'Comprehensive 100-Point Diagnostic Inspection',
            'guarantee' => '6 to 12-Month Operational Warranty Included',
            'turnaround' => 'Immediate Stock Dispatch Across All 7 Emirates',
            'support' => 'Complete Spare Parts Availability & AMC Support',
        ],
        'content' => <<<'HTML'
<div class="space-y-8 text-slate-700">
    <p class="text-base sm:text-lg text-slate-700 leading-relaxed font-normal">
        Procuring brand-new industrial chillers and heavy-duty diesel generators often entails prohibitive capital expenditures and factory lead times exceeding 6 to 9 months. <strong>HVAC Clinic provides certified, fully refurbished pre-owned chillers and diesel generators across Dubai, Abu Dhabi, Sharjah, and all seven Emirates</strong>. Every piece of equipment in our inventory undergoes a rigorous <strong>100-point mechanical rebuild, deep chemical descaling, precision electrical testing, and 100% full-load certification</strong> backed by a comprehensive warranty.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
        <div class="p-6 rounded-2xl bg-emerald-50/70 border border-emerald-200/80 space-y-3">
            <div class="flex items-center gap-2 text-emerald-900 font-bold text-sm">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Save 40%–60% with Immediate Delivery</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Avoid OEM supply chain delays. Our certified pre-owned chillers (50 TR to 1000 TR) and diesel generators (50 kVA to 2000 kVA) are ready for immediate site mobilization, providing factory-grade cooling and power at a fraction of capital cost.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-sm">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Instant Cash Buyout for Your Old Assets</span>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                Upgrading your facility or decommissioning an old plant? HVAC Clinic offers instant cash purchases and trade-in valuations for your surplus chillers, cooling towers, and generators, handling crane rigging, piping detachment, and removal free of charge.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Our 100-Point Refurbishment & Verification Protocol</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-6">
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Compressor & Engine Overhaul</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Disassembly, rotor inspection, replacement of bearings and mechanical seals, new gaskets, valve replacement, and fresh synthetic compressor oil charge.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Coil & Tube Descaling</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Eddy current electromagnetic testing of heat exchanger tubes, chemical descaling of water barrels, pressure washing of condenser fins, and anti-corrosion coating.
            </p>
        </div>
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Full Resistive Load Testing</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
                Every unit is run at 100% full thermal or electrical load on our testing benches for 4 consecutive hours, logging delta-T, kW draw, and vibration metrics before release.
            </p>
        </div>
    </div>

    <h2 class="text-2xl font-black text-slate-900 font-display pt-4">Frequently Asked Questions: Used & Refurbished Equipment</h2>
    <div class="space-y-4 my-6">
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>What warranty is provided with refurbished chillers and generators?</span>
                <span class="text-emerald-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                All refurbished chillers and generators sold by HVAC Clinic include an official 6 to 12-month operational warranty covering major components including compressors, engines, and alternators. Extended multi-year maintenance service agreements are also available.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>Can I witness the load-test before purchasing?</span>
                <span class="text-emerald-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Absolutely. We encourage client engineers and third-party inspectors to attend live load-bank testing at our testing depot, where you can verify kW cooling output, water flow rate, electrical current balance, and sound levels in person.
            </div>
        </details>
        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                <span>How do you evaluate and purchase old chillers for cash?</span>
                <span class="text-emerald-600 font-bold group-open:rotate-180 transition-transform">&#9660;</span>
            </summary>
            <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                Our asset appraisal team visits your site within 24 hours of contact to inspect the equipment's brand, model, running hours, and condition. We issue a transparent cash offer, and upon agreement, our rigging team safely disconnects, cranes, and removes the equipment without disruption to your facility.
            </div>
        </details>
    </div>
</div>
HTML,
    ],
];

DB::transaction(function () use ($servicesData) {
    foreach ($servicesData as $data) {
        $service = Service::updateOrCreate(
            ['slug' => $data['slug']],
            $data
        );
        echo "[UPDATED/CREATED] Service: {$service->title} (Slug: {$service->slug}, ID: {$service->id})\n";
    }
});

echo "\nAll 7 Services successfully populated with deep, rankable, unique content!\n";
