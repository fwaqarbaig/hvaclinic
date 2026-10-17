@extends('layouts.app')

@section('seo_meta')
    <title>{{ $cityData['metaTitle'] ?? 'Generator Rental in ' . $cityData['name'] . ' | Generator Dubai' }}</title>
    <meta name="description" content="{{ $cityData['metaDescription'] ?? 'Rapid generator rental in ' . $cityData['name'] . ': 50–2500 kVA soundproof diesel generators delivered in 45-90 minutes. 24/7 technical support.' }}">
    <link rel="canonical" href="{{ route('locations.show', $cityKey) }}">
    <meta property="og:title" content="{{ $cityData['metaTitle'] ?? 'Generator Rental in ' . $cityData['name'] }}">
    <meta property="og:description" content="{{ $cityData['metaDescription'] ?? 'Emergency generator rental in ' . $cityData['name'] . ' with 24/7 dispatch.' }}">
    <meta property="og:type" content="website">

    <!-- Schema.org LocalBusiness JSON-LD -->
    {!! \App\Services\SchemaGenerator::renderPrimary($page ?? null, fn() => [
      '@'.'context' => 'https://schema.org',
      '@type' => 'LocalBusiness',
      'name' => 'HVAC Clinic - ' . $cityData['name'] . ' Depot',
      'image' => asset($page->featured_image ?? '/wp-content/uploads/2026/03/1.jpg'),
      'url' => route('locations.show', $cityKey),
      'telephone' => '+971503692131',
      'areaServed' => $cityData['name'],
      'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => $cityData['name'],
        'addressCountry' => 'AE',
      ],
      'description' => $cityData['metaDescription'] ?? '',
    ]) !!}

    <!-- Schema.org FAQPage JSON-LD -->
    @if(!empty($cityData['faqs']) && is_array($cityData['faqs']))
    <script type="application/ld+json">
    {!! json_encode([
      '@@context' => 'https://schema.org',
      '@type' => 'FAQPage',
      'mainEntity' => array_map(function($faq) {
          return [
              '@type' => 'Question',
              'name' => $faq['q'] ?? ($faq['question'] ?? ''),
              'acceptedAnswer' => [
                  '@type' => 'Answer',
                  'text' => strip_tags($faq['a'] ?? ($faq['answer'] ?? '')),
              ],
          ];
      }, $cityData['faqs']),
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

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
        [
          '@type' => 'ListItem',
          'position' => 3,
          'name' => $cityData['name'],
          'item' => route('locations.show', $cityKey),
        ],
      ],
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

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
                <a href="{{ route('locations.index') }}" class="hover:text-amber-400 transition">Locations</a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-600"></i>
                <span class="text-amber-400 font-semibold">{{ $cityData['name'] }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-8">
                    @if(!empty($cityData['badge']))
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/15 text-amber-400 border border-amber-500/30 mb-6 backdrop-blur-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>{{ $cityData['badge'] }}</span>
                        </div>
                    @endif

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black font-display tracking-tight leading-tight">
                        {{ $cityData['h1'] ?? 'Generator Rental in ' . $cityData['name'] }}
                    </h1>

                    @if(!empty($cityData['tagline']))
                        <p class="mt-4 text-lg text-amber-300 font-medium">
                            {{ $cityData['tagline'] }}
                        </p>
                    @endif

                    <!-- Quick Facts Pills -->
                    <div class="mt-8 flex flex-wrap items-center gap-3 text-xs text-slate-300">
                        <div class="flex items-center gap-2 bg-slate-800/80 px-3.5 py-2 rounded-xl border border-slate-700">
                            <i data-lucide="clock" class="w-4 h-4 text-amber-400"></i>
                            <span>Delivery SLA: <strong>{{ $cityData['deliveryTime'] ?? '45–90 Min' }}</strong></span>
                        </div>
                        <div class="flex items-center gap-2 bg-slate-800/80 px-3.5 py-2 rounded-xl border border-slate-700">
                            <i data-lucide="zap" class="w-4 h-4 text-amber-400"></i>
                            <span>Fleet Range: <strong>{{ $cityData['powerRange'] ?? '50–2500 kVA' }}</strong></span>
                        </div>
                        @if(!empty($cityData['authority']))
                            <div class="flex items-center gap-2 bg-slate-800/80 px-3.5 py-2 rounded-xl border border-slate-700">
                                <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                                <span>Compliant: <strong>{{ $cityData['authority'] }}</strong></span>
                            </div>
                        @endif
                    </div>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <a href="tel:{{ $cityData['phone'] ?? '+971569213754' }}" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 shadow-lg shadow-amber-500/20 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                            <i data-lucide="phone-call" class="w-4 h-4"></i>
                            <span>Call {{ $cityData['name'] }} Dispatch</span>
                        </a>
                        <a href="https://wa.me/971569213754?text=Hello+Generator+Dubai,+I+need+generator+delivery+in+{{ urlencode($cityData['name']) }}" target="_blank" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-emerald-600 hover:bg-emerald-500 text-white shadow-lg transition flex items-center gap-2">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            <span>WhatsApp Dispatch Team</span>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-4 hidden lg:block">
                    <div class="rounded-3xl overflow-hidden border border-slate-800 shadow-2xl bg-slate-800 aspect-[4/3]">
                        <img src="{{ $cityData['image'] ?? asset('images/locations/dubai.webp') }}" alt="{{ $cityData['name'] }}" width="800" height="600" loading="eager" fetchpriority="high" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Regional Hub Navigator Bar -->
    <div class="bg-white border-b border-slate-200 sticky top-16 z-20 overflow-x-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center gap-2 shrink-0">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 mr-2 shrink-0">Other Hubs:</span>
            @foreach($allCities as $k => $c)
                <a href="{{ route('locations.show', $k) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $k === $cityKey ? 'bg-amber-500 text-slate-950' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    {{ $c['name'] ?? ucfirst($k) }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-16">

        <!-- Districts & Industrial Zones Served -->
        @if(!empty($cityData['districts']) && is_array($cityData['districts']))
            <section class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/90 shadow-sm space-y-8">
                <div class="max-w-3xl">
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-amber-600 mb-2">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                        <span>Immediate Mobilization Zones</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 font-display">
                        Districts & Industrial Areas We Service in {{ $cityData['name'] }}
                    </h2>
                    <p class="text-slate-600 text-sm mt-2">
                        With flatbed boom cranes and technician vans stationed locally at our {{ $cityData['depot'] ?? $cityData['name'] . ' depot' }}, we guarantee on-site equipment arrival across {{ $cityData['name'] }} within {{ $cityData['deliveryTime'] ?? '45–90 minutes' }}.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($cityData['districts'] as $dist)
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 font-bold text-[10px]">{{ $dist['type'] ?? 'District' }}</span>
                                <span class="text-emerald-700 font-bold text-[11px]">{{ $dist['sla'] ?? '60 Min' }}</span>
                            </div>
                            <h3 class="text-sm font-black text-slate-900 font-display">{{ $dist['name'] }}</h3>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Localized Services Section -->
        @if(!empty($cityData['services']) && is_array($cityData['services']))
            <section class="space-y-8">
                <div class="text-center max-w-3xl mx-auto">
                    <span class="text-xs font-bold uppercase tracking-widest text-amber-600">Local Power Capabilities</span>
                    <h2 class="text-3xl font-black text-slate-900 font-display mt-2">
                        Turnkey Power Offerings in {{ $cityData['name'] }}
                    </h2>
                    <p class="text-slate-600 text-sm mt-2">
                        Every generator deployment in {{ $cityData['name'] }} is fully certified to meet {{ $cityData['authority'] ?? 'local utility and civil defense' }} standards, with acoustic soundproofing designed for UAE 50&deg;C high-ambient desert operating conditions.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($cityData['services'] as $svc)
                        <div class="bg-white rounded-3xl p-8 border border-slate-200/90 shadow-sm flex flex-col justify-between space-y-6 hover:shadow-lg transition">
                            <div class="space-y-4">
                                @if(!empty($svc['badge']))
                                    <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                        {{ $svc['badge'] }}
                                    </span>
                                @endif
                                <h3 class="text-lg font-black text-slate-900 font-display">
                                    {{ $svc['title'] }}
                                </h3>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    {{ $svc['summary'] }}
                                </p>

                                @if(!empty($svc['features']) && is_array($svc['features']))
                                    <div class="space-y-2 pt-3 border-t border-slate-100">
                                        @foreach($svc['features'] as $f)
                                            <div class="flex items-start gap-2 text-xs text-slate-600">
                                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500 shrink-0 mt-0.5"></i>
                                                <span>{{ $f }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="pt-4 border-t border-slate-100">
                                <a href="{{ url($svc['ctaLink'] ?? '/services') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-700 hover:text-amber-800 transition">
                                    <span>{{ $svc['ctaText'] ?? 'Explore Solution' }}</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Localized FAQs -->
        @if(!empty($cityData['faqs']) && is_array($cityData['faqs']))
            <section class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/90 shadow-sm space-y-6">
                <div class="max-w-3xl">
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                        <i data-lucide="help-circle" class="w-4 h-4 text-amber-500"></i>
                        <span>Depot Logistics</span>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 font-display">
                        Frequently Asked Questions &bull; {{ $cityData['name'] }}
                    </h2>
                </div>

                <div class="space-y-4 pt-4">
                    @foreach($cityData['faqs'] as $faq)
                        <details class="group rounded-2xl bg-slate-50 border border-slate-200/80 p-5 transition-all">
                            <summary class="flex items-center justify-between font-bold text-sm text-slate-900 cursor-pointer list-none">
                                <span>{{ $faq['q'] ?? ($faq['question'] ?? '') }}</span>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform shrink-0 ml-2"></i>
                            </summary>
                            <div class="mt-3 text-xs text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                                {{ $faq['a'] ?? ($faq['answer'] ?? '') }}
                            </div>
                        </details>
                    @endforeach
                </div>
            </section>
        @endif

    </div>

    <!-- Emergency Dispatch CTA Banner -->
    <section class="py-16 bg-amber-500 text-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider bg-slate-950 text-amber-400 px-3 py-1 rounded-full">
                        {{ $cityData['name'] }} Depot Logistics
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black font-display tracking-tight mt-3">
                        Need Fast Power Deployment in {{ $cityData['name'] }}?
                    </h2>
                    <p class="text-slate-900 text-sm mt-2 max-w-2xl font-medium">
                        Our {{ $cityData['name'] }} logistics yard at {{ $cityData['depot'] ?? $cityData['name'] }} maintains emergency response fleets ready for immediate boom crane dispatch, double-walled fuel tanks, and certified electrical technicians in {{ $cityData['deliveryTime'] ?? 'rapid delivery windows' }}.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-4 shrink-0">
                    <a href="tel:{{ $cityData['phone'] ?? '+971569213754' }}" class="px-6 py-3.5 rounded-xl font-black text-sm bg-slate-950 text-white hover:bg-slate-900 shadow-xl transition flex items-center gap-2">
                        <i data-lucide="phone-call" class="w-4 h-4 text-amber-400"></i>
                        <span>Call +971 56 921 3754</span>
                    </a>
                    <a href="https://wa.me/971569213754?text=Hello+Generator+Dubai,+I+need+generator+delivery+in+{{ urlencode($cityData['name']) }}" target="_blank" class="px-6 py-3.5 rounded-xl font-black text-sm bg-emerald-600 hover:bg-emerald-500 text-white shadow-xl transition flex items-center gap-2">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        <span>WhatsApp {{ $cityData['name'] }} Team</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
