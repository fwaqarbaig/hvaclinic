@extends('layouts.app')

@section('seo_meta')
    <title>{{ $page?->seo_title ?: 'Official Membership Certificates | HVAC Clinic UAE' }}</title>
    <meta name="description" content="{{ $page?->seo_description ?: 'Official membership certificates and accreditation for HVAC Clinic across the United Arab Emirates.' }}">
    <link rel="canonical" href="{{ $page?->canonical_url ?: rtrim(url('/membership'), '/') . '/' }}">
    <meta name="robots" content="{{ $page?->is_indexable ? 'index, follow' : 'noindex, nofollow' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $page?->canonical_url ?: rtrim(url('/membership'), '/') . '/' }}">
    <meta property="og:title" content="{{ $page?->og_title ?: $page?->seo_title ?: 'Membership Certificates - HVAC Clinic' }}">
    <meta property="og:description" content="{{ $page?->og_description ?: $page?->seo_description }}">
    <meta property="og:image" content="{{ asset('wp-content/uploads/2026/03/a.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $page?->og_title ?: $page?->seo_title }}">
    <meta name="twitter:description" content="{{ $page?->og_description ?: $page?->seo_description }}">
    <meta name="twitter:image" content="{{ asset('wp-content/uploads/2026/03/a.jpg') }}">
    <!-- Schema.org Membership Page & Breadcrumbs Schema -->
    {!! \App\Services\SchemaGenerator::renderPrimary($page, fn() => $page ? \App\Services\SchemaGenerator::forPage($page) : [
        '@'.'context' => 'https://schema.org',
        '@type' => 'AboutPage',
        '@id' => rtrim(url('/membership'), '/') . '/#membership',
        'name' => 'Membership & Professional Affiliations | HVAC Clinic UAE',
        'description' => 'HVAC Clinic holds memberships with leading international engineering and environmental bodies including ASHRAE, AHRI, and local civil defense authorities.',
        'url' => rtrim(url('/membership'), '/') . '/',
        'about' => ['@id' => config('app.url', 'https://hvaclinic.com') . '/#organization'],
    ]) !!}
    {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::breadcrumbs([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'About', 'url' => rtrim(url('/about'), '/') . '/'],
        ['name' => 'Membership', 'url' => rtrim(url('/membership'), '/') . '/'],
    ])) !!}
    @if(!empty($page?->faqs))
        {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::forFaqs($page->faqs)) !!}
    @endif
@endsection

