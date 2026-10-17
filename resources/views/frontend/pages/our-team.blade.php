@extends('layouts.app')

@section('seo_meta')
    <title>{{ $page?->seo_title ?: 'Our Team | HVAC Clinic Leadership UAE' }}</title>
    <meta name="description" content="{{ $page?->seo_description ?: 'Meet the executive leadership and engineering management team driving HVAC Clinic rental cooling, chillers, and power solutions in the UAE.' }}">
    <link rel="canonical" href="{{ $page?->canonical_url ?: rtrim(url('/our-team'), '/') . '/' }}">
    <meta name="robots" content="{{ $page?->is_indexable ? 'index, follow' : 'noindex, nofollow' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $page?->canonical_url ?: rtrim(url('/our-team'), '/') . '/' }}">
    <meta property="og:title" content="{{ $page?->og_title ?: $page?->seo_title ?: 'Our Team - HVAC Clinic' }}">
    <meta property="og:description" content="{{ $page?->og_description ?: $page?->seo_description }}">
    <meta property="og:image" content="{{ asset('wp-content/uploads/2026/03/imran.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $page?->og_title ?: $page?->seo_title }}">
    <meta name="twitter:description" content="{{ $page?->og_description ?: $page?->seo_description }}">
    <meta name="twitter:image" content="{{ asset('wp-content/uploads/2026/03/imran.jpg') }}">
    <!-- Schema.org ProfilePage & Breadcrumbs Schema -->
    {!! \App\Services\SchemaGenerator::renderPrimary($page, fn() => $page ? \App\Services\SchemaGenerator::forPage($page) : [
        '@'.'context' => 'https://schema.org',
        '@type' => 'ProfilePage',
        '@id' => rtrim(url('/our-team'), '/') . '/#profile',
        'name' => 'Our Team | HVAC Clinic Leadership UAE',
        'description' => 'Meet the executive leadership and engineering management team driving HVAC Clinic rental cooling, chillers, and power solutions in the UAE.',
        'url' => rtrim(url('/our-team'), '/') . '/',
        'about' => ['@id' => config('app.url', 'https://hvaclinic.com') . '/#organization'],
    ]) !!}
    {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::breadcrumbs([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'About', 'url' => rtrim(url('/about'), '/') . '/'],
        ['name' => 'Our Team', 'url' => rtrim(url('/our-team'), '/') . '/'],
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
                <span class="text-amber-400 font-semibold">Our Team</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white">
                Our Leadership Team
            </h1>
            <p class="text-slate-300 text-sm sm:text-base max-w-2xl mt-2 leading-relaxed">
                Decades of combined engineering excellence, international leadership, and specialized experience across the HVAC and rental power sectors.
            </p>
        </div>
    </section>

    <!-- Leadership Showcase Section matching hvaclinic.com -->
    <section class="py-16 sm:py-24 bg-white">
        <div class="site-container max-w-6xl mx-auto space-y-16">
            
            <!-- Executive 1: Imran Ali -->
            <div class="bg-slate-50/70 rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-xs hover:shadow-xl transition-all duration-300">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- Photo Column -->
                    <div class="md:col-span-5 lg:col-span-4">
                        <div class="rounded-2xl overflow-hidden shadow-lg border-2 border-white bg-slate-200 aspect-[6/5]">
                            <img src="/wp-content/uploads/2026/03/imran.jpg" 
                                 alt="imran ali hvaclinic dubai" 
                                 width="720" 
                                 height="609" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Bio Column -->
                    <div class="md:col-span-7 lg:col-span-8 space-y-4">
                        <div>
                            <span class="text-xs font-extrabold text-blue-700 bg-blue-100/70 px-3 py-1 rounded-full uppercase tracking-wider">
                                Executive Leadership
                            </span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">
                                IMRAN ALI
                            </h2>
                            <h3 class="text-base font-bold text-blue-600 mt-0.5">
                                Managing Director
                            </h3>
                        </div>

                        <div class="text-slate-600 text-sm leading-relaxed space-y-3 pt-1">
                            <p>
                                I am settled (as a British expatriate) in UAE since 2009. Committed to change the dynamics in HVAC Customer Support/Services industry, in any region and any culture across the Globe.
                            </p>
                            <p>
                                Enjoyed career development courses from much reputed and globally recognized institutes i.e. <strong class="text-slate-900">Harvard Business School</strong> and <strong class="text-slate-900">Oxford University</strong>.
                            </p>
                            <p>
                                Around 2 decades of expertise within Rental, Sales &amp; Services business of HVAC, Power and Construction equipment industry. Known in the industry as an excellent solution provider with top class customer care/support attitude. Never delivers anything less than the best. Never compromise on quality. Achieved Zero Complacency throughout my career &ndash; a multidimensional Leader.
                            </p>
                        </div>

                        <div class="pt-2 flex items-center gap-3">
                            <a href="mailto:imran@hvaclinic.com" class="inline-flex items-center gap-2 bg-[#0844bd] hover:bg-[#063696] text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md transition">
                                <i data-lucide="mail" class="size-4"></i>
                                <span>Contact Imran Ali</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Executive 2: Raghib Waqas -->
            <div class="bg-slate-50/70 rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-xs hover:shadow-xl transition-all duration-300">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- Photo Column -->
                    <div class="md:col-span-5 lg:col-span-4">
                        <div class="rounded-2xl overflow-hidden shadow-lg border-2 border-white bg-slate-200 aspect-[6/5]">
                            <img src="/wp-content/uploads/2026/03/raghi.jpg" 
                                 alt="raghib waqas" 
                                 width="720" 
                                 height="609" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Bio Column -->
                    <div class="md:col-span-7 lg:col-span-8 space-y-4">
                        <div>
                            <span class="text-xs font-extrabold text-blue-700 bg-blue-100/70 px-3 py-1 rounded-full uppercase tracking-wider">
                                Business Development &amp; Engineering
                            </span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">
                                RAGHIB WAQAS
                            </h2>
                            <h3 class="text-base font-bold text-blue-600 mt-0.5">
                                Entity Partner &amp; Business Developer
                            </h3>
                        </div>

                        <div class="text-slate-600 text-sm leading-relaxed space-y-3 pt-1">
                            <p>
                                With more than 15 years of experience in Sales, Marketing &amp; Project Engineering divisions (more than 4 years in UAE) for the Rental Power, Rental Cooling &amp; Rental Earthmoving equipment industries, I always aspire to be a valuable team leader and contributor in taking the business of a company to another level. Having worked with prestigious companies like <strong class="text-slate-900">CATERPILLAR, HINOPAK &amp; RENTAL SOLUTIONS &amp; SERVICES</strong> and with my academic background of Mechanical Engineering and MBA, I am fully geared up to provide our customers satisfactory solutions &amp; services and maintaining professional values.
                            </p>
                            <p>
                                I have been acknowledged by <strong class="text-slate-900">Caterpillar University, Geneva</strong>, as 2<sup>nd</sup> Caterpillar Certified Sales Professional (Power Generation) worldwide.
                            </p>
                            <p>
                                I have also been engaged in teaching <strong class="text-slate-900">&ldquo;Strategic Management&rdquo;</strong> as Visiting Faculty Member at <strong class="text-slate-900">Iqra University, Pakistan</strong>.
                            </p>
                        </div>

                        <div class="pt-2 flex items-center gap-3">
                            <a href="mailto:raghib@hvaclinic.com" class="inline-flex items-center gap-2 bg-[#0844bd] hover:bg-[#063696] text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md transition">
                                <i data-lucide="mail" class="size-4"></i>
                                <span>Contact Raghib Waqas</span>
                            </a>
                        </div>
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
