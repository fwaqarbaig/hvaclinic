@extends('layouts.app')

@section('seo_meta')
    <title>{{ $page?->seo_title ?: 'About HVAC Clinic | Rental Chillers & Cooling Services UAE' }}</title>
    <meta name="description" content="{{ $page?->seo_description ?: 'We provide rental chiller, cooling services and power solutions all over UAE. Contact HVAC Clinic for emergency and planned cooling solutions.' }}">
    <link rel="canonical" href="{{ $page?->canonical_url ?: rtrim(url('/about'), '/') . '/' }}">
    <meta name="robots" content="{{ $page?->is_indexable ? 'index, follow' : 'noindex, nofollow' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $page?->canonical_url ?: rtrim(url('/about'), '/') . '/' }}">
    <meta property="og:title" content="{{ $page?->og_title ?: $page?->seo_title ?: 'About HVAC Clinic' }}">
    <meta property="og:description" content="{{ $page?->og_description ?: $page?->seo_description }}">
    <meta property="og:image" content="{{ asset('wp-content/uploads/2026/03/g-2.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $page?->og_title ?: $page?->seo_title }}">
    <meta name="twitter:description" content="{{ $page?->og_description ?: $page?->seo_description }}">
    <meta name="twitter:image" content="{{ asset('wp-content/uploads/2026/03/g-2.jpg') }}">
    <!-- Schema.org AboutPage & BreadcrumbList Schema -->
    {!! \App\Services\SchemaGenerator::renderPrimary($page, fn() => $page ? \App\Services\SchemaGenerator::forPage($page) : [
        '@'.'context' => 'https://schema.org',
        '@type' => 'AboutPage',
        '@id' => rtrim(url('/about'), '/') . '/#about',
        'name' => 'About HVAC Clinic UAE',
        'description' => 'Empowering businesses and individuals across the UAE with reliable, efficient, and sustainable cooling and power solutions.',
        'url' => rtrim(url('/about'), '/') . '/',
        'about' => ['@id' => config('app.url', 'https://hvaclinic.com') . '/#organization'],
    ]) !!}
    {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::breadcrumbs([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'About', 'url' => rtrim(url('/about'), '/') . '/'],
    ])) !!}
    @if(!empty($page?->faqs))
        {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::forFaqs($page->faqs)) !!}
    @endif
@endsection

