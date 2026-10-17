@extends('layouts.app')

@section('seo_meta')
    <title>About Generator Dubai | UAE Power Generation & Fleet History</title>
    <meta name="description" content="Learn about Generator Dubai, the UAE leader in turnkey temporary power generation, heavy diesel fleet operations, and certified electrical engineering across all 7 Emirates.">
    <meta name="keywords" content="about generator dubai, generator company uae, temporary power supplier dubai, diesel generator fleet uae">
    <link rel="canonical" href="{{ route('about') }}">
    <meta property="og:title" content="About Generator Dubai | Turnkey Temporary Power Engineering">
    <meta property="og:description" content="Over a decade of heavy-duty temporary power generation across Dubai, Abu Dhabi, Sharjah and Northern Emirates.">
    <meta property="og:url" content="{{ route('about') }}">
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
          'name' => 'About Us',
          'item' => route('about'),
        ],
      ],
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    <!-- Custom Schema.org JSON-LD (from Dashboard) -->
    <x-schema-json-ld :schema="$page->schema_markup ?? null" />
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen space-y-20">

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white pt-24 pb-20 overflow-hidden">
        <div class="absolute -top-32 right-10 w-96 h-96 bg-amber-500/15 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-600"></i>
                <span class="text-amber-400 font-bold">About Us</span>
            </nav>

            <div class="max-w-3xl space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>OVER A DECADE OF UAE POWER ENGINEERING</span>
                </div>
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black font-display tracking-tight leading-tight">
                    Powering the Nation's Most Critical Infrastructure <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-300 to-yellow-200">Without Interruption</span>
                </h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed font-normal">
                    Generator Dubai was established with an uncompromising mission: to deliver continuous, transient-free electrical power to the fastest-growing civil, industrial, marine, and commercial projects across the United Arab Emirates.
                </p>
                <div class="pt-4 flex flex-wrap items-center gap-4">
                    <a href="{{ route('fleet.index') }}" class="px-7 py-3.5 rounded-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold text-xs shadow-lg transition flex items-center gap-2">
                        <span>Explore Generator Fleet</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ route('contact') }}" class="px-6 py-3.5 rounded-full bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/20 transition">
                        <span>Contact Technical Team</span>
                    </a>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="mt-16 pt-10 border-t border-slate-800 grid grid-cols-2 md:grid-cols-4 gap-6 text-slate-300">
                <div>
                    <div class="text-3xl sm:text-4xl font-black text-white font-display">10+ Years</div>
                    <div class="text-xs text-slate-400 mt-1">UAE Industry Experience</div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-black text-white font-display">99.98%</div>
                    <div class="text-xs text-slate-400 mt-1">Power Uptime Guarantee</div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-black text-white font-display">50-2500 kVA</div>
                    <div class="text-xs text-slate-400 mt-1">Active Fleet Capacities</div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-black text-white font-display">&lt;60 Mins</div>
                    <div class="text-xs text-slate-400 mt-1">Emergency Dispatch Time</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed Company Narrative -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 space-y-6">
                <span class="text-xs font-extrabold uppercase tracking-widest text-amber-600">Company Profile</span>
                <h2 class="text-2xl sm:text-4xl font-black font-display text-slate-950 tracking-tight leading-tight">
                    Single-Source Accountable Partner for Heavy Power Infrastructure
                </h2>
                <div class="space-y-4 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    <p>
                        In extreme desert environments where summer ambient temperatures routinely surge past 50°C, ordinary power generation equipment experiences severe thermal deration, frequent radiator boiling, and catastrophic shutdown.
                    </p>
                    <p>
                        Generator Dubai solves this by investing exclusively in high-ambient tropical radiators, Tier-1 industrial diesel engines (Cummins, Perkins, Caterpillar), and certified acoustic steel enclosures designed to maintain 100% continuous prime power under grueling UAE desert conditions.
                    </p>
                    <p>
                        With dedicated logistics hubs in Dubai, Abu Dhabi, and Sharjah, our mobile cranes and heavy trailers deliver rapid mobilization, certified rigging, armored cabling, and on-site testing within hours of dispatch confirmation.
                    </p>
                </div>
            </div>

            <div class="lg:col-span-6">
                <div class="rounded-3xl overflow-hidden bg-slate-900 border border-slate-200 shadow-xl">
                    <img src="{{ asset('storage/media/2026/10/5-5gbsbw.jpg') }}" alt="Generator Dubai Fleet" width="800" height="450" loading="lazy" class="w-full h-80 sm:h-96 object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Core Engineering Values -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-slate-900 text-white p-8 sm:p-14 border border-slate-800 space-y-10">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-bold text-amber-400 uppercase tracking-widest">Our Principles</span>
                <h3 class="text-2xl sm:text-3xl font-black font-display text-white">The Engineering Pillars That Set Us Apart</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-xs sm:text-sm">
                <div class="space-y-3 p-6 rounded-2xl bg-slate-950/60 border border-slate-800">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <h4 class="text-base font-bold text-white">Absolute Safety & Compliance</h4>
                    <p class="text-slate-400 leading-relaxed">
                        Every cable, automatic transfer switch, and bulk fuel tank complies strictly with UAE Civil Defense safety codes, DEWA standards, and ISO 8528 regulations.
                    </p>
                </div>
                <div class="space-y-3 p-6 rounded-2xl bg-slate-950/60 border border-slate-800">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                    <h4 class="text-base font-bold text-white">Guaranteed Uptime SLA</h4>
                    <p class="text-slate-400 leading-relaxed">
                        We deploy qualified resident electrical technicians who monitor voltage, frequency, and oil pressure in real-time, backed by telemetry and scheduled bulk fuel delivery.
                    </p>
                </div>
                <div class="space-y-3 p-6 rounded-2xl bg-slate-950/60 border border-slate-800">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center">
                        <i data-lucide="file-text" class="w-5 h-5"></i>
                    </div>
                    <h4 class="text-base font-bold text-white">Transparent Commercials</h4>
                    <p class="text-slate-400 leading-relaxed">
                        No ambiguous mobilization surcharges, hidden maintenance fees, or surprise fuel costs. Every proposal is itemized, transparent, and legally binding.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom Contact Strip -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="rounded-3xl bg-amber-500 text-slate-950 p-8 sm:p-12 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="text-2xl font-black font-display">Speak Directly with a Power Engineer</h3>
                <p class="text-xs sm:text-sm font-semibold mt-1">Free site visits, electrical sizing calculations, and itemized quotations across all Emirates.</p>
            </div>
            <a href="tel:+971569213754" class="px-7 py-3.5 rounded-full bg-slate-950 text-white font-extrabold text-xs shadow-xl transition flex items-center gap-2 shrink-0">
                <i data-lucide="phone" class="w-4 h-4 fill-current"></i>
                <span>Call +971 56 921 3754</span>
            </a>
        </div>
    </section>

</div>
@endsection
