@extends('layouts.app')

@section('seo_meta')
    <title>{{ $page?->seo_title ?: 'Certificates of Achievement | HVAC Clinic UAE' }}</title>
    <meta name="description" content="{{ $page?->seo_description ?: 'Official certificates of achievement and engineering accreditations for HVAC Clinic across Dubai, Abu Dhabi and UAE.' }}">
    <link rel="canonical" href="{{ $page?->canonical_url ?: rtrim(url('/certificates'), '/') . '/' }}">
    <meta name="robots" content="{{ $page?->is_indexable ? 'index, follow' : 'noindex, nofollow' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $page?->canonical_url ?: rtrim(url('/certificates'), '/') . '/' }}">
    <meta property="og:title" content="{{ $page?->og_title ?: $page?->seo_title ?: 'Certificates - HVAC Clinic' }}">
    <meta property="og:description" content="{{ $page?->og_description ?: $page?->seo_description }}">
    <meta property="og:image" content="{{ asset('wp-content/uploads/2026/03/a-1.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $page?->og_title ?: $page?->seo_title }}">
    <meta name="twitter:description" content="{{ $page?->og_description ?: $page?->seo_description }}">
    <meta name="twitter:image" content="{{ asset('wp-content/uploads/2026/03/a-1.jpg') }}">
    <!-- Schema.org Certificates Page & Breadcrumbs Schema -->
    {!! \App\Services\SchemaGenerator::renderPrimary($page, fn() => $page ? \App\Services\SchemaGenerator::forPage($page) : [
        '@'.'context' => 'https://schema.org',
        '@type' => 'ItemPage',
        '@id' => rtrim(url('/certificates'), '/') . '/#certificates',
        'name' => 'Accreditations & Certificates | HVAC Clinic UAE',
        'description' => 'HVAC Clinic operates under strict ISO 9001 quality management, ISO 14001 environmental, and ISO 45001 occupational safety standards across the UAE.',
        'url' => rtrim(url('/certificates'), '/') . '/',
        'about' => ['@id' => config('app.url', 'https://hvaclinic.com') . '/#organization'],
    ]) !!}
    {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::breadcrumbs([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'About', 'url' => rtrim(url('/about'), '/') . '/'],
        ['name' => 'Certificates', 'url' => rtrim(url('/certificates'), '/') . '/'],
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
                <span class="text-amber-400 font-semibold">Certificates</span>
            </nav>
            <div class="inline-block text-xs font-extrabold uppercase tracking-wider text-cyan-400 mb-1">
                HVAC &amp; Power Solution FZE
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white">
                Certificates of Achievement
            </h1>
            <p class="text-slate-300 text-sm sm:text-base max-w-2xl mt-2 leading-relaxed">
                Manufacturer credentials, executive qualifications, and international certifications earned by our engineering personnel.
            </p>
        </div>
    </section>

    <!-- Certificates Gallery Section with Lightbox Modal -->
    <section class="py-16 sm:py-24 bg-slate-50" x-data="{ modalOpen: false, activeImage: '', activeTitle: '' }">
        <div class="site-container">
            
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs font-extrabold tracking-wider text-blue-700 uppercase bg-blue-100/80 px-3 py-1 rounded-full">
                    Recognition &amp; Excellence
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-3">
                    Certificates of Achievement &amp; Training
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-2">
                    Click on any certificate to view the verified original credentials.
                </p>
            </div>

            <!-- Group 1: Landscape Format Certificates (a-1 to e) -->
            <div class="mb-12">
                <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider border-b border-slate-200 pb-2 mb-6">
                    Professional Accreditations &amp; Technical Diplomas
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
                    
                    @php
                        $landscapeCerts = [
                            ['file' => 'a-1.jpg', 'title' => 'Certificate of Achievement 1'],
                            ['file' => 'b-1.jpg', 'title' => 'Certificate of Achievement 2'],
                            ['file' => 'c-1.jpg', 'title' => 'Certificate of Achievement 3'],
                            ['file' => 'd-1.jpg', 'title' => 'Certificate of Achievement 4'],
                            ['file' => 'e.jpg',   'title' => 'Certificate of Achievement 5'],
                        ];
                    @endphp

                    @foreach($landscapeCerts as $cert)
                        <div class="bg-white rounded-xl overflow-hidden border border-slate-200 shadow-2xs hover:shadow-lg hover:border-blue-400 transition-all duration-300 group cursor-pointer"
                             @click="activeImage = '/wp-content/uploads/2026/03/{{ $cert['file'] }}'; activeTitle = '{{ $cert['title'] }}'; modalOpen = true">
                            <div class="aspect-[4/3] overflow-hidden bg-slate-100 relative">
                                <img src="/wp-content/uploads/2026/03/{{ $cert['file'] }}" 
                                     alt="rental chiller in dubai - {{ $cert['title'] }}" 
                                     loading="lazy" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/30 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <span class="bg-white text-slate-900 text-[11px] font-bold px-2.5 py-1 rounded-md shadow-md flex items-center gap-1">
                                        <i data-lucide="zoom-in" class="size-3.5 text-blue-600"></i> Zoom
                                    </span>
                                </div>
                            </div>
                            <div class="p-3 text-center border-t border-slate-100">
                                <h4 class="text-xs font-semibold text-slate-800 line-clamp-1">{{ $cert['title'] }}</h4>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            <!-- Group 2: Portrait Format Certificates (f to j) -->
            <div>
                <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider border-b border-slate-200 pb-2 mb-6">
                    Engineering Credentials &amp; Certifications
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
                    
                    @php
                        $portraitCerts = [
                            ['file' => 'f.jpg', 'title' => 'Engineering Qualification F'],
                            ['file' => 'g.jpg', 'title' => 'Engineering Qualification G'],
                            ['file' => 'h.jpg', 'title' => 'Engineering Qualification H'],
                            ['file' => 'i.jpg', 'title' => 'Engineering Qualification I'],
                            ['file' => 'j.jpg', 'title' => 'Engineering Qualification J'],
                        ];
                    @endphp

                    @foreach($portraitCerts as $cert)
                        <div class="bg-white rounded-xl overflow-hidden border border-slate-200 shadow-2xs hover:shadow-lg hover:border-blue-400 transition-all duration-300 group cursor-pointer"
                             @click="activeImage = '/wp-content/uploads/2026/03/{{ $cert['file'] }}'; activeTitle = '{{ $cert['title'] }}'; modalOpen = true">
                            <div class="aspect-[3/4] overflow-hidden bg-slate-100 relative">
                                <img src="/wp-content/uploads/2026/03/{{ $cert['file'] }}" 
                                     alt="rental chiller in dubai - {{ $cert['title'] }}" 
                                     loading="lazy" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/30 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <span class="bg-white text-slate-900 text-[11px] font-bold px-2.5 py-1 rounded-md shadow-md flex items-center gap-1">
                                        <i data-lucide="zoom-in" class="size-3.5 text-blue-600"></i> Zoom
                                    </span>
                                </div>
                            </div>
                            <div class="p-3 text-center border-t border-slate-100">
                                <h4 class="text-xs font-semibold text-slate-800 line-clamp-1">{{ $cert['title'] }}</h4>
                            </div>
                        </div>
                    @endforeach

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
                <div class="relative bg-white rounded-2xl max-w-3xl max-h-[90vh] overflow-hidden shadow-2xl p-3"
                     @click.away="modalOpen = false">
                    <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100">
                        <span class="text-xs font-bold text-slate-800" x-text="activeTitle"></span>
                        <button type="button" 
                                class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition"
                                @click="modalOpen = false" 
                                aria-label="Close Preview">
                            <i data-lucide="x" class="size-4"></i>
                        </button>
                    </div>
                    <div class="overflow-auto max-h-[80vh] flex items-center justify-center bg-slate-50 rounded-xl p-2">
                        <img :src="activeImage" :alt="activeTitle" class="max-w-full max-h-[75vh] object-contain rounded-lg shadow-sm">
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