@section('content')

    <!-- Header Banner -->
    <section class="bg-gradient-to-r from-[#061224] via-[#091e3d] to-[#0a2347] text-white py-14 lg:py-16 border-b border-white/10 relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(37,99,235,0.15),transparent_50%)]"></div>
        <div class="site-container relative z-10">
            <nav class="flex items-center gap-2 text-xs text-slate-300 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-amber-400 transition">Home</a>
                <span class="text-white/30">&bull;</span>
                <a href="/about/" class="hover:text-amber-400 transition">About</a>
                <span class="text-white/30">&bull;</span>
                <span class="text-amber-400 font-semibold">Membership</span>
            </nav>
            <div class="inline-block text-xs font-extrabold uppercase tracking-wider text-cyan-400 mb-1">
                HVAC &amp; Power Solution FZE
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white">
                Official Membership Certificates
            </h1>
            <p class="text-slate-300 text-sm sm:text-base max-w-2xl mt-2 leading-relaxed">
                Recognized trade memberships and engineering accreditations verifying our technical standards and authorized operations across the UAE.
            </p>
        </div>
    </section>

    <!-- Membership Gallery Section with Lightbox Modal -->
    <section class="py-16 sm:py-24 bg-slate-50" x-data="{ modalOpen: false, activeImage: '' }">
        <div class="site-container">
            
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-extrabold tracking-wider text-blue-700 uppercase bg-blue-100/80 px-3 py-1 rounded-full">
                    Accreditations &amp; Affiliations
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-3">
                    Verified Industry Credentials
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-2">
                    Click any certificate below to view the official documentation in full high-resolution.
                </p>
            </div>

            <!-- 4-Card Grid matching hvaclinic.com/membership/ -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
                
                <!-- Certificate 1: a.jpg -->
                <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-xs hover:shadow-xl hover:border-blue-400 transition-all duration-300 group cursor-pointer"
                     @click="activeImage = '/wp-content/uploads/2026/03/a.jpg'; modalOpen = true">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-100 relative">
                        <img src="/wp-content/uploads/2026/03/a.jpg" 
                             alt="rental chiller in uae - membership certificate 1" 
                             loading="lazy" 
                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/30 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <span class="bg-white text-slate-900 text-xs font-bold px-3 py-1.5 rounded-lg shadow-md flex items-center gap-1.5">
                                <i data-lucide="zoom-in" class="size-4 text-blue-600"></i> Click to Zoom
                            </span>
                        </div>
                    </div>
                    <div class="p-4 text-center border-t border-slate-100">
                        <h3 class="text-xs font-bold text-slate-800">Official Membership Certificate 1</h3>
                        <span class="text-[11px] text-blue-600 font-semibold mt-0.5 inline-block">HVAC &amp; Power Solution FZE</span>
                    </div>
                </div>

                <!-- Certificate 2: b.jpg -->
                <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-xs hover:shadow-xl hover:border-blue-400 transition-all duration-300 group cursor-pointer"
                     @click="activeImage = '/wp-content/uploads/2026/03/b.jpg'; modalOpen = true">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-100 relative">
                        <img src="/wp-content/uploads/2026/03/b.jpg" 
                             alt="rental chiller in uae - membership certificate 2" 
                             loading="lazy" 
                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/30 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <span class="bg-white text-slate-900 text-xs font-bold px-3 py-1.5 rounded-lg shadow-md flex items-center gap-1.5">
                                <i data-lucide="zoom-in" class="size-4 text-blue-600"></i> Click to Zoom
                            </span>
                        </div>
                    </div>
                    <div class="p-4 text-center border-t border-slate-100">
                        <h3 class="text-xs font-bold text-slate-800">Official Membership Certificate 2</h3>
                        <span class="text-[11px] text-blue-600 font-semibold mt-0.5 inline-block">HVAC &amp; Power Solution FZE</span>
                    </div>
                </div>

                <!-- Certificate 3: c.jpg -->
                <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-xs hover:shadow-xl hover:border-blue-400 transition-all duration-300 group cursor-pointer"
                     @click="activeImage = '/wp-content/uploads/2026/03/c.jpg'; modalOpen = true">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-100 relative">
                        <img src="/wp-content/uploads/2026/03/c.jpg" 
                             alt="rental chiller in uae - membership certificate 3" 
                             loading="lazy" 
                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/30 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <span class="bg-white text-slate-900 text-xs font-bold px-3 py-1.5 rounded-lg shadow-md flex items-center gap-1.5">
                                <i data-lucide="zoom-in" class="size-4 text-blue-600"></i> Click to Zoom
                            </span>
                        </div>
                    </div>
                    <div class="p-4 text-center border-t border-slate-100">
                        <h3 class="text-xs font-bold text-slate-800">Official Membership Certificate 3</h3>
                        <span class="text-[11px] text-blue-600 font-semibold mt-0.5 inline-block">HVAC &amp; Power Solution FZE</span>
                    </div>
                </div>

                <!-- Certificate 4: d.jpg -->
                <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-xs hover:shadow-xl hover:border-blue-400 transition-all duration-300 group cursor-pointer"
                     @click="activeImage = '/wp-content/uploads/2026/03/d.jpg'; modalOpen = true">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-100 relative">
                        <img src="/wp-content/uploads/2026/03/d.jpg" 
                             alt="rental chiller in uae - membership certificate 4" 
                             loading="lazy" 
                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/30 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <span class="bg-white text-slate-900 text-xs font-bold px-3 py-1.5 rounded-lg shadow-md flex items-center gap-1.5">
                                <i data-lucide="zoom-in" class="size-4 text-blue-600"></i> Click to Zoom
                            </span>
                        </div>
                    </div>
                    <div class="p-4 text-center border-t border-slate-100">
                        <h3 class="text-xs font-bold text-slate-800">Official Membership Certificate 4</h3>
                        <span class="text-[11px] text-blue-600 font-semibold mt-0.5 inline-block">HVAC &amp; Power Solution FZE</span>
                    </div>
                </div>

            </div>

            <!-- Lightbox Modal Component -->
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
                 x-show="modalOpen" 
                 x-cloak 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @keydown.escape.window="modalOpen = false">
                <div class="relative bg-white rounded-2xl max-w-3xl max-h-[90vh] overflow-hidden shadow-2xl p-2"
                     @click.away="modalOpen = false">
                    <button type="button" 
                            class="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-slate-900/70 hover:bg-slate-900 text-white flex items-center justify-center transition"
                            @click="modalOpen = false" 
                            aria-label="Close Preview">
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                    <div class="overflow-auto max-h-[85vh] p-2 flex items-center justify-center bg-slate-50 rounded-xl">
                        <img :src="activeImage" alt="Membership Certificate Enclosure" class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-sm">
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Consultation Callout Banner matching hvaclinic.com -->
    <section class="py-12 bg-gradient-to-r from-[#061224] via-[#091e3d] to-[#07162c] text-white border-t border-white/10">
        <div class="site-container">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 bg-white/5 p-6 sm:p-8 rounded-2xl border border-white/10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 text-cyan-400 flex items-center justify-center shrink-0">
                        <i data-lucide="snowflake" class="size-6"></i>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-white">Have questions or need expert HVAC consultation?</h3>
                        <p class="text-xs sm:text-sm text-slate-300 mt-1">
                            Call us now: 
                            <a href="tel:+971503692131" class="text-amber-400 font-bold hover:underline">+971 50 369 2131</a> &ndash; 
                            <a href="tel:+971506457285" class="text-amber-400 font-bold hover:underline">+971 50 645 7285</a>
                        </p>
                    </div>
                </div>
                <a href="{{ route('contact') }}" class="shrink-0 bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs sm:text-sm px-6 py-3 rounded-xl shadow-md transition">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

@endsection
