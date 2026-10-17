@extends('layouts.app')

@section('seo_meta')
    <title>{{ $page->meta_title ?? 'Used & Refurbished Generators & Portacabins UAE | Generator Dubai' }}</title>
    <meta name="description" content="{{ $page->meta_description ?? 'Certified refurbished diesel generators and site portacabins for sale and instant cash buyback across Dubai, Sharjah and Abu Dhabi. 100% load tested.' }}">
    <link rel="canonical" href="{{ route('page.used-generators') }}">
    <meta property="og:title" content="{{ $page->meta_title ?? 'Used & Refurbished Generators UAE | Certified Power Sets' }}">
    <meta property="og:type" content="website">

    <!-- Schema.org BreadcrumbList JSON-LD -->
    <script type="application/ld+json">
    {!! json_encode([
      '@@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
        [
          '@type' => 'ListItem',
          'position' => 1,
          'name' => 'Home',
          'item' => route('home'),
        ],
        [
          '@type' => 'ListItem',
          'position' => 2,
          'name' => 'Used & Refurbished Equipment',
          'item' => route('page.used-generators'),
        ],
      ],
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    <!-- Custom Schema.org JSON-LD (from Dashboard) -->
    <x-schema-json-ld :schema="$page->schema_markup ?? null" />
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen">

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-b from-slate-950 via-slate-900 to-slate-900 text-white pt-24 pb-20 overflow-hidden">
        <div class="absolute inset-0 opacity-15 pointer-events-none" style="background-image: radial-gradient(#f59e0b 1px, transparent 1px); background-size: 28px 28px;"></div>
        <div class="absolute -top-36 right-0 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-amber-400 transition">Home</a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-600"></i>
                <span class="text-amber-400 font-semibold">Used & Refurbished Equipment</span>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/15 text-amber-400 border border-amber-500/30 mb-6 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>CERTIFIED PRE-OWNED &bull; 100% LOAD-BANK TESTED &bull; INSTANT BUYBACK</span>
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black font-display tracking-tight leading-tight">
                    Used & Refurbished <span class="bg-gradient-to-r from-amber-400 via-amber-200 to-yellow-400 bg-clip-text text-transparent">Generators & Portacabins</span>
                </h1>
                <p class="mt-6 text-lg sm:text-xl text-slate-300 leading-relaxed font-light">
                    Save up to 50% on capital expenditure without sacrificing electrical reliability. Every unit undergoes rigorous 60-point mechanical overhauls, full load testing, and comes with comprehensive warranty coverage.
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="#inventory-list" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 shadow-lg shadow-amber-500/20 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                        <span>Browse In-Stock Units</span>
                        <i data-lucide="arrow-down" class="w-4 h-4"></i>
                    </a>
                    <a href="#buyback-section" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-emerald-600 hover:bg-emerald-500 text-white shadow-lg transition flex items-center gap-2">
                        <i data-lucide="dollar-sign" class="w-4 h-4 text-emerald-200"></i>
                        <span>Sell Surplus Equipment for Cash</span>
                    </a>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="mt-16 pt-10 border-t border-slate-800 grid grid-cols-2 md:grid-cols-4 gap-6 text-slate-300">
                <div>
                    <div class="text-3xl font-black text-white font-display">Up to 50%</div>
                    <div class="text-xs text-slate-400 mt-1">CAPEX Savings vs New</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white font-display">60-Point</div>
                    <div class="text-xs text-slate-400 mt-1">Diagnostic Quality Audit</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white font-display">Up to 6 Mo</div>
                    <div class="text-xs text-slate-400 mt-1">Mechanical & Electrical Warranty</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white font-display">Instant Cash</div>
                    <div class="text-xs text-slate-400 mt-1">Equipment Buyback Valuation</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Buyback Highlight Section -->
    <section id="buyback-section" class="py-12 bg-amber-500 text-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider bg-slate-950 text-amber-400 px-3 py-1 rounded-full">
                        Instant Asset Liquidation
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black font-display tracking-tight mt-3">
                        Have Surplus Generators or Portacabins on Your Site?
                    </h2>
                    <p class="text-slate-900 text-sm mt-2 max-w-2xl font-medium">
                        We purchase used diesel generators (any brand, working or non-working) and site portacabins. We handle crane dismantling, heavy transport, and full payment before site handover.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-4 shrink-0">
                    <a href="https://wa.me/971569213754?text=Hello+Generator+Dubai,+I+want+to+sell+used+generators+or+portacabins" target="_blank" class="px-6 py-3.5 rounded-xl font-black text-sm bg-slate-950 text-white hover:bg-slate-900 shadow-xl transition flex items-center gap-2">
                        <i data-lucide="message-circle" class="w-4 h-4 text-emerald-400"></i>
                        <span>WhatsApp Photos for Cash Offer</span>
                    </a>
                    <a href="tel:+971569213754" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-white hover:bg-slate-100 text-slate-950 transition flex items-center gap-2">
                        <i data-lucide="phone-call" class="w-4 h-4"></i>
                        <span>Call +971 56 921 3754</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Inventory Grid -->
    <section id="inventory-list" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold uppercase tracking-widest text-amber-600">Certified In-Stock Stock</span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mt-2 font-display">
                Featured Refurbished Fleet & Portacabins
            </h2>
            <p class="mt-4 text-slate-600 text-base">
                All units are fully inspected, reconditioned with authentic OEM components, and located in our Dubai and Sharjah depots for immediate inspection and delivery.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($items as $item)
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:border-amber-300 transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                    <div>
                        <!-- Image Container -->
                        <div class="relative aspect-[16/10] bg-slate-900 overflow-hidden">
                            <img src="{{ $item['image'] ?? asset('images/used/generator-500kva.webp') }}" alt="{{ $item['title'] }}" width="800" height="500" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider {{ ($item['type'] ?? '') === 'generator' ? 'bg-amber-500 text-slate-950' : 'bg-sky-600 text-white' }} shadow-md">
                                    {{ ($item['type'] ?? '') === 'generator' ? 'Diesel Generator' : 'Site Portacabin' }}
                                </span>
                            </div>
                            <div class="absolute bottom-3 right-3">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-950/80 text-white backdrop-blur-sm">
                                    {{ $item['availability'] ?? 'In Stock' }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6 sm:p-8 space-y-4">
                            <h3 class="text-lg font-black text-slate-900 group-hover:text-amber-600 transition font-display leading-snug">
                                {{ $item['title'] }}
                            </h3>

                            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-500">Rating / Capacity:</span>
                                    <strong class="text-slate-900">{{ $item['dimensionsOrKva'] ?? 'N/A' }}</strong>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-500">Condition:</span>
                                    <strong class="text-emerald-700">{{ $item['condition'] ?? 'Refurbished' }}</strong>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-500">Warranty:</span>
                                    <strong class="text-slate-900">{{ $item['warranty'] ?? 'Included' }}</strong>
                                </div>
                            </div>

                            @if(!empty($item['features']) && is_array($item['features']))
                                <div class="space-y-1.5 pt-2">
                                    @foreach(array_slice($item['features'], 0, 3) as $f)
                                        <div class="flex items-start gap-2 text-xs text-slate-600">
                                            <i data-lucide="check" class="w-3.5 h-3.5 text-amber-500 shrink-0 mt-0.5"></i>
                                            <span class="line-clamp-1">{{ $f }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="p-6 pt-0">
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                            <a href="https://wa.me/971569213754?text=Hello+Generator+Dubai,+I+am+inquiring+about+{{ urlencode($item['title']) }}" target="_blank" class="w-full py-2.5 rounded-xl font-bold text-xs bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white transition text-center flex items-center justify-center gap-1.5">
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                                <span>Inquire Availability</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-slate-500">
                    Used inventory details are being updated.
                </div>
            @endforelse
        </div>
    </section>

    <!-- Inspection Protocol Section -->
    <section class="py-20 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-widest text-amber-600">Rigorous Reconditioning</span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mt-2 font-display">
                    Our 60-Point Quality Certification
                </h2>
                <p class="mt-4 text-slate-600 text-sm">
                    Why our pre-owned diesel generators perform with the reliability of factory-new machines.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center">
                        <i data-lucide="activity" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 font-display">Cylinder Compression & Fuel System</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Full diesel compression test across all cylinders, fuel injector spray pattern recalibration, turbocharger shaft play inspection, and brand-new Fleetguard / Donaldson filtration.
                    </p>
                </div>
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center">
                        <i data-lucide="zap" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 font-display">Alternator & Megger Insulation Test</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        High-voltage Megger insulation resistance testing on main stator and rotor windings, automatic voltage regulator (AVR) harmonic verification, and diode bridge inspection.
                    </p>
                </div>
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center">
                        <i data-lucide="clipboard-check" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 font-display">4-Hour Resistive Load-Bank Run</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Continuous stepped testing under 25%, 50%, 75%, and 100% full resistive electrical load. Complete printout of coolant temperatures, oil pressures, and frequency stability provided.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cross-Link CTA: Need Rental or New Fleet? -->
    <section class="py-16 bg-slate-900 text-white border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="space-y-2 text-center lg:text-left">
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Temporary Project Power</span>
                    <h2 class="text-2xl sm:text-3xl font-black font-display">Need Short-Term Rental Instead of Purchasing?</h2>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-xl">
                        Save capital expenditure with our 50–2500 kVA silent diesel rental fleet. Complete with 24/7 maintenance, rapid dispatch, and bundled ADNOC fuel logistics.
                    </p>
                </div>
                <div class="flex flex-wrap items-center justify-center gap-3 shrink-0">
                    <a href="{{ route('fleet.index') }}" class="px-6 py-3.5 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white border border-white/20 transition flex items-center gap-2">
                        <i data-lucide="layers" class="w-4 h-4 text-amber-400"></i>
                        <span>Explore Rental Fleet</span>
                    </a>
                    <a href="{{ route('service.show', 'rental-power') }}" class="px-6 py-3.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition flex items-center gap-2 shadow-lg shadow-amber-500/20">
                        <span>Turnkey Power Hire</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
