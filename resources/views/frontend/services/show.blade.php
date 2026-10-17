@extends('layouts.app')

@section('seo_meta')
    <title>{{ $service->seo_title }}</title>
    <meta name="description" content="{{ $service->seo_description }}">
    @if($service->meta_keywords)
        <meta name="keywords" content="{{ $service->meta_keywords }}">
    @endif
    <link rel="canonical" href="{{ $service->canonical_url ?: route('service.show', $service->slug) }}">
    <meta name="robots" content="{{ $service->is_indexable ? 'index, follow' : 'noindex, nofollow' }}">
    <meta property="og:title" content="{{ $service->og_title ?: $service->seo_title }}">
    <meta property="og:description" content="{{ $service->og_description ?: $service->seo_description }}">
    <meta property="og:type" content="service">
    <meta property="og:url" content="{{ route('service.show', $service->slug) }}">
    @if($service->seo_image)
        <meta property="og:image" content="{{ $service->seo_image }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">

    <!-- Schema.org Service, Breadcrumbs & Dynamic FAQ Schema -->
    {!! \App\Services\SchemaGenerator::renderPrimary($service, fn() => \App\Services\SchemaGenerator::forService($service)) !!}
    {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::breadcrumbs([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Services', 'url' => route('service.index')],
        ['name' => $service->title, 'url' => route('service.show', $service->slug)],
    ])) !!}
    @if(!empty($service->faqs))
        {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::forFaqs($service->faqs)) !!}
    @endif
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen">

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-b from-slate-950 via-slate-900 to-slate-900 text-white pt-24 pb-20 overflow-hidden">
        <div class="absolute inset-0 opacity-15 pointer-events-none" style="background-image: radial-gradient(#38bdf8 1px, transparent 1px); background-size: 28px 28px;"></div>
        <div class="absolute -top-32 right-10 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-amber-400 transition">Home</a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-600"></i>
                <a href="{{ route('service.index') }}" class="hover:text-amber-400 transition">Services</a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-600"></i>
                <span class="text-amber-400 font-semibold">{{ $service->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-8">
                    @if($service->hero_badge)
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/15 text-blue-300 border border-blue-500/30 mb-6 backdrop-blur-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>{{ $service->hero_badge }}</span>
                        </div>
                    @else
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/15 text-blue-300 border border-blue-500/30 mb-6 backdrop-blur-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>TURNKEY HVAC & POWER SOLUTIONS • 24/7 UAE DISPATCH</span>
                        </div>
                    @endif

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black font-display tracking-tight leading-tight">
                        {{ $service->title }}
                    </h1>

                    @if($service->tagline)
                        <p class="mt-4 text-base sm:text-lg text-amber-300/90 font-medium font-sans">
                            {{ $service->tagline }}
                        </p>
                    @endif

                    <p class="mt-6 text-sm sm:text-base text-slate-300 leading-relaxed font-light">
                        {{ $service->summary }}
                    </p>

                    <!-- 4 Value Proposition Cards (Inspired by Reference) -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-8">
                        <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80 backdrop-blur-sm">
                            <div class="w-7 h-7 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center mb-2">
                                <i data-lucide="box" class="w-4 h-4"></i>
                            </div>
                            <div class="text-xs font-bold text-white">One Supplier</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Equipments, Pumps & Cabling</div>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80 backdrop-blur-sm">
                            <div class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center mb-2">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                            </div>
                            <div class="text-xs font-bold text-white">Itemized Quotes</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Zero Hidden Surcharges</div>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80 backdrop-blur-sm">
                            <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-2">
                                <i data-lucide="wrench" class="w-4 h-4"></i>
                            </div>
                            <div class="text-xs font-bold text-white">24/7 Engineers</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">On-Site Rapid Diagnostics</div>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80 backdrop-blur-sm">
                            <div class="w-7 h-7 rounded-lg bg-sky-500/20 text-sky-400 flex items-center justify-center mb-2">
                                <i data-lucide="truck" class="w-4 h-4"></i>
                            </div>
                            <div class="text-xs font-bold text-white">Rapid Dispatch</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">60–120 Min UAE SLA</div>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <a href="#quote-box" class="px-6 py-3.5 rounded-xl font-bold text-xs sm:text-sm bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 shadow-lg shadow-amber-500/20 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                            <span>Request Engineering Quote</span>
                            <i data-lucide="arrow-down" class="w-4 h-4"></i>
                        </a>
                        <a href="tel:+971503692131" class="px-6 py-3.5 rounded-xl font-bold text-xs sm:text-sm bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition flex items-center gap-2">
                            <i data-lucide="phone-call" class="w-4 h-4 text-amber-400"></i>
                            <span>24/7 Hotline: +971 50 369 2131</span>
                        </a>
                        <a href="https://wa.me/971503692131?text={{ urlencode('Hello HVAC Clinic, I need urgent pricing & availability for ' . $service->title) }}" target="_blank" class="px-5 py-3.5 rounded-xl font-bold text-xs sm:text-sm bg-emerald-600 hover:bg-emerald-500 text-white shadow-lg shadow-emerald-600/20 transition flex items-center gap-2">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            <span>WhatsApp</span>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-4">
                    @if($service->featured_image_url)
                        <div class="rounded-3xl overflow-hidden border border-slate-800 shadow-2xl bg-slate-800 aspect-[4/3] relative group">
                            <img src="{{ $service->featured_image_url }}" 
                                 alt="{{ $service->title }} in UAE" 
                                 width="800"
                                 height="600"
                                 loading="eager"
                                 fetchpriority="high"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute bottom-3 left-3 right-3 p-3 rounded-2xl bg-slate-950/85 backdrop-blur-md border border-white/10 text-xs text-white flex items-center justify-between">
                                <span class="font-bold">Verified UAE Fleet</span>
                                <span class="text-amber-400 font-semibold">AHRI & Eurovent Certified</span>
                            </div>
                        </div>
                    @else
                        <div class="p-8 rounded-3xl bg-slate-800/80 border border-slate-700/80 space-y-4">
                            <div class="w-12 h-12 rounded-2xl bg-blue-500/20 text-blue-400 flex items-center justify-center">
                                <i data-lucide="{{ $service->icon ?: 'snowflake' }}" class="w-6 h-6"></i>
                            </div>
                            <h4 class="text-base font-bold text-white font-display">Technical Highlights</h4>
                            <p class="text-xs text-slate-300 leading-relaxed">
                                Backed by 52°C desert-rated equipment, Blygold anti-corrosion marine coated coils, AHRI/Eurovent certification, and 24/7 on-call HVAC engineers across all 7 Emirates.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted OEM & Engineering Partners Bar -->
    <section class="py-6 bg-slate-900 border-y border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between gap-6 text-slate-400 text-xs font-semibold">
                <span class="text-slate-500 uppercase tracking-widest text-[11px]">Factory OEM Engineering Partners:</span>
                <span class="hover:text-blue-400 transition">Trane (USA)</span>
                <span class="hover:text-blue-400 transition">Carrier (USA)</span>
                <span class="hover:text-blue-400 transition">York by Johnson Controls</span>
                <span class="hover:text-blue-400 transition">Daikin Applied</span>
                <span class="hover:text-blue-400 transition">SKM Air Conditioning</span>
                <span class="hover:text-amber-400 transition">Cummins (USA/UK)</span>
                <span class="hover:text-amber-400 transition">Perkins (UK)</span>
                <span class="hover:text-amber-400 transition">Caterpillar (CAT)</span>
                <span class="hover:text-amber-400 transition">Deep Sea Electronics</span>
            </div>
        </div>
    </section>

    <!-- Equipment Sizing & Model Categories Grid (Contextual by Service Domain) -->
    @php
        $slug = $service->slug;
        $isCooling = in_array($slug, ['rental-cooling', 'rental-chiller-in-uae', 'temporary-cooling-in-uae']);
        $isAC = in_array($slug, ['rental-ac-in-uae', 'ac-maintenance-repair-uae']);
        $isWildAir = in_array($slug, ['wild-air-rental-in-uae']);
        $isMaintenance = in_array($slug, ['chiller-maintenance-in-uae']);
        $isGenerator = in_array($slug, ['generator-rental-in-uae', 'generator-maintenance-repair-in-uae', 'rental-power']);
        $isUsed = in_array($slug, ['used-refurbished-equipment-in-uae']);
    @endphp

    <section class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mb-12">
                <span class="text-xs font-bold uppercase tracking-widest text-blue-600">Fleet Sizing & Model Categories</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1 font-display">
                    Commercial & Industrial Sizing Matrix
                </h2>
                <p class="text-sm text-slate-600 mt-2">
                    Mobilized with complete turnkey accessories, high-pressure flexible hoses, pumps, and certified technicians across Dubai, Abu Dhabi, Sharjah, and Northern Emirates.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($isCooling)
                    <!-- 50 - 150 TR -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-blue-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-100 text-blue-800">50 – 150 TR</span>
                                <span class="text-[11px] text-slate-400 font-mono">175 – 525 kW</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition">Air-Cooled Scroll Chillers</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Compact footprint chillers with multi-scroll compressors, low noise fans, and integrated variable primary flow pumps for medium commercial facilities.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Refrigerant:</strong> R-410A / R-32 &bull; <strong>Couplings:</strong> 4" Bauer Quick-Cam
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-blue-700 hover:text-blue-800 flex items-center gap-1">
                                <span>Get Sizing Quote</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-600 font-semibold">Immediate Stock</span>
                        </div>
                    </div>

                    <!-- 200 - 400 TR -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-blue-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-100 text-blue-800">200 – 400 TR</span>
                                <span class="text-[11px] text-slate-400 font-mono">700 – 1,400 kW</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition">Heavy-Duty Screw Chillers</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Dual semi-hermetic screw compressors with stepless capacity control (10–100%) and heavy Blygold coil coating rated for 52°C UAE ambient.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Ambient:</strong> 52°C Continuous &bull; <strong>Couplings:</strong> 6" PN16 Flange / Bauer
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-blue-700 hover:text-blue-800 flex items-center gap-1">
                                <span>Get Sizing Quote</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-600 font-semibold">Immediate Stock</span>
                        </div>
                    </div>

                    <!-- 500 - 1000 TR -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-blue-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-100 text-blue-800">500 – 1000 TR</span>
                                <span class="text-[11px] text-slate-400 font-mono">1,750 – 3,500 kW</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition">Industrial Modular Chiller Plants</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                High-efficiency modular chiller assemblies engineered for district cooling supplements, hospitals, batching plants, and data center shutdowns.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Efficiency:</strong> AHRI 550/590 Compliant &bull; <strong>Couplings:</strong> 8" / 10" Flanged
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-blue-700 hover:text-blue-800 flex items-center gap-1">
                                <span>Get Sizing Quote</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-600 font-semibold">Immediate Stock</span>
                        </div>
                    </div>

                    <!-- 1,200 - 2,500+ TR Multi-Megawatt -->
                    <div class="p-6 rounded-3xl bg-blue-500/10 border border-blue-500/30 shadow-sm hover:shadow-md hover:border-blue-400 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-600 text-white">1,200 – 2,500+ TR</span>
                                <span class="text-[11px] text-blue-900 font-mono">Multi-MW Plant</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition">Synchronized Cooling Stations</h3>
                            <p class="text-xs text-slate-700 leading-relaxed">
                                Turnkey central temporary chiller plants with automated PLC master sequence staging, automated balancing valves, and N+1 redundancy.
                            </p>
                            <div class="text-[11px] text-blue-950 pt-2 border-t border-blue-200/60">
                                <strong>Redundancy:</strong> N+1 Continuous &bull; <strong>Uptime:</strong> 99.98% SLA
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-blue-200/60 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-blue-900 hover:text-blue-950 flex items-center gap-1">
                                <span>Request Multi-MW Design</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-700 font-bold">Turnkey</span>
                        </div>
                    </div>

                    <!-- Skid-Mounted Pump Stations -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-blue-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-200 text-slate-800">500 – 4,000 GPM</span>
                                <span class="text-[11px] text-slate-400 font-mono">VFD Driven</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition">Skid Hydronic Pumping Stations</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Dual-pump primary/secondary skids with duty/standby auto-transfer, suction strainers, check valves, and wireless pressure transducers.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Head:</strong> 25–45m TDH &bull; <strong>Control:</strong> Variable Frequency Drive
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-blue-700 hover:text-blue-800 flex items-center gap-1">
                                <span>View Pump Rig Details</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">In Stock</span>
                        </div>
                    </div>

                    <!-- Air Handling Units (AHUs) -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-blue-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-200 text-slate-800">5,000 – 35,000 CFM</span>
                                <span class="text-[11px] text-slate-400 font-mono">High-Static</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition">Rental Air Handling Units (AHU)</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Heavy-duty framed AHUs with chilled water cooling coils, multi-stage filtration (G4/F7/HEPA), and high-static plug fans for long duct runs.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Static:</strong> Up to 750 Pa &bull; <strong>Filtration:</strong> Pre-filter + Bag filters
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-blue-700 hover:text-blue-800 flex items-center gap-1">
                                <span>Explore AHU Solutions</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">In Stock</span>
                        </div>
                    </div>

                @elseif($isAC)
                    <!-- 5 - 10 TR Spot Coolers -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-blue-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-100 text-blue-800">5 – 10 TR</span>
                                <span class="text-[11px] text-slate-400 font-mono">Plug & Play</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition">Spot Coolers & Mobile Package Units</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Wheeled, heavy-ambient commercial portable ACs designed for server rooms, elevator machine rooms, switchgear cooling, and retail stores.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Voltage:</strong> 380-415V / 3Ph / 50Hz &bull; <strong>Duct:</strong> Dual flexible snouts
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-blue-700 hover:text-blue-800 flex items-center gap-1">
                                <span>Get Sizing Quote</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-600 font-semibold">Immediate Stock</span>
                        </div>
                    </div>

                    <!-- 15 - 25 TR Ducted Package Units -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-blue-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-100 text-blue-800">15 – 25 TR</span>
                                <span class="text-[11px] text-slate-400 font-mono">50–88 kW</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition">Ducted Commercial Package AC</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Robust skid-mounted package air conditioners with backward-curved centrifugal blowers, internal electrical protection, and high-ambient condensers.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Airflow:</strong> 6,000 – 10,000 CFM &bull; <strong>Application:</strong> Construction, Tents, Offices
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-blue-700 hover:text-blue-800 flex items-center gap-1">
                                <span>Get Sizing Quote</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-600 font-semibold">Immediate Stock</span>
                        </div>
                    </div>

                    <!-- 30 - 50 TR Heavy Industrial Rooftop Units -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-blue-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-100 text-blue-800">30 – 50 TR</span>
                                <span class="text-[11px] text-slate-400 font-mono">105–175 kW</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition">Industrial Rooftop & Skid AC</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                High-capacity DX packaged air conditioners for warehouse storage, temporary airport terminals, defense facilities, and large industrial structures.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Airflow:</strong> 12,000 – 20,000 CFM &bull; <strong>Duct Connections:</strong> 4x 500mm
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-blue-700 hover:text-blue-800 flex items-center gap-1">
                                <span>Get Sizing Quote</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-600 font-semibold">Immediate Stock</span>
                        </div>
                    </div>

                    <!-- Tent & Event HVAC Units -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-blue-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-200 text-slate-800">Events & VIP</span>
                                <span class="text-[11px] text-slate-400 font-mono">Ultra-Silent</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition">Acoustic Tent & Exhibition AC</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Low-noise packaged air conditioning systems engineered specifically for weddings, corporate exhibitions, VIP domes, and luxury outdoor hospitality.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Noise:</strong> <55 dBA &bull; <strong>Distribution:</strong> Fabric duct socks / Underfloor
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-blue-700 hover:text-blue-800 flex items-center gap-1">
                                <span>Explore Event Packages</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">In Stock</span>
                        </div>
                    </div>

                    <!-- 100% Fresh Air Handling Packaged Units (FAHU) -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-blue-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-200 text-slate-800">100% Fresh Air</span>
                                <span class="text-[11px] text-slate-400 font-mono">Heat Recovery</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition">Treated Fresh Air Units (TFA/FAHU)</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Dedicated fresh air cooling with enthalpy recovery wheels, deep dehumidification cooling coils, and active condensate disposal systems.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Dehumidification:</strong> 48°C DB / 32°C WB &bull; <strong>Compliance:</strong> Dubai Green Building
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-blue-700 hover:text-blue-800 flex items-center gap-1">
                                <span>View Fresh Air Solutions</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">In Stock</span>
                        </div>
                    </div>

                    <!-- Turnkey Flexible Ducting & Power Accessories -->
                    <div class="p-6 rounded-3xl bg-blue-500/10 border border-blue-500/30 shadow-sm hover:shadow-md hover:border-blue-400 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-600 text-white">Full Turnkey</span>
                                <span class="text-[11px] text-blue-900 font-mono">Accessories</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition">Ducting, Plenums & Power Hooks</h3>
                            <p class="text-xs text-slate-700 leading-relaxed">
                                Complete installation hardware including insulated flexible ducting, air transition plenums, industrial power cables, and certified distribution boards.
                            </p>
                            <div class="text-[11px] text-blue-950 pt-2 border-t border-blue-200/60">
                                <strong>Setup:</strong> Same-day commissioning &bull; <strong>Testing:</strong> Air balance verification
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-blue-200/60 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-blue-900 hover:text-blue-950 flex items-center gap-1">
                                <span>Get Turnkey Proposal</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-700 font-bold">Turnkey</span>
                        </div>
                    </div>

                @elseif($isWildAir)
                    <!-- Wild Air Categories -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-teal-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-teal-100 text-teal-800">3,000 – 8,000 CFM</span>
                                <span class="text-[11px] text-slate-400 font-mono">High Static</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-teal-600 transition">Portable Confined Space Blowers</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Axial and centrifugal blowers designed for basement curing, manholes, vessel purging, and underground parking ventilation.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Pressure:</strong> Up to 500 Pa &bull; <strong>Duct:</strong> 300mm / 500mm Flexible PVC
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-teal-700 hover:text-teal-800 flex items-center gap-1">
                                <span>Get Sizing Quote</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-600 font-semibold">Immediate Stock</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-teal-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-teal-100 text-teal-800">10,000 – 25,000 CFM</span>
                                <span class="text-[11px] text-slate-400 font-mono">Heavy Air Movers</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-teal-600 transition">Heavy Civil & Marine Air Movers</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                High-velocity ventilation fans mounted on heavy steel transport skids with crane lifting lugs and phase-reversal protection.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Airflow:</strong> Up to 42,500 m³/hr &bull; <strong>Motor:</strong> IP55 Inverter Duty
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-teal-700 hover:text-teal-800 flex items-center gap-1">
                                <span>Get Sizing Quote</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-600 font-semibold">Immediate Stock</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-teal-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-teal-100 text-teal-800">30,000+ CFM</span>
                                <span class="text-[11px] text-slate-400 font-mono">Jet & Tunnel</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-teal-600 transition">Tunnel & Deep Shaft Jet Fans</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                High-thrust jet ventilation systems for mining, micro-tunneling, metro shafts, and large civil excavation projects across UAE.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Thrust:</strong> 800–1,600 N &bull; <strong>Rating:</strong> High-temperature emergency purge
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-teal-700 hover:text-teal-800 flex items-center gap-1">
                                <span>Get Sizing Quote</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-600 font-semibold">Immediate Stock</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-teal-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-200 text-slate-800">Moisture Control</span>
                                <span class="text-[11px] text-slate-400 font-mono">Desiccant</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-teal-600 transition">Desiccant Dehumidifiers</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Silica gel desiccant wheel dehumidifiers for tank blasting, protective coating application, concrete moisture control, and preservation.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Capacity:</strong> 1,000 – 6,000 CFM &bull; <strong>Dew Point:</strong> Down to -20°C
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-teal-700 hover:text-teal-800 flex items-center gap-1">
                                <span>View Dehumidifier Specs</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">In Stock</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-teal-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-200 text-slate-800">ATEX / Hazardous</span>
                                <span class="text-[11px] text-slate-400 font-mono">Zone 1 / 2</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-teal-600 transition">Flameproof ATEX Ventilation Fans</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Certified explosion-proof fans and anti-static ducting for refineries, chemical storage, fuel tank degassing, and offshore rigs.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Cert:</strong> ATEX Ex d IIB T4 &bull; <strong>Duct:</strong> Conductive anti-static
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-teal-700 hover:text-teal-800 flex items-center gap-1">
                                <span>View ATEX Specs</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">In Stock</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-teal-500/10 border border-teal-500/30 shadow-sm hover:shadow-md hover:border-teal-400 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-teal-600 text-white">Turnkey Ducting</span>
                                <span class="text-[11px] text-teal-900 font-mono">Up to 150m</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-teal-600 transition">Heavy Spiral & Layflat Duct Runs</h3>
                            <p class="text-xs text-slate-700 leading-relaxed">
                                Reinforced PVC spiral wire ducting, layflat delivery hoses, duct couplers, suspension hangers, and transition boxes for rapid site deployment.
                            </p>
                            <div class="text-[11px] text-teal-950 pt-2 border-t border-teal-200/60">
                                <strong>Fire Rating:</strong> Flame Retardant DIN 4102 B1 &bull; <strong>Coupling:</strong> Zip / Ring lock
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-teal-200/60 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-teal-900 hover:text-teal-950 flex items-center gap-1">
                                <span>Get Turnkey Proposal</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-700 font-bold">Turnkey</span>
                        </div>
                    </div>

                @elseif($isMaintenance)
                    <!-- Chiller Maintenance Categories -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-indigo-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-indigo-100 text-indigo-800">24/7 Breakdown</span>
                                <span class="text-[11px] text-slate-400 font-mono">60 Min SLA</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition">Emergency Breakdown Diagnostics & Repair</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Rapid dispatch of certified HVAC refrigeration engineers equipped with ultrasonic leak detectors, digital gauges, and emergency replacement contactors.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Coverage:</strong> 24/7 All Emirates &bull; <strong>Response:</strong> Under 2 hours
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-indigo-700 hover:text-indigo-800 flex items-center gap-1">
                                <span>Request Emergency Tech</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-600 font-semibold">Immediate Dispatch</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-indigo-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-indigo-100 text-indigo-800">Overhaul</span>
                                <span class="text-[11px] text-slate-400 font-mono">Screw & Centrifugal</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition">Compressor Complete Rebuild & Overhaul</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Precision rebuild of screw, scroll, and centrifugal compressors (Trane, Carrier, York, Bitzer, Hanbell) in cleanroom conditions with factory warranties.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Testing:</strong> Laser alignment & Megger test &bull; <strong>Warranty:</strong> 12 Months
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-indigo-700 hover:text-indigo-800 flex items-center gap-1">
                                <span>Get Overhaul Quote</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">Certified Shop</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-indigo-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-indigo-100 text-indigo-800">Descaling</span>
                                <span class="text-[11px] text-slate-400 font-mono">Eddy Current</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition">Condenser & Evaporator Tube Maintenance</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                High-pressure rotary mechanical tube brushing, eco-friendly chemical descaling, and non-destructive eddy current testing to detect wall thinning.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Report:</strong> Wall thickness defect mapping &bull; <strong>Efficiency:</strong> Restores COP by 15-25%
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-indigo-700 hover:text-indigo-800 flex items-center gap-1">
                                <span>Book Tube Service</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">Available</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-indigo-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-200 text-slate-800">Anti-Corrosion</span>
                                <span class="text-[11px] text-slate-400 font-mono">Blygold / Marine</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition">Blygold Anti-Corrosion Coil Treatment</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Professional application of heat-conductive polyurethane anti-corrosion barrier coatings to protect aluminum fins from coastal saline fog and sulfur.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Salt Spray Test:</strong> 4,000+ Hours ASTM B117 &bull; <strong>Thermal Impact:</strong> <1% delta
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-indigo-700 hover:text-indigo-800 flex items-center gap-1">
                                <span>Get Coating Details</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">Certified Applicator</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-indigo-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-200 text-slate-800">Retrofits & VFD</span>
                                <span class="text-[11px] text-slate-400 font-mono">BMS / BACnet</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition">PLC Controller & VFD Retrofits</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Replacement of obsolete proprietary OEM microprocessors with modern Carel, Danfoss, or Siemens PLCs with full BACnet / Modbus BMS integration.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Integration:</strong> Modbus RTU / BACnet IP &bull; <strong>Energy:</strong> 20–30% kWh reduction
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-indigo-700 hover:text-indigo-800 flex items-center gap-1">
                                <span>Explore Retrofits</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">Available</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-indigo-500/10 border border-indigo-500/30 shadow-sm hover:shadow-md hover:border-indigo-400 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-indigo-600 text-white">Comprehensive AMC</span>
                                <span class="text-[11px] text-indigo-900 font-mono">Annual Contract</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition">Annual Maintenance Contracts (AMC)</h3>
                            <p class="text-xs text-slate-700 leading-relaxed">
                                Comprehensive and non-comprehensive contracts covering monthly preventive servicing, oil spectrophotometry, refrigerant top-ups, and 24/7 breakdown response.
                            </p>
                            <div class="text-[11px] text-indigo-950 pt-2 border-t border-indigo-200/60">
                                <strong>Visits:</strong> 12 Monthly + 4 Quarterly Major &bull; <strong>SLA:</strong> 1-Hour phone / 2-Hour on-site
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-indigo-200/60 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-indigo-900 hover:text-indigo-950 flex items-center gap-1">
                                <span>Request AMC Proposal</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-700 font-bold">Guaranteed SLA</span>
                        </div>
                    </div>

                @elseif($isGenerator)
                    <!-- Generator & Power Categories -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-amber-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-amber-100 text-amber-800">20 – 60 kVA</span>
                                <span class="text-[11px] text-slate-400 font-mono">16 – 48 kW</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-amber-600 transition">Portable & Compact Power</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Acoustic canopy diesel generators tailored for site offices, small retail pop-ups, security gates, and dewatering pumps.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Noise:</strong> 65–68 dBA @ 7m &bull; <strong>Fuel:</strong> 5–14 L/hr
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-amber-700 hover:text-amber-800 flex items-center gap-1">
                                <span>Get Sizing Quote</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">In Stock</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-amber-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-amber-100 text-amber-800">60 – 150 kVA</span>
                                <span class="text-[11px] text-slate-400 font-mono">48 – 120 kW</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-amber-600 transition">Mid-Range Silent Generators</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Ideal for tower cranes, concrete vibrators, medium civil construction, hospital standby, and hospitality events.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Noise:</strong> 68–70 dBA @ 7m &bull; <strong>Fuel:</strong> 14–33 L/hr
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-amber-700 hover:text-amber-800 flex items-center gap-1">
                                <span>Get Sizing Quote</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">In Stock</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-amber-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-amber-100 text-amber-800">150 – 500 kVA</span>
                                <span class="text-[11px] text-slate-400 font-mono">120 – 400 kW</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-amber-600 transition">Heavy-Duty Acoustic Gensets</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Built for heavy infrastructure, batching plants, commercial towers, marine drydocks, and industrial manufacturing.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Noise:</strong> 70–73 dBA @ 7m &bull; <strong>Fuel:</strong> 33–105 L/hr
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-amber-700 hover:text-amber-800 flex items-center gap-1">
                                <span>Get Sizing Quote</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">In Stock</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-amber-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-amber-100 text-amber-800">500 – 1250 kVA</span>
                                <span class="text-[11px] text-slate-400 font-mono">400 – 1000 kW</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-amber-600 transition">High-Capacity Containerized</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Engineered for district cooling plants, chillers, deep well dewatering, and high-voltage grid support installations.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Noise:</strong> 72–75 dBA @ 7m &bull; <strong>Fuel:</strong> 105–260 L/hr
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-amber-700 hover:text-amber-800 flex items-center gap-1">
                                <span>Get Sizing Quote</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">In Stock</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-amber-500/10 border border-amber-500/30 shadow-sm hover:shadow-md hover:border-amber-400 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-amber-500 text-slate-950">1 MW to 50 MW</span>
                                <span class="text-[11px] text-amber-800 font-mono">Grid-Scale</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-amber-600 transition">Synchronized Power Plants</h3>
                            <p class="text-xs text-slate-700 leading-relaxed">
                                Modular multi-megawatt synchronized power plants with Deep Sea load-sharing, step-up transformers (11kV/33kV), and bulk ADNOC fuel farms.
                            </p>
                            <div class="text-[11px] text-amber-900 pt-2 border-t border-amber-200/60">
                                <strong>Redundancy:</strong> N+1 Continuous &bull; <strong>Uptime:</strong> 99.99% SLA
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-amber-200/60 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-amber-800 hover:text-amber-950 flex items-center gap-1">
                                <span>View Power Plant Design</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-700 font-bold">Turnkey</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-amber-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-200 text-slate-800">Turnkey Fuel</span>
                                <span class="text-[11px] text-slate-400 font-mono">Bunded Tanks</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-amber-600 transition">Double-Walled Fuel Tanks & Logistics</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                UL 142 double-walled external fuel tanks (1,000 to 20,000 Liters) with automated telemetry sensors and continuous ADNOC fuel supply.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Standard:</strong> Civil Defense Approved &bull; <strong>Refill:</strong> Scheduled auto-delivery
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-amber-700 hover:text-amber-800 flex items-center gap-1">
                                <span>Explore Fuel Services</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">Available</span>
                        </div>
                    </div>

                @else
                    <!-- Used & Refurbished Equipment Categories -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-emerald-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-emerald-100 text-emerald-800">50 – 500 TR</span>
                                <span class="text-[11px] text-slate-400 font-mono">Load-Verified</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition">Pre-Owned Air-Cooled Chillers</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Certified refurbished chillers from Trane, Carrier, and York. Each unit undergoes full eddy current tube testing and hydro-pressure verification.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Brands:</strong> Trane, Carrier, York &bull; <strong>Warranty:</strong> 6-Month Comprehensive
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                                <span>Request Equipment List</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-600 font-semibold">Ready for Inspection</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-emerald-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-emerald-100 text-emerald-800">50 – 1500 kVA</span>
                                <span class="text-[11px] text-slate-400 font-mono">100% Tested</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition">Refurbished Diesel Generators</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Heavy-duty acoustic diesel gensets powered by Cummins, Perkins, and Caterpillar. Full 4-hour resistive load bank tested at 100% rated capacity.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Testing:</strong> 100% Load-Bank Report &bull; <strong>Logistics:</strong> Free Crane Loading
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                                <span>Request Generator Inventory</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-600 font-semibold">Ready for Inspection</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-emerald-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-emerald-100 text-emerald-800">10 – 50 TR</span>
                                <span class="text-[11px] text-slate-400 font-mono">Package AC</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition">Refurbished Commercial Package Units</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Pre-owned rooftop packaged air conditioners and ducted split systems with refurbished coils, freshly painted panels, and tested compressors.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Testing:</strong> Leak-checked & run-tested &bull; <strong>Brands:</strong> SKM, Carrier, Rheem
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                                <span>Check Package AC Stock</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">Available</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-emerald-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-200 text-slate-800">Hydronics</span>
                                <span class="text-[11px] text-slate-400 font-mono">Pumps & AHUs</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition">Used Chilled Water Pumps & AHUs</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                End-suction and split-case chilled water pumps, air handling units, and heat exchangers rebuilt with new mechanical seals and bearings.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Testing:</strong> Hydrostatic pressure tested &bull; <strong>Warranty:</strong> Included
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                                <span>Inquire About Pumps</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-slate-400">Available</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-emerald-300 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-200 text-slate-800">Buy & Sell</span>
                                <span class="text-[11px] text-slate-400 font-mono">Site Offices</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition">Modular Portacabins & Site Cabins</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Cash buyout of used and scrap portacabins across UAE. Sale of refurbished modular site offices, security cabins, and ablution units.
                            </p>
                            <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                                <strong>Cash Offers:</strong> Same-Day &bull; <strong>Logistics:</strong> Free Crane Haulage
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                                <span>Request Portacabin Valuation</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-600 font-semibold">Immediate Cash</span>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl bg-emerald-500/10 border border-emerald-500/30 shadow-sm hover:shadow-md hover:border-emerald-400 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-emerald-600 text-white">Plant Buyout</span>
                                <span class="text-[11px] text-emerald-900 font-mono">Asset Recovery</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition">Complete Plant Decommissioning & Scrap Buyout</h3>
                            <p class="text-xs text-slate-700 leading-relaxed">
                                We purchase decommissioned HVAC plants, chillers, generators, cooling towers, and heavy MEP assets. Immediate technical valuation and lump-sum cash settlement.
                            </p>
                            <div class="text-[11px] text-emerald-950 pt-2 border-t border-emerald-200/60">
                                <strong>Valuation:</strong> Within 24 Hours &bull; <strong>Dismantling:</strong> Certified crane & riggers
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-emerald-200/60 flex items-center justify-between">
                            <a href="#quote-box" class="text-xs font-bold text-emerald-900 hover:text-emerald-950 flex items-center gap-1">
                                <span>Sell Your Plant Assets</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[10px] text-emerald-700 font-bold">Cash Offer</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            <!-- Left 8 Columns: Service Body & Detailed Sections -->
            <main class="lg:col-span-8 space-y-12">

                <!-- Service WYSIWYG Content (Rich Tables & Technical Specs) -->
                <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-sm">
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight font-display mb-6">
                        Service Scope & Technical Engineering Specifications
                    </h2>
                    <div class="prose prose-slate prose-blue max-w-none text-slate-600 leading-relaxed">
                        {!! $service->content !!}
                    </div>
                </div>

                <!-- Specialized Solutions & Regional Hubs (Systematic Internal Links) -->
                @if(isset($nestedPages) && $nestedPages->isNotEmpty())
                    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-sm space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Category Specializations</span>
                                <h3 class="text-2xl font-black text-slate-900 font-display mt-1">Specialized Solutions &amp; Regional Hubs</h3>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                {{ $nestedPages->count() }} Specialized Services
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Explore dedicated application guides, equipment specifications, and rapid mobilization hubs under {{ $service->title }}:
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            @foreach($nestedPages as $np)
                                <a href="{{ url($np->slug) }}/" class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-blue-400 hover:bg-blue-50/30 hover:shadow-sm transition group flex items-start justify-between gap-3">
                                    <div class="space-y-1">
                                        <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition line-clamp-1">
                                            {{ $np->title }}
                                        </div>
                                        <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed">
                                            {{ $np->meta_description ?: Str::limit(strip_tags((string)$np->content), 90) }}
                                        </p>
                                    </div>
                                    <i data-lucide="arrow-up-right" class="w-4 h-4 text-slate-400 group-hover:text-blue-600 shrink-0 mt-0.5 transition"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Features & Technical Specifications -->
                @if(!empty($service->features) && is_array($service->features))
                    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-sm space-y-6">
                        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                            <span>Engineered Standards</span>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 font-display">
                            Technical Features & Equipment Specifications
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            @foreach($service->features as $feature)
                                <div class="flex items-start gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                    <div class="w-5 h-5 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 mt-0.5">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                    </div>
                                    <span class="text-xs font-medium text-slate-800 leading-relaxed">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Turnkey Benefits -->
                @if(!empty($service->benefits) && is_array($service->benefits))
                    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-sm space-y-6">
                        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-emerald-600">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            <span>Commercial Advantages</span>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 font-display">
                            Why UAE Contractors Trust HVAC Clinic
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            @foreach($service->benefits as $benefit)
                                <div class="flex items-start gap-3 p-4 rounded-2xl bg-emerald-50/50 border border-emerald-100">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                                        <i data-lucide="zap" class="w-3.5 h-3.5"></i>
                                    </div>
                                    <span class="text-xs font-medium text-slate-800 leading-relaxed">{{ $benefit }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- 4-Step Rental Process Guide -->
                <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-sm space-y-8">
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-amber-600">
                        <i data-lucide="arrow-right-circle" class="w-4 h-4"></i>
                        <span>Turnkey Execution</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 font-display">
                        Our 4-Step Turnkey Rental & Mobilization Process
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <div class="w-8 h-8 rounded-xl bg-amber-500 text-slate-950 font-black flex items-center justify-center text-sm">1</div>
                            <h4 class="font-bold text-slate-900 text-sm">Thermal & Electrical Load Audit</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Our mechanical and electrical engineers assess design wet-bulb temperatures, sensible heat loads, or starting inrush currents to engineer the exact capacity.
                            </p>
                        </div>
                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <div class="w-8 h-8 rounded-xl bg-amber-500 text-slate-950 font-black flex items-center justify-center text-sm">2</div>
                            <h4 class="font-bold text-slate-900 text-sm">Rapid Hiab Crane Mobilization</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Our heavy transport logistics fleet delivers chillers, generators, pumps, fuel tanks, and cabling to any site in Dubai, Abu Dhabi, or Sharjah within 60–120 minutes.
                            </p>
                        </div>
                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <div class="w-8 h-8 rounded-xl bg-amber-500 text-slate-950 font-black flex items-center justify-center text-sm">3</div>
                            <h4 class="font-bold text-slate-900 text-sm">Turnkey Hookup & Commissioning</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Certified technicians install high-pressure flexible hoses, Bauer quick-couplings, bleed air from water loops, connect power cables, and balance system flow.
                            </p>
                        </div>
                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <div class="w-8 h-8 rounded-xl bg-amber-500 text-slate-950 font-black flex items-center justify-center text-sm">4</div>
                            <h4 class="font-bold text-slate-900 text-sm">24/7 Monitoring & Site Maintenance</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Continuous telemetry tracking, water treatment monitoring, routine filter/oil servicing, and 24/7 on-call technical support guarantee uninterrupted operation.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Locations We Cover (Deep Internal Links Across UAE) -->
                <div class="bg-gradient-to-br from-slate-900 via-slate-900 to-slate-950 text-white rounded-3xl p-8 sm:p-10 border border-slate-800 shadow-xl space-y-6">
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-amber-400">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                        <span>UAE-Wide Depot Coverage</span>
                    </div>
                    <h3 class="text-2xl font-black font-display tracking-tight">
                        Depot Hubs & 2-Hour Dispatch Across All 7 Emirates
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        With operational staging yards located in Al Quoz, JAFZA, Musaffah, and Sharjah Industrial Area, we guarantee rapid equipment dispatch and emergency technician response to all UAE zones:
                    </p>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                        <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                            <div class="font-bold text-xs text-amber-400">Dubai</div>
                            <div class="text-[10px] text-slate-400">Al Quoz, JAFZA, DXP, Marina</div>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                            <div class="font-bold text-xs text-amber-400">Abu Dhabi</div>
                            <div class="text-[10px] text-slate-400">Musaffah, ICAD, Khalifa Port, Ruwais</div>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                            <div class="font-bold text-xs text-amber-400">Sharjah</div>
                            <div class="text-[10px] text-slate-400">Ind Areas 1-18, Sajaa, Hamriyah</div>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                            <div class="font-bold text-xs text-amber-400">Ajman</div>
                            <div class="text-[10px] text-slate-400">Al Jurf, Port Zone, New Ind</div>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                            <div class="font-bold text-xs text-amber-400">Ras Al Khaimah</div>
                            <div class="text-[10px] text-slate-400">Al Hamra, Saqr Port, Al Ghail</div>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                            <div class="font-bold text-xs text-amber-400">Fujairah</div>
                            <div class="text-[10px] text-slate-400">Oil Terminals, Port, Dibba</div>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                            <div class="font-bold text-xs text-amber-400">Umm Al Quwain</div>
                            <div class="text-[10px] text-slate-400">Old Town, Industrial Free Zone</div>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                            <div class="font-bold text-xs text-amber-400">Al Ain</div>
                            <div class="text-[10px] text-slate-400">Industrial City, Sanaiya, Khatam</div>
                        </div>
                    </div>
                </div>

                <!-- Related Fleet Models (Deep Internal Links) -->
                @if(isset($fleetProducts) && $fleetProducts->isNotEmpty())
                    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-sm space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Equipment Fleet</span>
                                <h3 class="text-2xl font-black text-slate-900 font-display mt-1">Available Fleet Models for Immediate Mobilization</h3>
                            </div>
                            <a href="{{ route('fleet.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 hidden sm:block">View Full Fleet &rarr;</a>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 pt-2">
                            @foreach($fleetProducts as $prod)
                                <a href="{{ route('fleet.show', $prod->slug) }}" class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-blue-400 hover:shadow-md transition group flex flex-col justify-between">
                                    <div>
                                        @if($prod->featured_image_url)
                                            <div class="aspect-video rounded-xl overflow-hidden bg-slate-200 mb-3">
                                                <img src="{{ $prod->featured_image_url }}" 
                                                     alt="{{ $prod->title }}" 
                                                     width="400" 
                                                     height="225" 
                                                     loading="lazy" 
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            </div>
                                        @endif
                                        <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition">{{ $prod->title }}</div>
                                        <p class="text-[11px] text-slate-500 line-clamp-2 mt-1">{{ $prod->summary }}</p>
                                    </div>
                                    <div class="mt-4 pt-2 border-t border-slate-200/60 flex items-center justify-between text-[11px] text-blue-700 font-semibold">
                                        <span>View Specifications</span>
                                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Related Technical Articles (Deep Internal Links) -->
                @if(isset($relatedPosts) && $relatedPosts->isNotEmpty())
                    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-sm space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Engineering Guides</span>
                                <h3 class="text-2xl font-black text-slate-900 font-display mt-1">Related Technical Articles & Sizing Insights</h3>
                            </div>
                            <a href="{{ route('blog.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 hidden sm:block">All Articles &rarr;</a>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            @foreach($relatedPosts as $post)
                                <a href="{{ route('post.show', $post->slug) }}" class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-blue-400 hover:shadow-md transition group flex gap-3">
                                    @if($post->featured_image_url)
                                        <div class="w-20 h-20 rounded-xl overflow-hidden bg-slate-200 shrink-0">
                                            <img src="{{ $post->featured_image_url }}" 
                                                 alt="{{ $post->title }}" 
                                                 width="80" 
                                                 height="80" 
                                                 loading="lazy" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                    @endif

                                    <div class="flex flex-col justify-between">
                                        <div>
                                            <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition line-clamp-2">{{ $post->title }}</div>
                                            <div class="text-[10px] text-slate-400 mt-1">{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Technical Guide' }}</div>
                                        </div>
                                        <span class="text-[11px] text-blue-700 font-semibold flex items-center gap-1 mt-1">Read Guide &rarr;</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </main>

            <!-- Right 4 Columns: Quote Request & Navigator Sidebar -->
            <aside class="lg:col-span-4">
                <div class="sticky top-28 space-y-6">
                    @include('frontend.partials.service-sidebar', [
                        'service' => $service,
                        'otherServices' => $otherServices,
                        'nestedPages' => $nestedPages ?? collect(),
                    ])
                </div>
            </aside>

        </div>
    </div>

</div>
@endsection
