@extends('layouts.app')

@section('seo_meta')
    <title>{{ $product->seo_title ?: ($product->title . ' - Generator Dubai') }}</title>
    <meta name="description" content="{{ $product->seo_description ?: $product->summary }}">
    @if($product->meta_keywords)
        <meta name="keywords" content="{{ $product->meta_keywords }}">
    @endif
    <link rel="canonical" href="{{ route('fleet.show', $product->slug) }}">
    <meta name="robots" content="{{ $product->is_indexable ? 'index, follow' : 'noindex, nofollow' }}">
    <meta property="og:title" content="{{ $product->seo_title ?: $product->title }}">
    <meta property="og:description" content="{{ $product->seo_description ?: $product->summary }}">
    <meta property="og:type" content="product">
    <meta property="og:url" content="{{ route('fleet.show', $product->slug) }}">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Schema.org Product, Breadcrumbs & Custom Schema -->
    {!! \App\Services\SchemaGenerator::renderPrimary($product, fn() => [
      '@'.'context' => 'https://schema.org',
      '@type' => 'Product',
      '@id' => route('fleet.show', $product->slug) . '#product',
      'name' => $product->title,
      'description' => $product->seo_description ?: $product->summary,
      'image' => $product->featured_image_url ? [$product->featured_image_url] : [asset('wp-content/uploads/2026/03/1.jpg')],
      'brand' => [
        '@type' => 'Brand',
        'name' => 'HVAC Clinic UAE',
      ],
      'category' => 'Refurbished HVAC & Power Equipment',
      'offers' => [
        '@type' => 'Offer',
        'availability' => 'https://schema.org/InStock',
        'priceCurrency' => 'AED',
        'price' => 'Contact for Quotation',
        'url' => route('fleet.show', $product->slug),
        'seller' => [
          '@id' => config('app.url', 'https://hvaclinic.com') . '/#organization',
        ],
      ],
    ]) !!}
    {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::breadcrumbs([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Used & Refurbished', 'url' => route('fleet.index')],
        ['name' => $product->title, 'url' => route('fleet.show', $product->slug)],
    ])) !!}
@endsection

@section('content')
@php
    $modules = $product->modules ?? [];
    $engine = $modules['engine_model'] ?? 'Cummins / Perkins Tier-1';
    $prime = $modules['prime_power'] ?? 'Prime Rated Output';
    $standby = $modules['standby_power'] ?? 'Standby Emergency';
    $tank = $modules['fuel_tank'] ?? 'Extended Bulk Tank';
    $consumption = $modules['fuel_consumption'] ?? 'Economical Burn Rate';
    $sound = $modules['sound_attenuation'] ?? '<68 dBA @ 7m';
    $dim = $modules['dimensions'] ?? 'Standard Enclosure';
    $weight = $modules['dry_weight'] ?? 'Skid-Mounted Base';
    $cb = $modules['circuit_breaker'] ?? '4-Pole MCCB';
@endphp