@section('content')

    <!-- Page Header Banner -->
    <section class="bg-gradient-to-r from-[#061224] via-[#091e3d] to-[#0a2347] text-white py-14 lg:py-16 border-b border-white/10 relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(37,99,235,0.15),transparent_50%)]"></div>
        <div class="site-container relative z-10">
            <nav class="flex items-center gap-2 text-xs text-slate-300 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-amber-400 transition">Home</a>
                <span class="text-white/30">&bull;</span>
                <span class="text-amber-400 font-semibold">About</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white">
                About HVAC Clinic
            </h1>
            <p class="text-slate-300 text-sm sm:text-base max-w-2xl mt-2 leading-relaxed">
                Empowering businesses and individuals across the UAE with reliable, efficient, and sustainable cooling and power solutions.
            </p>
        </div>
    </section>

    <!-- Main About Section (Split with Image & Tabs matching hvaclinic.com) -->
    <section class="py-16 sm:py-20 bg-white">
        <div class="site-container">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                
                <!-- Left Visual Image Column -->
                <div class="lg:col-span-5">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-slate-100 bg-slate-50">
                        <img src="/wp-content/uploads/2026/03/g-2.jpg" 
                             alt="rental cooling dubai" 
                             width="726" 
                             height="704" 
                             class="w-full h-auto object-cover transition-transform duration-300 hover:scale-102">
                        <div class="absolute bottom-4 left-4 right-4 bg-white/95 backdrop-blur-md p-3.5 rounded-xl border border-white/50 shadow-md flex items-center justify-between">
                            <div>
                                <div class="text-xs font-bold text-slate-900">HVAC Clinic UAE</div>
                                <div class="text-[11px] text-slate-500">24/7 Turnkey Cooling &amp; Power</div>
                            </div>
                            <span class="text-xs font-extrabold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full">ISO Certified</span>
                        </div>
                    </div>
                </div>

                <!-- Right Copy & Interactive Accordion Column -->
                <div class="lg:col-span-7 space-y-6" x-data="{ activeTab: 1 }">
                    <div>
                        <span class="text-xs font-extrabold tracking-wider text-blue-600 uppercase bg-blue-50 px-3 py-1 rounded-full">
                            Company Profile
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-3">
                            Setting the UAE Industry Standard for Quality &amp; Cooling Service
                        </h2>
                    </div>

                    <div class="text-slate-600 text-sm leading-relaxed space-y-3.5">
                        <p>
                            At <strong class="text-slate-900 font-bold">HVAC Clinic</strong>, our vision is to become the <strong class="text-slate-900 font-bold">most trusted and innovative HVAC and cooling solutions provider in the UAE</strong>. We strive to empower businesses and individuals with <strong class="text-slate-900 font-bold">reliable, efficient, and sustainable cooling and power solutions</strong>, including <strong class="text-slate-900 font-bold">rental generators, rental chillers, rental ACs, temporary cooling systems, chiller maintenance, and high-quality refurbished chillers</strong>.
                        </p>
                        <p>
                            We are committed to <strong class="text-slate-900 font-bold">excellence, innovation, and customer satisfaction</strong>, ensuring that every solution we provide enhances comfort, efficiency, and operational reliability. Through cutting-edge technology, professional expertise, and a client-focused approach, we aim to <strong class="text-slate-900 font-bold">set the industry standard for quality and service</strong>, helping our clients achieve their goals with confidence and peace of mind.
                        </p>
                    </div>

                    <!-- Interactive Accordion Tabs -->
                    <div class="border border-slate-200 rounded-xl overflow-hidden divide-y divide-slate-100 mt-6 shadow-2xs">
                        
                        <!-- Tab 1: We specialize in -->
                        <div>
                            <button type="button" 
                                    class="w-full px-5 py-4 text-left font-bold text-sm text-slate-800 hover:text-blue-700 hover:bg-slate-50/80 flex items-center justify-between transition"
                                    @click="activeTab = activeTab === 1 ? null : 1">
                                <span class="flex items-center gap-2">
                                    <i data-lucide="check-circle" class="size-4 text-blue-600"></i> We specialize in:
                                </span>
                                <i data-lucide="chevron-down" class="size-4 transition-transform duration-200" :class="activeTab === 1 ? 'rotate-180 text-blue-600' : ''"></i>
                            </button>
                            <div class="px-5 pb-5 pt-1 text-xs sm:text-sm text-slate-600 space-y-2 bg-slate-50/50" x-show="activeTab === 1" x-cloak x-transition>
                                <ul class="space-y-2">
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="zap" class="size-4 text-amber-500 shrink-0 mt-0.5"></i>
                                        <span><strong class="text-slate-900">Rental Generators</strong> – Reliable power solutions for all scales.</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="snowflake" class="size-4 text-cyan-500 shrink-0 mt-0.5"></i>
                                        <span><strong class="text-slate-900">Rental Chillers &amp; ACs</strong> – Flexible cooling solutions for events, projects, and emergencies.</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="wind" class="size-4 text-blue-500 shrink-0 mt-0.5"></i>
                                        <span><strong class="text-slate-900">Rental Cooling Equipment</strong> – Optimized temporary cooling for industries and large spaces.</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="wrench" class="size-4 text-indigo-500 shrink-0 mt-0.5"></i>
                                        <span><strong class="text-slate-900">Chiller Maintenance</strong> – Expert servicing and preventive maintenance to keep your systems running efficiently.</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="repeat" class="size-4 text-emerald-500 shrink-0 mt-0.5"></i>
                                        <span><strong class="text-slate-900">Used &amp; Refurbished Chillers</strong> – High-quality, cost-effective chiller solutions for long-term reliability.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Tab 2: Our Vision -->
                        <div>
                            <button type="button" 
                                    class="w-full px-5 py-4 text-left font-bold text-sm text-slate-800 hover:text-blue-700 hover:bg-slate-50/80 flex items-center justify-between transition"
                                    @click="activeTab = activeTab === 2 ? null : 2">
                                <span class="flex items-center gap-2">
                                    <i data-lucide="eye" class="size-4 text-blue-600"></i> Our Vision
                                </span>
                                <i data-lucide="chevron-down" class="size-4 transition-transform duration-200" :class="activeTab === 2 ? 'rotate-180 text-blue-600' : ''"></i>
                            </button>
                            <div class="px-5 pb-5 pt-1 text-xs sm:text-sm text-slate-600 leading-relaxed bg-slate-50/50" x-show="activeTab === 2" x-cloak x-transition>
                                <p>
                                    To be the <strong class="text-slate-900">leading provider of innovative, reliable, and sustainable HVAC solutions</strong> in the UAE, empowering our clients with efficient cooling, power, and maintenance services. We aim to set the standard in <strong class="text-slate-900">rental generators, chillers, ACs, and complete cooling solutions</strong>, while building long-term trust through excellence, professionalism, and cutting-edge technology.
                                </p>
                            </div>
                        </div>

                        <!-- Tab 3: Contact Us -->
                        <div>
                            <button type="button" 
                                    class="w-full px-5 py-4 text-left font-bold text-sm text-slate-800 hover:text-blue-700 hover:bg-slate-50/80 flex items-center justify-between transition"
                                    @click="activeTab = activeTab === 3 ? null : 3">
                                <span class="flex items-center gap-2">
                                    <i data-lucide="phone-call" class="size-4 text-blue-600"></i> Contact us
                                </span>
                                <i data-lucide="chevron-down" class="size-4 transition-transform duration-200" :class="activeTab === 3 ? 'rotate-180 text-blue-600' : ''"></i>
                            </button>
                            <div class="px-5 pb-5 pt-1 text-xs sm:text-sm text-slate-600 leading-relaxed bg-slate-50/50" x-show="activeTab === 3" x-cloak x-transition>
                                <p>
                                    Have a project or need HVAC support? <strong class="text-slate-900">Contact us today</strong> for expert advice, quick support, and tailored solutions. At <strong class="text-slate-900">HVAC Clinic</strong>, your comfort and satisfaction are our top priority.
                                </p>
                                <div class="mt-3 flex items-center gap-3">
                                    <a href="tel:+971503692131" class="text-xs font-bold text-blue-700 hover:underline flex items-center gap-1">
                                        <i class="fas fa-phone"></i> +971 50 369 2131
                                    </a>
                                    <span class="text-slate-300">|</span>
                                    <a href="mailto:info@hvaclinic.com" class="text-xs font-bold text-blue-700 hover:underline flex items-center gap-1">
                                        <i class="fas fa-envelope"></i> info@hvaclinic.com
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- Section 2: Reliable HVAC & Cooling Solutions in UAE Cards (matching hvaclinic.com) -->
    <section class="py-16 sm:py-20 bg-slate-50 border-t border-slate-200">
        <div class="site-container">
            
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-extrabold tracking-wider text-blue-600 uppercase bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                    Our Core Divisions
                </span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-3">
                    Reliable HVAC &amp; Cooling Solutions in UAE
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                
                <!-- Card 1: Rental Cooling -->
                <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs hover:shadow-xl transition-all duration-200 flex flex-col justify-between group">
                    <div>
                        <div class="aspect-[16/9] overflow-hidden bg-slate-100">
                            <img src="/wp-content/uploads/2026/03/cooling.jpg" 
                                 alt="Top 5 HVAC Rental Companies in UAE" 
                                 width="1024" 
                                 height="560" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-900 group-hover:text-blue-700 transition mb-2">Rental Cooling</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Keep your spaces cool with our <strong class="text-slate-800">rental chillers</strong>, designed for short-term or long-term use. Perfect for events, commercial projects, and emergency cooling needs.
                            </p>
                        </div>
                    </div>
                    <div class="p-6 pt-0">
                        <a href="/services/rental-cooling/" class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-blue-700 hover:bg-blue-800 px-4 py-2.5 rounded-xl shadow-xs transition">
                            <span>click more...</span>
                            <i data-lucide="arrow-right" class="size-3.5"></i>
                        </a>
                    </div>
                </div>

                <!-- Card 2: Rental Power -->
                <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs hover:shadow-xl transition-all duration-200 flex flex-col justify-between group">
                    <div>
                        <div class="aspect-[16/9] overflow-hidden bg-slate-100">
                            <img src="/wp-content/uploads/2026/03/power-1.jpg" 
                                 alt="Generator Repair in Dubai" 
                                 width="1024" 
                                 height="560" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-900 group-hover:text-blue-700 transition mb-2">Rental Power</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Ensure uninterrupted power for your projects or events with our <strong class="text-slate-800">reliable rental generators</strong>. We provide solutions for all scales, from small offices to large industrial setups.
                            </p>
                        </div>
                    </div>
                    <div class="p-6 pt-0">
                        <a href="/services/generator-rental-in-uae/" class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-blue-700 hover:bg-blue-800 px-4 py-2.5 rounded-xl shadow-xs transition">
                            <span>click more...</span>
                            <i data-lucide="arrow-right" class="size-3.5"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Section 3: Get Free Appointment & Consultation Intake (matching hvaclinic.com) -->
    <section class="py-16 sm:py-20 bg-gradient-to-b from-[#08172e] to-[#040e1e] text-white relative">
        <div class="site-container max-w-4xl mx-auto">
            
            <div class="text-center space-y-4 mb-10">
                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-cyan-400 border border-blue-500/20 flex items-center justify-center mx-auto">
                    <i data-lucide="snowflake" class="size-6"></i>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                    Looking for reliable HVAC rental or maintenance services? Contact HVAC Clinic today
                </h2>
                <p class="text-xs sm:text-sm text-slate-300">
                    Call us directly: 
                    <a href="tel:+971503692131" class="text-amber-400 font-bold hover:underline">+971 50 369 2131</a> &ndash; 
                    <a href="tel:+971506457285" class="text-amber-400 font-bold hover:underline">+971 50 645 7285</a>
                </p>
            </div>

            <!-- Form Card matching wpforms-67 -->
            <div class="bg-white rounded-2xl p-6 sm:p-8 text-slate-900 shadow-2xl border border-slate-100">
                <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 mb-5 flex items-center justify-between">
                    <span>Get Free Appointment</span>
                    <span class="text-xs font-normal text-slate-400">* Required fields</span>
                </h3>

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-xs font-bold text-slate-700 mb-1">First Name <span class="text-rose-500">*</span></label>
                            <input type="text" id="first_name" name="name" required placeholder="First Name *" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 outline-none transition">
                        </div>
                        <div>
                            <label for="last_name" class="block text-xs font-bold text-slate-700 mb-1">Last Name <span class="text-rose-500">*</span></label>
                            <input type="text" id="last_name" name="last_name" required placeholder="Last Name *" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 outline-none transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="about_email" class="block text-xs font-bold text-slate-700 mb-1">Email <span class="text-rose-500">*</span></label>
                            <input type="email" id="about_email" name="email" required placeholder="Your Email *" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 outline-none transition">
                        </div>
                        <div>
                            <label for="about_phone" class="block text-xs font-bold text-slate-700 mb-1">Phone Number <span class="text-rose-500">*</span></label>
                            <input type="tel" id="about_phone" name="phone" required placeholder="Your Phone Number" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label for="about_service" class="block text-xs font-bold text-slate-700 mb-1">Select Service</label>
                        <select id="about_service" name="service" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 outline-none transition bg-white">
                            <option value="Rental Chiller">Rental Chiller</option>
                            <option value="Rental Generator">Rental Generator</option>
                            <option value="Temporary Cooling">Temporary Cooling</option>
                            <option value="Generator Maintenance">Generator Maintenance</option>
                            <option value="Chiller Maintenance">Chiller Maintenance</option>
                            <option value="Used Chiller">Used Chiller</option>
                            <option value="HVAC Consultancy">HVAC Consultancy</option>
                        </select>
                    </div>

                    <div>
                        <label for="about_message" class="block text-xs font-bold text-slate-700 mb-1">Comment or Message <span class="text-rose-500">*</span></label>
                        <textarea id="about_message" name="message" rows="3" required placeholder="Message *" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 outline-none transition resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3.5 px-6 rounded-xl font-bold text-sm text-white bg-[#0844bd] hover:bg-[#063696] shadow-md shadow-blue-900/10 hover:shadow-lg transition flex items-center justify-center gap-2">
                        <span>Send Message</span>
                        <i data-lucide="send" class="size-4"></i>
                    </button>
                </form>
            </div>

        </div>
    </section>

@endsection
