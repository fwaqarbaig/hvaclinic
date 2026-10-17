@extends('layouts.app')

@section('seo_meta')
    <title>Diesel Generator Fleet Rental UAE | 50 kVA to 2500 kVA Capacities | Generator Dubai</title>
    <meta name="description" content="Explore our complete rental fleet of soundproof diesel generators from 50 to 2500 kVA. Tier-1 Cummins, Perkins & Caterpillar engines with 24/7 dispatch across Dubai & UAE.">
    <meta name="keywords" content="generator fleet dubai, 50 kva generator, 100 kva generator, 250 kva generator, 500 kva generator, 1000 kva generator, silent diesel generator hire uae">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="Diesel Generator Fleet Rental UAE | 50 kVA to 2500 kVA">
    <meta property="og:description" content="Tier-1 Cummins, Perkins, Caterpillar diesel generators. Soundproof canopies, high ambient 55°C desert radiators, 24/7 emergency dispatch.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen">

    <!-- Hero Header -->
    <section class="relative bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white pt-20 pb-20 overflow-hidden">
        <div class="absolute -top-32 right-10 w-96 h-96 bg-amber-500/15 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-600"></i>
                <span class="text-amber-400 font-bold">Fleet Capacities</span>
            </nav>

            <div class="max-w-3xl space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>ACTIVE POWER FLEET: 50 kVA - 2500 kVA</span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black font-display tracking-tight text-white leading-tight">
                    Diesel Generator Fleet Available for <span class="text-amber-400">Immediate UAE Hire</span>
                </h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed font-normal">
                    Fully load-bank tested, low-noise acoustic canopy sets and ISO containerized power plants powered by Tier-1 Cummins, Perkins, and Caterpillar engines. Deployed with certified electrical engineers and turnkey distribution accessories.
                </p>
                <div class="pt-4 flex flex-wrap items-center gap-4">
                    <a href="tel:+971569213754" class="px-7 py-3.5 rounded-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold text-xs shadow-lg transition flex items-center gap-2">
                        <i data-lucide="phone" class="w-4 h-4 fill-current"></i>
                        <span>Immediate Mobilization: +971 56 921 3754</span>
                    </a>
                    <a href="{{ route('contact') }}" class="px-6 py-3.5 rounded-full bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/20 transition">
                        <span>Request Custom Sizing Audit</span>
                    </a>
                </div>
            </div>

            <!-- Quick Trust Bar -->
            <div class="mt-12 pt-8 border-t border-slate-800 grid grid-cols-2 md:grid-cols-4 gap-6 text-xs text-slate-300 font-semibold">
                <div class="flex items-center gap-2.5">
                    <i data-lucide="shield-check" class="w-5 h-5 text-amber-400"></i>
                    <span>ISO 8528 Prime & Standby</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <i data-lucide="volume-x" class="w-5 h-5 text-amber-400"></i>
                    <span>Super-Silent &lt;65 dBA</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <i data-lucide="sun" class="w-5 h-5 text-amber-400"></i>
                    <span>55°C Desert Radiators</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <i data-lucide="truck" class="w-5 h-5 text-amber-400"></i>
                    <span>&lt;60 Min Emergency Dispatch</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Fleet Grid -->
    <section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $prod)
                @php
                    $modules = $prod->modules ?? [];
                    $engine = $modules['engine_model'] ?? 'Cummins / Perkins Tier-1';
                    $tank = $modules['fuel_tank'] ?? 'Extended Run Tank';
                    $consumption = $modules['fuel_consumption'] ?? 'High-Efficiency Burn';
                    $sound = $modules['sound_attenuation'] ?? '<68 dBA @ 7m';
                @endphp
                <div class="group rounded-3xl bg-white border border-slate-200 overflow-hidden hover:border-amber-400 hover:shadow-2xl transition-all flex flex-col justify-between">
                    <div>
                        <!-- Image & Badge Header -->
                        <div class="relative h-48 bg-slate-900 overflow-hidden">
                            <img src="{{ asset($prod->featured_image ?: 'storage/media/2026/10/2-im4l8z.jpg') }}" 
                                 alt="{{ $prod->title }}" 
                                 width="600"
                                 height="400"
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90">

                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-lg bg-amber-500 text-slate-950 font-black text-xs shadow-md">
                                    {{ $prod->badge ?: 'Generator Fleet' }}
                                </span>
                            </div>
                            <div class="absolute bottom-3 left-4 right-4 flex items-center justify-between text-white text-xs">
                                <span class="font-bold flex items-center gap-1">
                                    <i data-lucide="cpu" class="w-3.5 h-3.5 text-amber-400"></i>
                                    <span>{{ $engine }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 space-y-4">
                            <h3 class="text-lg font-black font-display text-slate-950 group-hover:text-amber-600 transition">
                                {{ $prod->title }}
                            </h3>
                            <p class="text-xs text-slate-600 line-clamp-2">
                                {{ $prod->summary }}
                            </p>

                            <!-- Mini Specs Grid -->
                            <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100 text-[11px]">
                                <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                                    <span class="text-slate-400 block">Fuel Burn:</span>
                                    <span class="font-bold text-slate-800">{{ $consumption }}</span>
                                </div>
                                <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                                    <span class="text-slate-400 block">Acoustics:</span>
                                    <span class="font-bold text-slate-800">{{ $sound }}</span>
                                </div>
                                <div class="p-2 rounded-xl bg-slate-50 border border-slate-100 col-span-2">
                                    <span class="text-slate-400 block">Tank & Runtime:</span>
                                    <span class="font-bold text-slate-800">{{ $tank }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Actions -->
                    <div class="p-6 pt-0 mt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                        <a href="{{ route('fleet.show', $prod->slug) }}" class="flex-1 py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-amber-500 text-white hover:text-slate-950 font-bold text-xs text-center transition flex items-center justify-center gap-1.5">
                            <span>View Full Specs</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                        <a href="tel:+971569213754" class="p-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 transition" title="Direct hotline">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</div>
@endsection