<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs text-slate-500" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-amber-600 transition">Home</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
            <a href="{{ route('fleet.index') }}" class="hover:text-amber-600 transition">Fleet</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
            <span class="text-amber-600 font-bold truncate">{{ $product->title }}</span>
        </nav>

        <!-- Main Product Hero Card -->
        <div class="rounded-3xl bg-white border border-slate-200 shadow-xl overflow-hidden p-6 sm:p-10 lg:p-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left 7 cols: Titles, Specs & Quick CTAs -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="flex flex-wrap items-center gap-2.5">
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-500 text-slate-950 shadow-xs">
                            {{ $product->badge ?: 'Generator Fleet' }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                            400V / 230V &bull; 50Hz 3-Phase
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            &check; Available for Immediate Dispatch
                        </span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black font-display text-slate-950 tracking-tight leading-tight">
                        {{ $product->title }}
                    </h1>

                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                        {{ $product->summary }}
                    </p>

                    <!-- Technical Highlights Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2 text-xs">
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Prime Power:</span>
                            <span class="font-black text-slate-900 text-sm">{{ $prime }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Standby Power:</span>
                            <span class="font-black text-slate-900 text-sm">{{ $standby }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Engine Model:</span>
                            <span class="font-black text-amber-700 text-sm">{{ $engine }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Fuel Burn @ 75%:</span>
                            <span class="font-black text-slate-900 text-sm">{{ $consumption }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Sound Rating:</span>
                            <span class="font-black text-slate-900 text-sm">{{ $sound }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Circuit Breaker:</span>
                            <span class="font-black text-slate-900 text-sm">{{ $cb }}</span>
                        </div>
                    </div>

                    <!-- Direct Action Buttons -->
                    <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <a href="tel:+971569213754" class="px-8 py-3.5 rounded-full bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-extrabold text-xs shadow-lg transition flex items-center justify-center gap-2">
                            <i data-lucide="phone-call" class="w-4 h-4 fill-current"></i>
                            <span>Call 24/7 Hotline: +971 56 921 3754</span>
                        </a>
                        <a href="{{ route('contact') }}" class="px-7 py-3.5 rounded-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition flex items-center justify-center gap-2">
                            <span>Request Written Quote</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>

                <!-- Right 5 cols: Image & Quick Specs Card -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="rounded-3xl overflow-hidden bg-slate-900 border border-slate-200 shadow-lg">
                        <img src="{{ asset($product->featured_image ?: 'storage/media/2026/10/2-im4l8z.jpg') }}" 
                             alt="{{ $product->title }}" 
                             width="800"
                             height="600"
                             loading="eager"
                             fetchpriority="high"
                             class="w-full h-72 sm:h-80 object-cover">

                    </div>

                    <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200 text-xs text-amber-950 space-y-1">
                        <div class="font-bold flex items-center gap-1.5">
                            <i data-lucide="shield-check" class="w-4 h-4 text-amber-600"></i>
                            <span>Full Turnkey Deployment Package Included</span>
                        </div>
                        <p class="text-[11px] text-amber-900 leading-relaxed">
                            Includes crane mobilization, positioning, armored copper cabling, automatic transfer switch (ATS) connection, and pre-commissioning load testing.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Detailed Engineering Specifications Table -->
        <div class="rounded-3xl bg-white border border-slate-200 shadow-md p-6 sm:p-10 space-y-6">
            <h2 class="text-xl sm:text-2xl font-black font-display text-slate-950">
                Full Technical Specifications (ISO 8528 / ISO 3046)
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs sm:text-sm">
                <div class="flex justify-between py-3 px-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-500 font-medium">Prime Electrical Output:</span>
                    <span class="font-bold text-slate-900">{{ $prime }}</span>
                </div>
                <div class="flex justify-between py-3 px-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-500 font-medium">Emergency Standby Output:</span>
                    <span class="font-bold text-slate-900">{{ $standby }}</span>
                </div>
                <div class="flex justify-between py-3 px-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-500 font-medium">Engine Manufacturer / Model:</span>
                    <span class="font-bold text-slate-900">{{ $engine }}</span>
                </div>
                <div class="flex justify-between py-3 px-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-500 font-medium">Internal Fuel Tank Capacity:</span>
                    <span class="font-bold text-slate-900">{{ $tank }}</span>
                </div>
                <div class="flex justify-between py-3 px-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-500 font-medium">Fuel Consumption (75% Prime):</span>
                    <span class="font-bold text-slate-900">{{ $consumption }}</span>
                </div>
                <div class="flex justify-between py-3 px-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-500 font-medium">Sound Attenuation (Acoustic Canopy):</span>
                    <span class="font-bold text-slate-900">{{ $sound }}</span>
                </div>
                <div class="flex justify-between py-3 px-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-500 font-medium">Dimensions (L &times; W &times; H):</span>
                    <span class="font-bold text-slate-900">{{ $dim }}</span>
                </div>
                <div class="flex justify-between py-3 px-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-500 font-medium">Dry Operational Weight:</span>
                    <span class="font-bold text-slate-900">{{ $weight }}</span>
                </div>
                <div class="flex justify-between py-3 px-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-500 font-medium">Circuit Protection:</span>
                    <span class="font-bold text-slate-900">{{ $cb }}</span>
                </div>
                <div class="flex justify-between py-3 px-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-500 font-medium">Cooling Radiator:</span>
                    <span class="font-bold text-slate-900">55°C High-Ambient Tropical Radiator</span>
                </div>
            </div>
        </div>

        <!-- Applications & Recommended Use Cases -->
        @if(!empty($product->highlights) && is_array($product->highlights))
            <div class="rounded-3xl bg-white border border-slate-200 shadow-md p-6 sm:p-10 space-y-6">
                <h2 class="text-xl sm:text-2xl font-black font-display text-slate-950">
                    Recommended Site Applications
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($product->highlights as $app)
                        <div class="flex items-start gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="w-7 h-7 rounded-lg bg-amber-500 text-slate-950 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </div>
                            <span class="text-xs sm:text-sm font-semibold text-slate-800">{{ $app }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Related Fleet Capacities -->
        @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black font-display text-slate-900">Alternative Generator Fleet Capacities</h3>
                    <a href="{{ route('fleet.index') }}" class="text-xs font-bold text-amber-600 hover:underline">View All &rarr;</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach($relatedProducts as $rel)
                        <a href="{{ route('fleet.show', $rel->slug) }}" class="p-5 rounded-2xl bg-white border border-slate-200 hover:border-amber-400 hover:shadow-lg transition block space-y-2 group">
                            <span class="text-xs font-black text-amber-600">{{ $rel->badge ?: 'Fleet Model' }}</span>
                            <h4 class="text-sm font-bold text-slate-900 group-hover:text-amber-600 transition">{{ $rel->title }}</h4>
                            <p class="text-xs text-slate-500 line-clamp-2">{{ $rel->summary }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Cross-Links: Services & Technical Sizing Guide -->
        <div class="rounded-3xl bg-gradient-to-r from-slate-900 via-slate-950 to-slate-900 border border-slate-800 p-8 text-white flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Complete Power Package</span>
                <h3 class="text-lg sm:text-xl font-bold font-display">Need Turnkey Installation, Sizing & Maintenance?</h3>
                <p class="text-xs text-slate-300 max-w-xl">
                    Every generator hire can be paired with our certified <a href="{{ route('service.show', 'rental-power') }}" class="text-amber-400 underline font-semibold hover:text-white">turnkey rental power operations</a>, scheduled <a href="{{ route('service.show', 'maintenance') }}" class="text-amber-400 underline font-semibold hover:text-white">preventative maintenance</a>, and 24/7 technical dispatch from <a href="{{ route('locations.show', 'dubai') }}" class="text-amber-400 underline font-semibold hover:text-white">Dubai</a>, <a href="{{ route('locations.show', 'abu-dhabi') }}" class="text-amber-400 underline font-semibold hover:text-white">Abu Dhabi</a>, and <a href="{{ route('locations.show', 'sharjah') }}" class="text-amber-400 underline font-semibold hover:text-white">Sharjah</a> depots.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('post.show', 'generator-sizing-guide-dubai-construction-kva') }}" class="px-5 py-3 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white border border-white/20 transition flex items-center gap-1.5">
                    <i data-lucide="calculator" class="w-4 h-4 text-amber-400"></i>
                    <span>kVA Sizing Guide</span>
                </a>
                <a href="{{ route('contact') }}" class="px-6 py-3 rounded-xl text-xs font-extrabold bg-amber-500 hover:bg-amber-400 text-slate-950 transition flex items-center gap-1.5 shadow-lg shadow-amber-500/20">
                    <span>Instant Quote</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
</div>
@endsection
