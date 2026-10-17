<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon & Icons -->
    <link rel="icon" type="image/png" sizes="32x32" href="/wp-content/uploads/2026/04/fav.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/wp-content/uploads/2026/04/fav.png">
    <link rel="apple-touch-icon" href="/wp-content/uploads/2026/04/fav.png">
    <meta name="msapplication-TileImage" content="/wp-content/uploads/2026/04/fav.png">

    @if(config('services.google.search_console_verification'))
        <meta name="google-site-verification" content="{{ config('services.google.search_console_verification') }}">
    @endif

    @hasSection('seo_meta')
        @yield('seo_meta')
    @else
        <title>Rental Chiller &amp; AC Solutions UAE | HVAC Clinic</title>
        <meta name="description" content="Rental high-performance chillers, temporary cooling, AC rental, and power generator solutions in UAE with HVAC Clinic. Fast delivery, flexible terms, and 24/7 support.">
        <link rel="canonical" href="{{ url()->current() === url('/') ? url('/') : rtrim(url()->current(), '/').'/' }}">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="HVACLINIC">
        <meta property="og:title" content="Rental Chiller &amp; AC Solutions UAE | HVAC Clinic">
        <meta property="og:description" content="Rental high-performance chillers, temporary cooling, AC rental, and power generator solutions in UAE with HVAC Clinic. Fast delivery, flexible terms, and 24/7 support.">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{ asset('wp-content/uploads/2026/03/1.jpg') }}">
        <meta name="twitter:card" content="summary_large_image">
    @endif

    <!-- Schema.org Global HVACBusiness & WebSite Graph Markup -->
    {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::globalGraph()) !!}

    <!-- Google Fonts & Font Awesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sen:wght@700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="site-shell min-h-full flex flex-col antialiased bg-slate-50 text-slate-800" 
      x-data="{ mobileMenuOpen: false, openDropdown: null, mobileAboutOpen: false, mobileServicesOpen: false, mobileActiveCat: null }">

    <!-- Top Bar: Contact & Hours -->
    <div class="site-topbar bg-[#0a1e3b] text-slate-200 text-xs py-2 border-b border-white/10">
        <div class="site-container flex items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_8px_#34d399]"></span>
                <span class="font-medium text-slate-300">24/7 HVAC &amp; Power Emergency Hotline UAE</span>
            </div>
            <div class="flex items-center gap-4 font-semibold">
                <a href="tel:+971503692131" class="hover:text-amber-400 transition flex items-center gap-1.5">
                    <i class="fas fa-phone-alt text-[10px] text-amber-400"></i> +971 50 369 2131
                </a>
                <span class="text-white/20 hidden sm:inline">|</span>
                <a href="tel:+971506457285" class="hover:text-amber-400 transition hidden sm:flex items-center gap-1.5">
                    <i class="fas fa-mobile-alt text-[10px] text-amber-400"></i> +971 50 645 7285
                </a>
                <span class="text-white/20 hidden md:inline">|</span>
                <a href="mailto:info@hvaclinic.com" class="hover:text-amber-400 transition hidden md:flex items-center gap-1.5">
                    <i class="fas fa-envelope text-[10px] text-amber-400"></i> info@hvaclinic.com
                </a>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="site-header sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="site-container flex items-center justify-between min-h-[78px] gap-4">
            
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="site-brand flex items-center gap-3 shrink-0 py-2" aria-label="HVAC Clinic Home">
                <img src="/wp-content/uploads/2026/03/hvac.gif" 
                     alt="HVAC Clinic UAE" 
                     width="220" 
                     height="65" 
                     class="h-10 sm:h-12 w-auto object-contain transition-transform duration-200 hover:scale-[1.02]">
            </a>

            <!-- Desktop Navigation -->
            <nav class="site-nav hidden lg:flex items-center gap-1 xl:gap-2" aria-label="Main navigation">
                @if(isset($headerMenuItems) && $headerMenuItems->isNotEmpty())
                    @foreach($headerMenuItems as $item)
                        @if($item->title === 'About')
                            <!-- About Dropdown -->
                            <div class="site-nav-item relative" 
                                 @mouseenter="openDropdown = 'about'" 
                                 @mouseleave="openDropdown = null">
                                <a href="{{ $item->getUrl() }}" 
                                   class="site-nav-link px-3.5 py-2 font-semibold text-slate-700 hover:text-blue-700 transition flex items-center gap-1.5 text-[14px]">
                                    {{ $item->title }}
                                    <i data-lucide="chevron-down" class="size-3.5 transition-transform duration-200" :class="openDropdown === 'about' ? 'rotate-180 text-blue-600' : ''"></i>
                                </a>
                                <div class="site-dropdown-menu absolute left-0 top-full pt-1 w-56" 
                                     x-show="openDropdown === 'about'" 
                                     x-cloak 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-2">
                                    <div class="bg-white rounded-xl shadow-xl border border-slate-100 p-2 divide-y divide-slate-50">
                                        @foreach($item->activeChildren as $child)
                                            <a href="{{ $child->getUrl() }}" 
                                               class="block px-3.5 py-2.5 rounded-lg text-[13px] font-semibold text-slate-700 hover:text-blue-700 hover:bg-blue-50/70 transition">
                                                {{ $child->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @elseif($item->title === 'Services')
                            <!-- Services Dropdown (Direct 7 Core Services Only) -->
                            <div class="site-nav-item" 
                                 @mouseenter="openDropdown = 'services'" 
                                 @mouseleave="openDropdown = null">
                                <a href="{{ $item->getUrl() }}" 
                                   class="site-nav-link px-3.5 py-2 font-semibold text-slate-700 hover:text-blue-700 transition flex items-center gap-1.5 text-[14px]">
                                    {{ $item->title }}
                                    <i data-lucide="chevron-down" class="size-3.5 transition-transform duration-200" :class="openDropdown === 'services' ? 'rotate-180 text-blue-600' : ''"></i>
                                </a>
                                <div class="site-mega-menu fixed left-0 right-0 top-[114px] px-4" 
                                     x-show="openDropdown === 'services'" 
                                     x-cloak 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-2">
                                    <div class="site-container max-w-5xl mx-auto bg-white rounded-2xl shadow-2xl border border-slate-200/90 overflow-hidden">
                                        @php
                                            $serviceIcons = [
                                                'Rental Chiller' => ['icon' => 'snowflake', 'desc' => 'Air & water-cooled rental chillers 50 to 1500 TR for emergency cooling', 'color' => 'text-blue-600 bg-blue-50 border-blue-100'],
                                                'Rental Chiller in UAE' => ['icon' => 'snowflake', 'desc' => 'Air & water-cooled rental chillers 50 to 1500 TR for emergency cooling', 'color' => 'text-blue-600 bg-blue-50 border-blue-100'],
                                                'Rental Cooling' => ['icon' => 'snowflake', 'desc' => 'Industrial chillers & air handlers for high-capacity temporary cooling', 'color' => 'text-blue-600 bg-blue-50 border-blue-100'],
                                                'Rental AC' => ['icon' => 'wind', 'desc' => 'Ducted package units, spot coolers & floor-standing commercial AC', 'color' => 'text-sky-600 bg-sky-50 border-sky-100'],
                                                'Wild Air Rental' => ['icon' => 'fan', 'desc' => 'High-velocity temporary air circulation & site fresh air ventilation', 'color' => 'text-teal-600 bg-teal-50 border-teal-100'],
                                                'Chiller Maintenance' => ['icon' => 'wrench', 'desc' => '24/7 emergency repair, overhaul & annual preventive AMC contracts', 'color' => 'text-indigo-600 bg-indigo-50 border-indigo-100'],
                                                'AC Maintenance & Repair' => ['icon' => 'wrench', 'desc' => 'Certified AC repair, coil cleaning & AMC contracts for residential & commercial HVAC', 'color' => 'text-cyan-600 bg-cyan-50 border-cyan-100'],
                                                'AC Maintenance' => ['icon' => 'wrench', 'desc' => 'Certified AC repair, coil cleaning & AMC contracts for residential & commercial HVAC', 'color' => 'text-cyan-600 bg-cyan-50 border-cyan-100'],
                                                'Rental Generator' => ['icon' => 'zap', 'desc' => '50 kVA to 1500 kVA quiet diesel generators for heavy-duty power', 'color' => 'text-amber-600 bg-amber-50 border-amber-100'],
                                                'Rental Power' => ['icon' => 'plug', 'desc' => 'Turnkey temporary power distribution, synchronized panels & cabling', 'color' => 'text-orange-600 bg-orange-50 border-orange-100'],
                                                'Used & Refurbished' => ['icon' => 'refresh-cw', 'desc' => 'Tested, load-verified & certified pre-owned chillers and generators', 'color' => 'text-emerald-600 bg-emerald-50 border-emerald-100'],
                                                'USed & Refurbished' => ['icon' => 'refresh-cw', 'desc' => 'Tested, load-verified & certified pre-owned chillers and generators', 'color' => 'text-emerald-600 bg-emerald-50 border-emerald-100'],
                                            ];

                                        @endphp
                                        <div class="p-5 lg:p-6 grid grid-cols-1 md:grid-cols-2 gap-3.5 bg-slate-50/50">
                                            @foreach($item->activeChildren as $serviceCat)
                                                @php
                                                    $meta = $serviceIcons[$serviceCat->title] ?? [
                                                        'icon' => 'check-circle-2',
                                                        'desc' => 'Engineered cooling and power rental solutions across UAE',
                                                        'color' => 'text-blue-600 bg-blue-50 border-blue-100'
                                                    ];
                                                @endphp
                                                <a href="{{ $serviceCat->getUrl() }}" 
                                                   class="group flex items-start gap-3.5 p-3.5 rounded-xl bg-white border border-slate-200/80 hover:border-blue-400 hover:shadow-md hover:bg-gradient-to-r hover:from-white hover:to-blue-50/40 transition-all duration-200">
                                                    <div class="size-10 rounded-lg {{ $meta['color'] }} border flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                                        <i data-lucide="{{ $meta['icon'] }}" class="size-5"></i>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center justify-between">
                                                            <span class="text-[14px] font-bold text-slate-900 group-hover:text-blue-700 transition-colors">
                                                                {{ $serviceCat->title }}
                                                            </span>
                                                            <i data-lucide="arrow-right" class="size-3.5 text-blue-500 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all"></i>
                                                        </div>
                                                        <p class="text-[12px] text-slate-500 leading-snug mt-0.5 line-clamp-1">
                                                            {{ $meta['desc'] }}
                                                        </p>
                                                    </div>
                                                </a>
                                            @endforeach

                                            <!-- Rapid Emergency Dispatch Card (spans full width across 2 cols) -->
                                            <div class="md:col-span-2 flex items-center justify-between gap-3.5 p-3.5 rounded-xl bg-gradient-to-br from-slate-900 to-blue-950 border border-blue-900/40 shadow-xs text-white">
                                                <div class="flex items-center gap-3">
                                                    <div class="size-10 rounded-lg bg-blue-800/60 text-amber-400 flex items-center justify-center shrink-0">
                                                        <i data-lucide="phone-call" class="size-5"></i>
                                                    </div>
                                                    <div>
                                                        <div class="flex items-center gap-1.5">
                                                            <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_8px_#34d399] animate-pulse"></span>
                                                            <span class="text-[11px] font-bold text-emerald-300 uppercase tracking-wider">Rapid Dispatch Across All 7 Emirates</span>
                                                        </div>
                                                        <p class="text-[11px] text-slate-300 leading-snug mt-0.5">
                                                            Turnkey chillers and generators delivered within 60–120 minutes.
                                                        </p>
                                                    </div>
                                                </div>
                                                <a href="tel:+971503692131" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-amber-400 text-slate-900 font-bold text-xs hover:bg-amber-300 transition shrink-0">
                                                    <i data-lucide="phone" class="size-3.5"></i>
                                                    <span>+971 50 369 2131</span>
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <!-- Mega Menu Banner Strip -->
                                        <div class="bg-gradient-to-r from-[#0a1e3b] to-[#103a7a] text-white px-6 py-3 flex flex-wrap items-center justify-between gap-4 text-xs font-medium">
                                            <div class="flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                                <span>Emergency HVAC Breakdown? Turnkey cooling delivered within 2 hours across UAE.</span>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <a href="/services/" class="text-white hover:text-amber-300 font-semibold underline underline-offset-4 decoration-white/40 hover:decoration-amber-300 transition">
                                                    View All Services &rarr;
                                                </a>
                                                <a href="{{ route('contact') }}" class="bg-amber-400 text-slate-900 px-3.5 py-1 rounded-full font-bold hover:bg-amber-300 transition">
                                                    Book Appointment
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Standard Item (Home, Blogs, Contact us) -->
                            <a href="{{ $item->getUrl() }}" 
                               class="site-nav-link px-3.5 py-2 font-semibold text-slate-700 hover:text-blue-700 transition text-[14px] {{ $item->isActive() ? 'text-blue-700 font-bold' : '' }}">
                                {{ $item->title }}
                            </a>
                        @endif
                    @endforeach
                @else
                    <a href="{{ route('home') }}" class="site-nav-link px-3.5 py-2 font-semibold text-slate-700 hover:text-blue-700 text-[14px]">Home</a>
                    <a href="/about/" class="site-nav-link px-3.5 py-2 font-semibold text-slate-700 hover:text-blue-700 text-[14px]">About</a>
                    <a href="/services/" class="site-nav-link px-3.5 py-2 font-semibold text-slate-700 hover:text-blue-700 text-[14px]">Services</a>
                    <a href="/blog/" class="site-nav-link px-3.5 py-2 font-semibold text-slate-700 hover:text-blue-700 text-[14px]">Blogs</a>

                    <a href="/contact/" class="site-nav-link px-3.5 py-2 font-semibold text-slate-700 hover:text-blue-700 text-[14px]">Contact us</a>
                @endif
            </nav>

            <!-- Header Actions -->
            <div class="flex items-center gap-3 shrink-0">
                @auth
                    @if(auth()->user()->canManageContent())
                        <a href="{{ route('admin.dashboard') }}" 
                           class="hidden md:inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-blue-700 bg-slate-100 px-3 py-2 rounded-lg transition">
                            <i data-lucide="layout-dashboard" class="size-3.5"></i> Admin
                        </a>
                    @endif
                @endauth

                <!-- Book Appointment Primary CTA Button -->
                <a href="{{ route('contact') }}" 
                   class="site-btn-appointment inline-flex items-center gap-2 bg-[#0844bd] hover:bg-[#07389e] text-white px-5 py-2.5 rounded-full font-bold text-[13px] shadow-md shadow-blue-900/10 hover:shadow-lg hover:shadow-blue-900/20 transition-all transform hover:-translate-y-0.5">
                    <span>Book Appointment</span>
                    <i data-lucide="arrow-up-right" class="size-4"></i>
                </a>

                <!-- Mobile Menu Hamburger Button -->
                <button type="button" 
                        class="lg:hidden p-2 rounded-xl text-slate-700 hover:bg-slate-100 transition"
                        @click="mobileMenuOpen = !mobileMenuOpen" 
                        :aria-expanded="mobileMenuOpen" 
                        aria-label="Toggle navigation menu">
                    <i data-lucide="menu" class="size-6" x-show="!mobileMenuOpen"></i>
                    <i data-lucide="x" class="size-6" x-show="mobileMenuOpen" x-cloak></i>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Navigation (Slide-down) -->
        <div class="lg:hidden bg-white border-b border-slate-200 shadow-xl overflow-y-auto max-h-[calc(100vh-120px)]" 
             x-show="mobileMenuOpen" 
             x-cloak 
             x-transition>
            <div class="p-4 space-y-2">
                
                <!-- Home Link -->
                <a href="{{ route('home') }}" 
                   class="block px-3 py-2.5 rounded-lg font-bold text-slate-800 hover:bg-blue-50 hover:text-blue-700" 
                   @click="mobileMenuOpen = false">
                    Home
                </a>

                <!-- About Accordion -->
                <div class="border-t border-slate-100 pt-1">
                    <button type="button" 
                            class="w-full flex items-center justify-between px-3 py-2.5 font-bold text-slate-800 hover:bg-blue-50 hover:text-blue-700 rounded-lg"
                            @click="mobileAboutOpen = !mobileAboutOpen">
                        <span>About</span>
                        <i data-lucide="chevron-down" class="size-4 transition-transform duration-200" :class="mobileAboutOpen ? 'rotate-180 text-blue-600' : ''"></i>
                    </button>
                    <div class="pl-4 pr-2 space-y-1 bg-slate-50/70 rounded-lg p-2 mt-1" x-show="mobileAboutOpen" x-cloak x-transition>
                        <a href="/about/" class="block px-3 py-2 text-sm font-semibold text-slate-700 hover:text-blue-700" @click="mobileMenuOpen = false">About HVAC</a>
                        <a href="/our-team/" class="block px-3 py-2 text-sm font-semibold text-slate-700 hover:text-blue-700" @click="mobileMenuOpen = false">Our Team</a>
                        <a href="/membership/" class="block px-3 py-2 text-sm font-semibold text-slate-700 hover:text-blue-700" @click="mobileMenuOpen = false">Membership</a>
                        <a href="/certificates/" class="block px-3 py-2 text-sm font-semibold text-slate-700 hover:text-blue-700" @click="mobileMenuOpen = false">Certificates</a>
                    </div>
                </div>

                <!-- Services Accordion -->
                <div class="border-t border-slate-100 pt-1">
                    <button type="button" 
                            class="w-full flex items-center justify-between px-3 py-2.5 font-bold text-slate-800 hover:bg-blue-50 hover:text-blue-700 rounded-lg"
                            @click="mobileServicesOpen = !mobileServicesOpen">
                        <span>Services</span>
                        <i data-lucide="chevron-down" class="size-4 transition-transform duration-200" :class="mobileServicesOpen ? 'rotate-180 text-blue-600' : ''"></i>
                    </button>
                    <div class="pl-2 pr-2 space-y-1 bg-slate-50/80 rounded-xl p-2.5 mt-1" x-show="mobileServicesOpen" x-cloak x-transition>
                        @if(isset($headerMenuItems))
                            @php
                                $servicesMenuItem = $headerMenuItems->firstWhere('title', 'Services');
                            @endphp
                            @if($servicesMenuItem && $servicesMenuItem->activeChildren->isNotEmpty())
                                @foreach($servicesMenuItem->activeChildren as $serviceCat)
                                    <a href="{{ $serviceCat->getUrl() }}" 
                                       class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:text-blue-700 hover:bg-blue-100/60 transition"
                                       @click="mobileMenuOpen = false">
                                        <span>{{ $serviceCat->title }}</span>
                                        <i data-lucide="chevron-right" class="size-3.5 text-slate-400"></i>
                                    </a>
                                @endforeach
                            @endif
                        @endif
                        <a href="/services/" class="block text-center text-xs font-bold text-blue-700 pt-2 border-t border-slate-200/60 mt-1" @click="mobileMenuOpen = false">View All Services &rarr;</a>
                    </div>
                </div>

                <!-- Blogs & Contact us Links -->
                <div class="border-t border-slate-100 pt-1">
                    <a href="/blog/" 
                       class="block px-3 py-2.5 rounded-lg font-bold text-slate-800 hover:bg-blue-50 hover:text-blue-700" 
                       @click="mobileMenuOpen = false">
                        Blogs
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="block px-3 py-2.5 rounded-lg font-bold text-slate-800 hover:bg-blue-50 hover:text-blue-700" 
                       @click="mobileMenuOpen = false">
                        Contact us
                    </a>
                </div>

                <!-- Action Buttons in Mobile -->
                <div class="pt-3 pb-2 space-y-2.5 border-t border-slate-100">
                    <a href="{{ route('contact') }}" 
                       class="w-full flex items-center justify-center gap-2 bg-[#0844bd] text-white py-3 rounded-xl font-bold text-sm shadow-md"
                       @click="mobileMenuOpen = false">
                        Book Appointment <i data-lucide="arrow-up-right" class="size-4"></i>
                    </a>
                    <div class="grid grid-cols-2 gap-2 text-center text-xs font-bold pt-1">
                        <a href="tel:+971503692131" class="bg-slate-100 text-slate-800 py-2.5 rounded-lg flex items-center justify-center gap-1.5">
                            <i class="fas fa-phone text-blue-600"></i> +971503692131
                        </a>
                        <a href="https://wa.me/971503692131?text=Hi%2C%20i%20am%20interested%20on%20HVAC%20Services." target="_blank" class="bg-emerald-50 text-emerald-800 py-2.5 rounded-lg flex items-center justify-center gap-1.5 border border-emerald-200">
                            <i class="fab fa-whatsapp text-emerald-600 text-sm"></i> WhatsApp
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- Main Content Body -->
    <main class="site-main flex-1">
        @if(session('success'))
            <div class="site-container pt-5">
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 font-semibold text-sm flex items-center gap-2" role="status">
                    <i data-lucide="check-circle" class="size-5 text-emerald-600 shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Professional 4-Column Footer -->
    <footer id="footer" class="site-footer bg-[#0a1e3b] text-slate-300 pt-16 pb-8 border-t border-white/10">
        <div class="site-container">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10 pb-12 border-b border-white/10">
                
                <!-- Column 1: About HVAC Clinic & Core Links -->
                <div class="space-y-4">
                    <div class="bg-white/95 p-2 rounded-lg inline-block shadow-sm">
                        <img src="/wp-content/uploads/2026/03/hvac.gif" alt="HVAC Clinic" class="h-10 w-auto object-contain">
                    </div>
                    <h3 class="text-white font-bold text-base">About HVAC Clinic</h3>
                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                        HVAC Clinic is the UAE's premier provider of engineered temporary cooling, rental chillers, emergency air conditioning, and turnkey power generation across Dubai, Abu Dhabi, and the Northern Emirates.
                    </p>
                    <div class="pt-2 flex flex-wrap gap-x-2 gap-y-1 text-xs font-semibold text-blue-300">
                        <a href="/about/" class="hover:text-white transition">About</a> &bull;
                        <a href="/our-team/" class="hover:text-white transition">Our Team</a> &bull;
                        <a href="/membership/" class="hover:text-white transition">Membership</a> &bull;
                        <a href="/certificates/" class="hover:text-white transition">Certificates</a> &bull;
                        <a href="/odoo" class="hover:text-white transition">Odoo Partner</a> &bull;
                        <a href="/site-directory/" class="text-amber-400 hover:text-amber-300 transition">Site Directory</a>
                    </div>
                </div>

                <!-- Column 2: Core Engineering Services (All 8 Services) -->
                <div class="space-y-4">
                    <h3 class="text-white font-bold text-base border-b border-white/10 pb-2">Core Services</h3>
                    <ul class="space-y-1.5 text-xs text-slate-300">
                        <li><a href="/services/rental-chiller-in-uae/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-amber-400">&bull;</span> Rental Chiller in UAE</a></li>
                        <li><a href="/services/rental-cooling/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-amber-400">&bull;</span> Rental Cooling</a></li>
                        <li><a href="/services/rental-ac-in-uae/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-amber-400">&bull;</span> Rental AC &amp; Spot Coolers</a></li>
                        <li><a href="/services/ac-maintenance-repair-uae/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-amber-400">&bull;</span> AC Maintenance &amp; Repair</a></li>
                        <li><a href="/services/wild-air-rental-in-uae/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-amber-400">&bull;</span> Wild Air &amp; Ventilation</a></li>
                        <li><a href="/services/chiller-maintenance-in-uae/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-amber-400">&bull;</span> Chiller Maintenance &amp; AMC</a></li>
                        <li><a href="/services/generator-rental-in-uae/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-amber-400">&bull;</span> Diesel Generator Rental</a></li>
                        <li><a href="/services/generator-maintenance-repair-in-uae/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-amber-400">&bull;</span> Rental Power &amp; Distribution</a></li>
                        <li><a href="/used-refurbished-equipment-in-uae/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-amber-400">&bull;</span> Used &amp; Refurbished Chillers</a></li>
                    </ul>
                </div>

                <!-- Column 3: Topical Knowledge Hubs (Blog Categories) -->
                <div class="space-y-4">
                    <h3 class="text-white font-bold text-base border-b border-white/10 pb-2">Knowledge Hubs</h3>
                    <ul class="space-y-1.5 text-xs text-slate-300">
                        <li><a href="/category/chiller-rental/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-sky-400">&bull;</span> Chiller Rental Guides</a></li>
                        <li><a href="/category/rental-cooling/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-sky-400">&bull;</span> Temporary Cooling Insights</a></li>
                        <li><a href="/category/rental-ac/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-sky-400">&bull;</span> Commercial AC Solutions</a></li>
                        <li><a href="/category/wild-air/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-sky-400">&bull;</span> Wild Air &amp; Ventilation</a></li>
                        <li><a href="/category/chiller-maintenance/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-sky-400">&bull;</span> Chiller Maintenance UAE</a></li>
                        <li><a href="/category/chiller-amc/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-sky-400">&bull;</span> Chiller AMC in Dubai</a></li>
                        <li><a href="/category/used-chillers/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-sky-400">&bull;</span> Refurbished Chillers</a></li>
                        <li><a href="/category/rental-power/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-sky-400">&bull;</span> Rental Power &amp; Generators</a></li>
                        <li><a href="/category/packaged-units/" class="hover:text-white transition flex items-center gap-1.5"><span class="text-sky-400">&bull;</span> Packaged AC Units</a></li>
                        <li class="pt-1"><a href="/blog/" class="text-sky-400 hover:text-white transition font-semibold flex items-center gap-1">&bull; Browse All 270+ Guides &rarr;</a></li>
                    </ul>
                </div>

                <!-- Column 4: 24/7 Dispatch, Hotline & Sitemaps -->
                <div class="space-y-4">
                    <h3 class="text-white font-bold text-base border-b border-white/10 pb-2">24/7 Emergency Dispatch</h3>
                    <div class="text-xs text-slate-300 space-y-2">
                        <p class="font-bold text-white flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-amber-400"></i> UAE Regional Depot
                        </p>
                        <p class="text-[11px] text-slate-400">AFZA &ndash; Rapid Dispatch Across All 7 Emirates (60–120 Min Response).</p>
                        
                        <div class="pt-1 space-y-1.5 text-xs">
                            <p class="flex items-center gap-2">
                                <strong class="text-white">Emergency:</strong> <a href="tel:+971503692131" class="text-amber-400 hover:underline font-mono font-bold">+971 50 369 2131</a>
                            </p>
                            <p class="flex items-center gap-2">
                                <strong class="text-white">Secondary:</strong> <a href="tel:+971506457285" class="hover:text-amber-400 font-mono">+971 50 645 7285</a>
                            </p>
                            <p class="flex items-center gap-2">
                                <strong class="text-white">Landline:</strong> <a href="tel:+97144414927" class="hover:text-amber-400 font-mono">+971 4 441 4927</a>
                            </p>
                            <p class="flex items-center gap-2">
                                <strong class="text-white">Email:</strong> <a href="mailto:info@hvaclinic.com" class="hover:text-amber-400">info@hvaclinic.com</a>
                            </p>
                        </div>

                        <div class="pt-2 flex items-center gap-3">
                            <a href="/site-directory/" class="px-2.5 py-1 rounded bg-amber-400/10 border border-amber-400/30 text-amber-300 hover:bg-amber-400/20 transition text-[11px] font-bold">
                                Site Directory
                            </a>
                            <a href="/sitemap_index.xml" class="px-2.5 py-1 rounded bg-sky-400/10 border border-sky-400/30 text-sky-300 hover:bg-sky-400/20 transition text-[11px] font-bold">
                                XML Sitemap
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright Strip -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
                <p>Copyright &copy; {{ date('Y') }} HVAC Clinic. All rights reserved.</p>
                <div class="flex items-center gap-4 font-medium flex-wrap">
                    <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                    <a href="/about/" class="hover:text-white transition">About</a>
                    <a href="/services/" class="hover:text-white transition">Services</a>
                    <a href="/blog/" class="hover:text-white transition">Knowledge Base</a>
                    <a href="/site-directory/" class="text-amber-400 hover:text-amber-300 font-semibold transition">Site Directory</a>
                    <a href="/sitemap_index.xml" class="hover:text-white transition">XML Sitemap</a>
                    <a href="{{ route('contact') }}" class="hover:text-white transition">Contact</a>
                    <a href="{{ route('login') }}" class="hover:text-white transition">Admin Login</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Click to WhatsApp Widget -->
    <a href="https://wa.me/971503692131?text=Hi%2C%20i%20am%20interested%20on%20HVAC%20Services." 
       target="_blank" 
       rel="noopener noreferrer" 
       class="site-whatsapp-float fixed bottom-5 right-5 z-50 flex items-center gap-2 bg-[#25D366] hover:bg-[#1faa4f] text-white px-4 py-2.5 rounded-full shadow-2xl transition-all duration-300 hover:scale-105 group"
       aria-label="WhatsApp Us">
        <i class="fab fa-whatsapp text-2xl"></i>
        <span class="font-bold text-sm tracking-wide">WhatsApp us</span>
    </a>

    <script>
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons();
        }
    </script>
    @stack('scripts')
</body>
</html>
