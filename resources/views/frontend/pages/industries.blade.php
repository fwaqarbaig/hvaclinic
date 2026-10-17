@extends('layouts.app')

@section('seo_meta')
    <title>{{ $page->meta_title ?? 'Industries We Power | Generator Rental Dubai & UAE' }}</title>
    <meta name="description" content="{{ $page->meta_description ?? 'Specialized temporary generator hire for construction, events, oil & gas, healthcare, data centers, and hospitality across UAE.' }}">
    <link rel="canonical" href="{{ route('page.industries') }}">
    <meta property="og:title" content="{{ $page->meta_title ?? 'Industries We Power | Generator Rental Dubai' }}">
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
          'name' => 'Industries',
          'item' => route('page.industries'),
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
                <span class="text-amber-400 font-semibold">Industries</span>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/15 text-amber-400 border border-amber-500/30 mb-6 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>MISSION-CRITICAL INDUSTRY POWER &bull; UAE WIDE</span>
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black font-display tracking-tight leading-tight">
                    Engineered Temporary Power for <span class="bg-gradient-to-r from-amber-400 via-amber-200 to-yellow-400 bg-clip-text text-transparent">Every UAE Industry</span>
                </h1>
                <p class="mt-6 text-lg sm:text-xl text-slate-300 leading-relaxed font-light">
                    Every commercial sector carries unique power profiles, environmental challenges, and safety standards. Generator Dubai supplies purpose-engineered power generation fleets tailored to your operational reality.
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="#industries-list" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 shadow-lg shadow-amber-500/20 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                        <span>Explore Sectors</span>
                        <i data-lucide="arrow-down" class="w-4 h-4"></i>
                    </a>
                    <a href="tel:+971569213754" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition flex items-center gap-2">
                        <i data-lucide="phone-call" class="w-4 h-4 text-amber-400"></i>
                        <span>24/7 Hotline: +971 56 921 3754</span>
                    </a>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="mt-16 pt-10 border-t border-slate-800 grid grid-cols-2 md:grid-cols-4 gap-6 text-slate-300">
                <div>
                    <div class="text-3xl font-black text-white font-display">5 Key Sectors</div>
                    <div class="text-xs text-slate-400 mt-1">Specialized Industry Solutions</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white font-display">55°C Ambient</div>
                    <div class="text-xs text-slate-400 mt-1">Tropical Heavy-Duty Radiators</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white font-display">Zero-Dip</div>
                    <div class="text-xs text-slate-400 mt-1">High-Inrush Motor Capability</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white font-display">24/7 On-Site</div>
                    <div class="text-xs text-slate-400 mt-1">Certified Resident Engineers</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Industry Cards Section -->
    <section id="industries-list" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        @forelse($industries as $index => $ind)
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden grid grid-cols-1 lg:grid-cols-12 gap-0 items-stretch">
                <!-- Image Column -->
                <div class="lg:col-span-5 relative min-h-[320px] lg:min-h-full bg-slate-900">
                    <img src="{{ $ind['image'] ?? asset('images/industries/construction.webp') }}" alt="{{ $ind['title'] }}" width="1000" height="667" loading="{{ $index === 0 ? 'eager' : 'lazy' }}" class="w-full h-full object-cover opacity-85">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/30 to-transparent lg:hidden"></div>
                    <div class="absolute top-6 left-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-500 text-slate-950 shadow-md">
                            {{ $ind['badge'] ?? 'Sector #' . ($index + 1) }}
                        </span>
                    </div>
                    <div class="absolute bottom-6 left-6 right-6 text-white lg:p-6 lg:bg-slate-950/75 lg:backdrop-blur-sm lg:rounded-2xl lg:m-6">
                        <div class="text-[11px] font-bold uppercase tracking-wider text-amber-400">Recommended Fleet Configuration</div>
                        <div class="text-xs font-semibold text-slate-200 mt-1">{{ $ind['typicalSetup'] ?? '100–500 kVA Soundproof Synchronized Sets' }}</div>
                    </div>
                </div>

                <!-- Content Column -->
                <div class="lg:col-span-7 p-8 sm:p-12 flex flex-col justify-between space-y-8">
                    <div>
                        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-amber-600 mb-2">
                            <i data-lucide="zap" class="w-4 h-4"></i>
                            <span>Industry Solution #{{ $index + 1 }}</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 font-display">
                            {{ $ind['title'] }}
                        </h2>
                        <p class="text-sm font-semibold text-slate-500 mt-1">
                            {{ $ind['tagline'] }}
                        </p>
                        <p class="text-sm text-slate-600 leading-relaxed mt-4">
                            {{ $ind['description'] }}
                        </p>

                        <!-- Challenges vs Solutions Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 pt-8 border-t border-slate-100">
                            <!-- Challenges -->
                            <div class="space-y-3">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-rose-600 flex items-center gap-1.5">
                                    <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i>
                                    <span>Sector Challenges</span>
                                </h3>
                                @if(!empty($ind['challenges']))
                                    <ul class="space-y-2">
                                        @foreach($ind['challenges'] as $c)
                                            <li class="flex items-start gap-2 text-xs text-slate-600">
                                                <i data-lucide="x-circle" class="w-3.5 h-3.5 text-rose-400 shrink-0 mt-0.5"></i>
                                                <span>{{ $c }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <!-- Solutions -->
                            <div class="space-y-3">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-600 flex items-center gap-1.5">
                                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                    <span>Engineered Solutions</span>
                                </h3>
                                @if(!empty($ind['solutions']))
                                    <ul class="space-y-2">
                                        @foreach($ind['solutions'] as $s)
                                            <li class="flex items-start gap-2 text-xs text-slate-700 font-medium">
                                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500 shrink-0 mt-0.5"></i>
                                                <span>{{ $s }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Actions -->
                    <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('contact') }}?industry={{ urlencode($ind['title']) }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-600 text-slate-950 transition flex items-center gap-2 shadow-sm">
                                <span>Request Sector Quote</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <a href="{{ route('fleet.index') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition flex items-center gap-1.5">
                                <i data-lucide="zap" class="w-3.5 h-3.5 text-amber-500"></i>
                                <span>Explore Matched Fleet</span>
                            </a>
                        </div>
                        <a href="https://wa.me/971569213754?text=Hello+Generator+Dubai,+I+am+inquiring+about+power+solutions+for+{{ urlencode($ind['title']) }}" target="_blank" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 transition flex items-center gap-1.5">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            <span>WhatsApp Industry Lead</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 text-slate-500">
                Industry details are being loaded.
            </div>
        @endforelse
    </section>

    <!-- Emergency Dispatch CTA Banner -->
    <section class="py-16 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-400">
                        Custom Electrical Engineering
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black font-display tracking-tight mt-2">
                        Need a Specialized Power Solution for Your Facility?
                    </h2>
                    <p class="text-slate-300 text-sm mt-2 max-w-2xl">
                        Our principal electrical engineers provide complimentary site load profiling, single-line diagrams, and turnkey equipment recommendations.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-4 shrink-0">
                    <a href="tel:+971569213754" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-amber-500 text-slate-950 hover:bg-amber-400 shadow-xl transition flex items-center gap-2">
                        <i data-lucide="phone-call" class="w-4 h-4"></i>
                        <span>Call +971 56 921 3754</span>
                    </a>
                    <a href="{{ route('contact') }}" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition flex items-center gap-2">
                        <span>Book Site Audit</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
