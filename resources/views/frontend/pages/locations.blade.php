@extends('layouts.app')

@section('seo_meta')
    <title>{{ $page->meta_title ?? 'Service Locations | Generator Rental Network Dubai & UAE' }}</title>
    <meta name="description" content="{{ $page->meta_description ?? 'Strategic generator rental depots in Dubai, Abu Dhabi, Sharjah, Ajman, RAK, Fujairah, UAQ, and Oman. Rapid 24/7 delivery in 45-90 minutes.' }}">
    <link rel="canonical" href="{{ route('locations.index') }}">
    <meta property="og:title" content="{{ $page->meta_title ?? 'Service Locations | Generator Rental UAE' }}">
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
          'name' => 'Locations',
          'item' => route('locations.index'),
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
                <span class="text-amber-400 font-semibold">Service Locations</span>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/15 text-amber-400 border border-amber-500/30 mb-6 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>NATIONWIDE POWER COVERAGE &bull; ALL 7 EMIRATES + OMAN</span>
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black font-display tracking-tight leading-tight">
                    Strategic Generator Rental <span class="bg-gradient-to-r from-amber-400 via-amber-200 to-yellow-400 bg-clip-text text-transparent">Depots Across UAE</span>
                </h1>
                <p class="mt-6 text-lg sm:text-xl text-slate-300 leading-relaxed font-light">
                    Positioned adjacent to major industrial hubs, maritime free zones, and logistics corridors. Our regional yards guarantee rapid crane mobilization, certified electricians, and continuous fuel logistics.
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="#locations-grid" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 shadow-lg shadow-amber-500/20 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                        <span>Find Your Regional Depot</span>
                        <i data-lucide="arrow-down" class="w-4 h-4"></i>
                    </a>
                    <a href="tel:+971569213754" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition flex items-center gap-2">
                        <i data-lucide="phone-call" class="w-4 h-4 text-amber-400"></i>
                        <span>Central Dispatch: +971 56 921 3754</span>
                    </a>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="mt-16 pt-10 border-t border-slate-800 grid grid-cols-2 md:grid-cols-4 gap-6 text-slate-300">
                <div>
                    <div class="text-3xl font-black text-white font-display">8 Logistics Hubs</div>
                    <div class="text-xs text-slate-400 mt-1">Regional Yards & Staging Points</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white font-display">45–90 Min</div>
                    <div class="text-xs text-slate-400 mt-1">Emergency Delivery Response</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white font-display">50–2500 kVA</div>
                    <div class="text-xs text-slate-400 mt-1">Ready Inventory in Each Depot</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white font-display">24/7 Mobile</div>
                    <div class="text-xs text-slate-400 mt-1">Mechanical Workshops on Wheels</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Regional Locations Grid -->
    <section id="locations-grid" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold uppercase tracking-widest text-amber-600">Regional Power Logistics</span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mt-2 font-display">
                Dedicated Logistics Depots
            </h2>
            <p class="mt-4 text-slate-600 text-base">
                Click on any Emirate or regional station to view specific industrial zones served, local utility standards (DEWA, SEWA, ADDC), and depot response SLAs.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($locations as $loc)
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:border-amber-300 transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                    <div>
                        <!-- Image -->
                        <div class="relative aspect-[16/10] bg-slate-900 overflow-hidden">
                            <img src="{{ $loc['image'] ?? asset('images/locations/dubai.webp') }}" alt="{{ $loc['name'] }}" width="800" height="500" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500 text-slate-950">
                                    {{ $loc['deliveryTime'] ?? '1–2 Hours' }}
                                </span>
                            </div>
                            <div class="absolute bottom-3 left-3 right-3 text-white">
                                <h3 class="text-xl font-black font-display">{{ $loc['name'] }}</h3>
                                <p class="text-[11px] text-amber-300 font-medium">{{ $loc['depot'] ?? 'Regional Depot' }}</p>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 space-y-4">
                            <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                                {{ $loc['tagline'] ?? 'Rapid emergency diesel generator hire and power plants.' }}
                            </p>

                            @if(!empty($loc['sectors']) && is_array($loc['sectors']))
                                <div class="pt-3 border-t border-slate-100 space-y-1.5">
                                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Key Sectors</div>
                                    @foreach(array_slice($loc['sectors'], 0, 3) as $sec)
                                        <div class="flex items-center gap-1.5 text-xs text-slate-700">
                                            <i data-lucide="check" class="w-3 h-3 text-emerald-500 shrink-0"></i>
                                            <span class="truncate">{{ $sec }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="p-6 pt-0">
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('locations.show', $loc['slug']) }}" class="inline-flex items-center gap-1 text-xs font-bold text-amber-700 hover:text-amber-800 transition">
                                <span>Depot Details</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition"></i>
                            </a>
                            <a href="https://wa.me/971569213754?text=Hello+Generator+Dubai,+I+need+generator+delivery+in+{{ urlencode($loc['name']) }}" target="_blank" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition flex items-center gap-1">
                                <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                <span>WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-slate-500">
                    Locations are being loaded.
                </div>
            @endforelse
        </div>
    </section>

    <!-- Emergency Dispatch CTA Banner -->
    <section class="py-16 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-400">
                        Unified Dispatch Center
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black font-display tracking-tight mt-2">
                        Need Immediate Generator Delivery to Your Jobsite?
                    </h2>
                    <p class="text-slate-300 text-sm mt-2 max-w-2xl">
                        Our logistics team coordinates flatbed boom cranes from the nearest depot to minimize transit times and deliver guaranteed power on schedule.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-4 shrink-0">
                    <a href="tel:+971569213754" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-amber-500 text-slate-950 hover:bg-amber-400 shadow-xl transition flex items-center gap-2">
                        <i data-lucide="phone-call" class="w-4 h-4"></i>
                        <span>Call +971 56 921 3754</span>
                    </a>
                    <a href="{{ route('contact') }}" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition flex items-center gap-2">
                        <span>Request Depot Quote</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
