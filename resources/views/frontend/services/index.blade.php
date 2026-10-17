@extends('layouts.app')

@section('seo_meta')
    <title>Rental Cooling, Chillers, AC & Power Services in UAE | HVAC Clinic</title>
    <meta name="description" content="Turnkey temporary cooling and power solutions across Dubai, Abu Dhabi, Sharjah & UAE: 50–1500 TR chillers, commercial package ACs, wild air ventilation, chiller maintenance AMC, diesel generators & used equipment.">
    <meta name="keywords" content="rental cooling uae, chiller rental dubai, rental ac uae, wild air rental dubai, chiller maintenance uae, generator rental dubai, rental power uae, used refurbished chillers dubai">
    <link rel="canonical" href="{{ rtrim(url('/services'), '/') . '/' }}">
    <meta property="og:title" content="Rental Cooling, Chillers, AC & Power Services in UAE | HVAC Clinic">
    <meta property="og:description" content="Turnkey temporary cooling and power solutions across Dubai, Abu Dhabi, Sharjah & UAE: 50–1500 TR chillers, commercial package ACs, wild air ventilation, chiller maintenance AMC, diesel generators & used equipment.">
    <meta property="og:url" content="{{ rtrim(url('/services'), '/') . '/' }}">
    <meta property="og:type" content="website">

    <!-- Schema.org Services ItemList & BreadcrumbList -->
    {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::forItemList(
        'Turnkey HVAC & Power Services UAE - HVAC Clinic',
        $services,
        fn($s) => [
            'name' => $s->title,
            'url' => route('service.show', $s->slug),
            'description' => $s->seo_description,
            'image' => $s->featured_image_url,
        ]
    )) !!}
    {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::breadcrumbs([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Services', 'url' => rtrim(url('/services'), '/') . '/'],
    ])) !!}
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen">

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-b from-slate-950 via-slate-900 to-slate-900 text-white pt-24 pb-20 overflow-hidden">
        <div class="absolute inset-0 opacity-15 pointer-events-none" style="background-image: radial-gradient(#38bdf8 1px, transparent 1px); background-size: 28px 28px;"></div>
        <div class="absolute -top-36 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-amber-400 transition">Home</a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-600"></i>
                <span class="text-amber-400 font-semibold">Services</span>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/15 text-blue-300 border border-blue-500/30 mb-6 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>TURNKEY COOLING & POWER ENGINEERING • UAE-WIDE DISPATCH</span>
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black font-display tracking-tight leading-tight">
                    Turnkey Cooling, AC & <span class="bg-gradient-to-r from-amber-400 via-amber-200 to-yellow-400 bg-clip-text text-transparent">Power Solutions in UAE</span>
                </h1>
                <p class="mt-6 text-lg sm:text-xl text-slate-300 leading-relaxed font-light">
                    From 50 to 1,500 TR air-cooled chillers and packaged AC units to high-velocity wild air ventilation, certified chiller maintenance, 20–2500 kVA quiet diesel generators, and load-tested refurbished equipment across all 7 Emirates.
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="#services-grid" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 shadow-lg shadow-amber-500/20 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                        <span>Explore Our Services</span>
                        <i data-lucide="arrow-down" class="w-4 h-4"></i>
                    </a>
                    <a href="tel:+971503692131" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition flex items-center gap-2">
                        <i data-lucide="phone-call" class="w-4 h-4 text-amber-400"></i>
                        <span>24/7 Hotline: +971 50 369 2131</span>
                    </a>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="mt-16 pt-10 border-t border-slate-800 grid grid-cols-2 md:grid-cols-4 gap-6 text-slate-300">
                <div>
                    <div class="text-3xl font-black text-white font-display">50–1500 TR</div>
                    <div class="text-xs text-slate-400 mt-1">Chiller Fleet Sizing Range</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white font-display">20–2500 kVA</div>
                    <div class="text-xs text-slate-400 mt-1">Silent Diesel Generators</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white font-display">60–120 Min</div>
                    <div class="text-xs text-slate-400 mt-1">Emergency Dispatch SLA</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white font-display">99.98%</div>
                    <div class="text-xs text-slate-400 mt-1">Cooling & Power Uptime SLA</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Grid Section -->
    <section id="services-grid" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold uppercase tracking-widest text-blue-600">Core Engineering Solutions</span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mt-2 font-display">
                Engineered for High-Ambient Desert Operations
            </h2>
            <p class="mt-4 text-slate-600 text-base">
                Every service is backed by certified refrigeration and electrical engineers, genuine OEM spare parts, Blygold marine anti-corrosion coil protection, and round-the-clock site support across Dubai, Abu Dhabi, Sharjah, and Northern Emirates.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($services as $svc)
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:border-blue-300 transition-all duration-300 flex flex-col justify-between p-8 group">
                    <div>
                        <!-- Featured Image Thumbnail -->
                        @if($svc->featured_image_url)
                            <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-slate-100 mb-6 border border-slate-100">
                                <img src="{{ $svc->featured_image_url }}" 
                                     alt="{{ $svc->title }} in UAE" 
                                     width="600" 
                                     height="338" 
                                     loading="lazy" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @endif

                        <!-- Icon & Tag -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 flex items-center justify-center shadow-inner">
                                <i data-lucide="{{ $svc->icon ?: 'snowflake' }}" class="w-6 h-6"></i>
                            </div>
                            @if($svc->hero_badge)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-800 border border-blue-200">
                                    {{ $svc->hero_badge }}
                                </span>
                            @endif
                        </div>

                        <!-- Title & Tagline -->
                        <h3 class="text-xl font-black text-slate-900 group-hover:text-blue-600 transition font-display">
                            <a href="{{ route('service.show', $svc->slug) }}">
                                {{ $svc->title }}
                            </a>
                        </h3>

                        @if($svc->tagline)
                            <p class="text-xs font-semibold text-slate-500 mt-1">{{ $svc->tagline }}</p>
                        @endif

                        <p class="text-sm text-slate-600 leading-relaxed mt-4 line-clamp-3">
                            {{ $svc->summary }}
                        </p>

                        <!-- Key Features Checklist -->
                        @if(!empty($svc->features) && is_array($svc->features))
                            <div class="mt-6 pt-6 border-t border-slate-100 space-y-2">
                                @foreach(array_slice($svc->features, 0, 3) as $feat)
                                    <div class="flex items-start gap-2 text-xs text-slate-600">
                                        <i data-lucide="check" class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5"></i>
                                        <span>{{ $feat }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Footer Link -->
                    <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('service.show', $svc->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-700 hover:text-blue-800 transition">
                            <span>View Engineering Specs</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition"></i>
                        </a>
                        <a href="{{ route('contact') }}?service={{ urlencode($svc->title) }}" class="text-xs font-semibold text-slate-400 hover:text-slate-700 transition">
                            Get Quote
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-slate-500">
                    Services data is currently being updated.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 4-Step Engineering Protocol -->
    <section class="py-20 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-widest text-amber-400">Turnkey SLA Protocol</span>
                <h2 class="text-3xl sm:text-4xl font-black font-display tracking-tight mt-2">
                    Rapid 4-Step Mobilization Protocol
                </h2>
                <p class="mt-4 text-slate-400 text-sm">
                    How our engineering logistics division deploys temporary cooling, power, and site utilities seamlessly across the UAE.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="bg-slate-800/80 rounded-2xl p-6 border border-slate-700 relative">
                    <div class="text-3xl font-black text-amber-400 font-mono mb-3">01</div>
                    <h3 class="text-base font-bold text-white mb-2 font-display">Thermal & SLD Audit</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Our certified engineers calculate sensible/latent cooling loads or starting inrush currents to size the exact chiller tonnage and kVA rating.
                    </p>
                </div>
                <div class="bg-slate-800/80 rounded-2xl p-6 border border-slate-700 relative">
                    <div class="text-3xl font-black text-amber-400 font-mono mb-3">02</div>
                    <h3 class="text-base font-bold text-white mb-2 font-display">Rapid Fleet Mobilization</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Chillers, generators, pumping stations, and high-pressure flexible hoses depart our nearest depot (Dubai, Abu Dhabi, or Sharjah) in 60–120 min.
                    </p>
                </div>
                <div class="bg-slate-800/80 rounded-2xl p-6 border border-slate-700 relative">
                    <div class="text-3xl font-black text-amber-400 font-mono mb-3">03</div>
                    <h3 class="text-base font-bold text-white mb-2 font-display">Turnkey Hookup & Testing</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Certified technicians couple water lines with quick Bauer fittings, flush loops, connect power cables, balance flow, and commission the system.
                    </p>
                </div>
                <div class="bg-slate-800/80 rounded-2xl p-6 border border-slate-700 relative">
                    <div class="text-3xl font-black text-amber-400 font-mono mb-3">04</div>
                    <h3 class="text-base font-bold text-white mb-2 font-display">24/7 Telemetry & Servicing</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Live IoT telemetry tracks water temperatures, refrigerant pressures, and fuel levels with preventive servicing and 24/7 emergency response.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Emergency Dispatch CTA Banner -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider bg-slate-950 text-amber-400 px-3 py-1 rounded-full">
                        24/7 Rapid Emergency Response
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black font-display tracking-tight mt-3">
                        Facing an Urgent Chiller Breakdown or Need Emergency Power?
                    </h2>
                    <p class="text-blue-100 text-sm mt-2 max-w-2xl font-medium">
                        Speak directly with our on-duty HVAC & mechanical engineer. Immediate dispatch across Dubai, Abu Dhabi, Sharjah, and Northern Emirates.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-4 shrink-0">
                    <a href="tel:+971503692131" class="px-6 py-3.5 rounded-xl font-black text-sm bg-slate-950 text-white hover:bg-slate-900 shadow-xl transition flex items-center gap-2">
                        <i data-lucide="phone-call" class="w-4 h-4 text-amber-400"></i>
                        <span>Call +971 50 369 2131</span>
                    </a>
                    <a href="https://wa.me/971503692131?text={{ urlencode('Hello HVAC Clinic, I need urgent cooling or power rental pricing') }}" target="_blank" class="px-6 py-3.5 rounded-xl font-black text-sm bg-emerald-600 hover:bg-emerald-500 text-white shadow-xl transition flex items-center gap-2">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        <span>WhatsApp Engineering</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
