@extends('layouts.app')

@section('seo_meta')
    <title>{{ $page?->seo_title ?: 'Contact HVAC Clinic Dubai | 24/7 Emergency Chiller & Power Solutions UAE' }}</title>
    <meta name="description" content="{{ $page?->seo_description ?: 'Contact HVAC Clinic UAE. Emergency chiller rental, temporary AC, wild air ventilation, generator power & chiller maintenance. Call +971 50 369 2131 for 24/7 rapid dispatch.' }}">
    <link rel="canonical" href="{{ $page?->canonical_url ?: 'https://hvaclinic.com/contact/' }}">
    <meta name="robots" content="{{ $page?->is_indexable === false ? 'noindex, nofollow' : 'index, follow' }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="HVAC Clinic">
    <meta property="og:title" content="{{ $page?->og_title ?: 'Contact HVAC Clinic Dubai | 24/7 Emergency Chiller & Power UAE' }}">
    <meta property="og:description" content="{{ $page?->og_description ?: 'Connect with HVAC Clinic UAE for rapid rental cooling, power generation, chiller maintenance & equipment trading across Dubai, Abu Dhabi and all 7 Emirates.' }}">
    <meta property="og:url" content="{{ $page?->canonical_url ?: 'https://hvaclinic.com/contact/' }}">
    <meta property="og:image" content="{{ $page?->seo_image ?: asset('wp-content/uploads/2026/03/1.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Schema.org ContactPage, HVACBusiness & BreadcrumbList Schema -->
    {!! \App\Services\SchemaGenerator::renderPrimary($page, fn() => [
        '@'.'context' => 'https://schema.org',
        '@type' => 'ContactPage',
        '@id' => rtrim(url('/contact'), '/') . '/#contactpage',
        'url' => rtrim(url('/contact'), '/') . '/',
        'name' => 'Contact HVAC Clinic UAE | 24/7 Chiller & Power Engineering Dispatch',
        'description' => 'Contact HVAC Clinic Dubai & UAE for emergency chiller rental, temporary AC, wild air systems, and silent generators. 24/7 hotline +971 50 369 2131.',
        'mainEntity' => ['@id' => config('app.url', 'https://hvaclinic.com') . '/#organization'],
    ]) !!}
    {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::breadcrumbs([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Contact us', 'url' => rtrim(url('/contact'), '/') . '/'],
    ])) !!}
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen">

    <!-- Hero Header Section -->
    <section class="relative bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white pt-20 pb-16 overflow-hidden">
        <!-- Ambient radial glow -->
        <div class="absolute inset-0 pointer-events-none opacity-20">
            <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[700px] h-[400px] bg-blue-600 blur-[130px] rounded-full"></div>
            <div class="absolute bottom-0 right-10 w-[400px] h-[300px] bg-sky-500 blur-[120px] rounded-full"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center max-w-3xl">
            <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-semibold bg-blue-500/20 text-blue-300 border border-blue-500/30 mb-6 backdrop-blur-sm shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>24/7 RAPID DISPATCH &amp; FREE TECHNICAL SIZING</span>
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black font-display tracking-tight text-white leading-tight">
                Contact HVAC Clinic <span class="bg-gradient-to-r from-blue-300 via-sky-200 to-cyan-300 bg-clip-text text-transparent">Engineering Hub Dubai</span>
            </h1>
            <p class="mt-4 text-sm sm:text-base text-slate-300 font-light leading-relaxed max-w-2xl mx-auto">
                Need emergency chiller rental, temporary AC, wild air ventilation, or power generators? Connect directly with our certified mechanical and electrical engineering team in Dubai for instant technical evaluation and fast-track deployment.
            </p>
        </div>
    </section>

    <!-- Main Contact Grid Section -->
    <section class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-10 items-start max-w-6xl mx-auto">
            
            <!-- Contact Info & Engineering Details (5 cols on md) -->
            <div class="md:col-span-5 bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 text-white rounded-3xl p-7 sm:p-9 space-y-7 shadow-2xl border border-blue-500/20">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-widest text-blue-300 block">Certified Engineering HQ</span>
                    <h3 class="text-2xl font-black text-white mt-1 font-display">HVAC Clinic UAE</h3>
                    <p class="text-slate-300 text-xs mt-2 leading-relaxed font-light">
                        Commercial cooling, temporary power generation, chiller AMC contracts, and used MEP plant trading across all 7 Emirates.
                    </p>
                </div>

                <div class="space-y-5 text-xs text-slate-200">
                    <!-- Phone Hotline -->
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/20 border border-blue-500/30 text-blue-300 flex items-center justify-center shrink-0 shadow-inner">
                            <i class="fas fa-phone-alt text-sm text-sky-400"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Emergency &amp; WhatsApp Hotline</span>
                            <a href="tel:+971503692131" class="font-bold text-white hover:text-blue-300 transition text-sm tracking-wide">+971 50 369 2131</a>
                            <span class="text-slate-400 block mt-0.5">Office Line: <a href="tel:+971506457285" class="hover:text-slate-200 text-slate-300">+971 50 645 7285</a></span>
                            <span class="text-[11px] text-emerald-400 font-semibold block mt-0.5 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                24/7 Priority Emergency Dispatch (60–90 min SLA)
                            </span>
                        </div>
                    </div>

                    <!-- Email Inquiries -->
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/20 border border-blue-500/30 text-blue-300 flex items-center justify-center shrink-0 shadow-inner">
                            <i class="fas fa-envelope text-sm text-sky-400"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Engineering Inquiries &amp; RFQs</span>
                            <a href="mailto:info@hvaclinic.com" class="font-bold text-white hover:text-blue-300 transition text-sm">info@hvaclinic.com</a>
                            <span class="text-slate-400 block mt-0.5">Sales Desk: <a href="mailto:sales@hvaclinic.com" class="hover:text-slate-200 text-slate-300">sales@hvaclinic.com</a></span>
                            <span class="text-[11px] text-slate-400 block mt-0.5">We respond with itemized technical proposals within 30 minutes</span>
                        </div>
                    </div>

                    <!-- Physical Depots & Yards -->
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/20 border border-blue-500/30 text-blue-300 flex items-center justify-center shrink-0 shadow-inner">
                            <i class="fas fa-map-marker-alt text-sm text-sky-400"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Central Equipment Staging Yards</span>
                            <p class="font-bold text-white leading-snug">
                                Industrial Area 3, Al Quoz &amp; Dubai Industrial City (DIC), Dubai
                            </p>
                            <span class="text-[11px] text-slate-400 block mt-0.5">
                                Regional Depots in Abu Dhabi (Musaffah) &amp; Sharjah with 24/7 Crane Loading Bays
                            </span>
                        </div>
                    </div>

                    <!-- Operating Hours -->
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/20 border border-blue-500/30 text-blue-300 flex items-center justify-center shrink-0 shadow-inner">
                            <i class="fas fa-clock text-sm text-sky-400"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Operations &amp; Mobilization Hours</span>
                            <p class="font-medium text-white">
                                Monday – Sunday: 24/7/365 Non-Stop Operations
                            </p>
                            <span class="text-[11px] text-slate-400 block mt-0.5">Emergency mobile technicians and delivery crane trucks ready on call</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-800">
                    <span class="text-[11px] font-bold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-3.5 py-1.5 rounded-full inline-flex items-center gap-1.5">
                        <i class="fas fa-check-circle text-xs"></i>
                        <span>Guaranteed 60 to 120-Minute Emergency Mobilization Across UAE</span>
                    </span>
                </div>
            </div>

            <!-- Online Diagnostic & Quote Intake Form (7 cols on md) -->
            <div class="md:col-span-7 bg-white rounded-3xl p-7 sm:p-9 shadow-sm border border-slate-200/90">
                <div class="mb-6">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-blue-600 block">Instant Proposal</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 font-display">Technical Sizing &amp; Quote Intake</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Tell us about your cooling, power, or maintenance requirements. Our senior HVAC applications engineer will calculate tonnage or kVA and provide a fast, itemized proposal.
                    </p>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-start gap-3 shadow-xs">
                        <i class="fas fa-check-circle text-emerald-600 text-base mt-0.5 shrink-0"></i>
                        <div>
                            <strong class="font-bold text-emerald-900 block">Request Received Successfully!</strong>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium space-y-1 shadow-xs">
                        <strong class="font-bold text-rose-900 block">Please correct the following:</strong>
                        <ul class="list-disc pl-5 space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Bot Honeypot for silent protection -->
                    <div class="hidden opacity-0 pointer-events-none absolute -left-[9999px]" aria-hidden="true">
                        <label for="_hp_website">Leave this blank</label>
                        <input type="text" id="_hp_website" name="_hp_website" tabindex="-1" autocomplete="off">
                    </div>

                    <!-- Row 1: Full Name -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Your Full Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Eng. Ahmed Al Mansoori / John Smith" 
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 text-sm transition-all bg-slate-50/50 focus:bg-white">
                    </div>

                    <!-- Row 2: Email & Phone -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Work Email Address <span class="text-rose-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@company.ae" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 text-sm transition-all bg-slate-50/50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone / WhatsApp <span class="text-rose-500">*</span></label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="+971 50 123 4567" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 text-sm transition-all bg-slate-50/50 focus:bg-white">
                        </div>
                    </div>

                    <!-- Row 3: Service Category & Location / Emirate -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Service Required <span class="text-rose-500">*</span></label>
                            <select name="subject" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 text-sm bg-white font-medium text-slate-700">
                                @php
                                    $servicesList = [
                                        'Rental Chiller (Air-Cooled & Water-Cooled)',
                                        'Rental Air Conditioning (Ducted & Spot Coolers)',
                                        'Rental Packaged Units (Rooftop & Modular DX)',
                                        'Wild Air & Site Ventilation Fans',
                                        'Chiller Maintenance & Compressor Overhaul',
                                        'Chiller Annual Maintenance Contract (AMC)',
                                        'Used & Refurbished Chiller Trading / Buyout',
                                        'Rental Power & Silent Diesel Generators',
                                        'Emergency Cooling & Disaster Recovery',
                                        'General Engineering Inquiry'
                                    ];
                                @endphp
                                @foreach($servicesList as $sOption)
                                    <option value="{{ $sOption }}" @selected(old('subject') === $sOption)>{{ $sOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Project Location / Emirate <span class="text-rose-500">*</span></label>
                            <select name="emirate" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 text-sm bg-white font-medium text-slate-700">
                                @php
                                    $emiratesList = [
                                        'Dubai (All Districts)',
                                        'Abu Dhabi & Al Ain',
                                        'Sharjah & Hamriyah',
                                        'Ajman',
                                        'Ras Al Khaimah',
                                        'Fujairah',
                                        'Umm Al Quwain',
                                        'Offshore / Marine / Free Zone'
                                    ];
                                @endphp
                                @foreach($emiratesList as $eOption)
                                    <option value="{{ $eOption }}" @selected(old('emirate') === $eOption)>{{ $eOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Row 4: Estimated Capacity & Company Name -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Estimated Cooling / Power Capacity</label>
                            <input type="text" name="kva_capacity" value="{{ old('kva_capacity') }}" placeholder="e.g. 150 TR, 500 kVA, or Need Sizing" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 text-sm transition-all bg-slate-50/50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Company / Project Name</label>
                            <input type="text" name="company" value="{{ old('company') }}" placeholder="e.g. Al Futtaim / Dubai Mall Contractor" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 text-sm transition-all bg-slate-50/50 focus:bg-white">
                        </div>
                    </div>

                    <!-- Row 5: Message / Technical Scope -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Scope Details, Constraints, or Failure Symptoms <span class="text-rose-500">*</span></label>
                        <textarea name="message" rows="4" required placeholder="Describe your cooling or power requirement: e.g. chiller compressor trip in factory, temporary AC for fit-out handover, luxury event cooling, required rental duration, site power availability, ambient constraints..." 
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 text-sm transition-all bg-slate-50/50 focus:bg-white leading-relaxed">{{ old('message') }}</textarea>
                    </div>

                    <!-- Priority Inspection Checkbox -->
                    <div class="p-3.5 rounded-xl bg-blue-50/70 border border-blue-100 flex items-start gap-3">
                        <input type="checkbox" id="pickup_requested" name="pickup_requested" value="yes" class="mt-0.5 rounded border-slate-300 text-blue-600 focus:ring-blue-500 h-4 w-4">
                        <label for="pickup_requested" class="text-xs text-slate-700 cursor-pointer font-medium leading-snug">
                            <strong>Priority On-Site Technical Survey:</strong> Request a visit by a senior HVAC applications engineer to measure hydraulic headers, pipe landing points, and electrical feeder panels.
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full py-4 rounded-xl bg-gradient-to-r from-blue-600 via-sky-600 to-blue-700 hover:from-blue-700 hover:to-sky-800 text-white font-bold text-sm shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 transition-all flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                            <i class="fas fa-paper-plane text-xs"></i>
                            <span>Submit for Immediate Technical Sizing &amp; Quote</span>
                        </button>
                    </div>

                    <p class="text-[11px] text-slate-400 text-center flex items-center justify-center gap-2 mt-2">
                        <i class="fas fa-shield-alt text-emerald-500"></i>
                        <span>Zero obligation. Direct review by certified mechanical refrigeration engineers. 100% Privacy guaranteed.</span>
                    </p>
                </form>
            </div>

        </div>
    </section>

    <!-- Regional Logistics & Staging Hubs (3-Column Architecture) -->
    <section class="py-12 bg-white border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 block">Strategic UAE Coverage</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 font-display mt-1">Regional Staging Hubs &amp; Depots</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-2">
                    Our pre-staged fleet of air-cooled chillers, packaged AC units, and generators ensures rapid 60 to 90-minute mobilization anywhere in the UAE.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
                <!-- Hub 1: Dubai -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-blue-300 hover:shadow-md transition group">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm mb-4 group-hover:bg-blue-600 group-hover:text-white transition">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 font-display">Dubai Central Hub</h3>
                    <p class="text-xs text-blue-600 font-semibold mt-0.5">Al Quoz &amp; Dubai Industrial City (DIC)</p>
                    <p class="text-xs text-slate-600 mt-2.5 leading-relaxed">
                        Houses our flagship fleet of 10 to 1,500 TR chillers, spot coolers, 100% FAHUs, high-pressure hoses, and 24/7 hiab crane dispatch teams.
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-200 text-[11px] font-bold text-slate-700 flex items-center justify-between">
                        <span>Dispatch SLA:</span>
                        <span class="text-emerald-600 font-extrabold">Within 60 Minutes</span>
                    </div>
                </div>

                <!-- Hub 2: Abu Dhabi -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-blue-300 hover:shadow-md transition group">
                    <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-sm mb-4 group-hover:bg-sky-600 group-hover:text-white transition">
                        <i class="fas fa-industry"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 font-display">Abu Dhabi Industrial Hub</h3>
                    <p class="text-xs text-sky-600 font-semibold mt-0.5">Musaffah Industrial &amp; ICAD</p>
                    <p class="text-xs text-slate-600 mt-2.5 leading-relaxed">
                        Specialized heavy industrial tropicalized chillers, synchronized generator farms, and CICPA/CNIA-cleared engineers for Ruwais, Al Dhafra, and offshore platforms.
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-200 text-[11px] font-bold text-slate-700 flex items-center justify-between">
                        <span>Dispatch SLA:</span>
                        <span class="text-emerald-600 font-extrabold">Within 90 Minutes</span>
                    </div>
                </div>

                <!-- Hub 3: Northern Emirates -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-blue-300 hover:shadow-md transition group">
                    <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center font-bold text-sm mb-4 group-hover:bg-cyan-600 group-hover:text-white transition">
                        <i class="fas fa-warehouse"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 font-display">Northern Emirates Hub</h3>
                    <p class="text-xs text-cyan-600 font-semibold mt-0.5">Sharjah Industrial &amp; Hamriyah</p>
                    <p class="text-xs text-slate-600 mt-2.5 leading-relaxed">
                        Supporting Sharjah, Ajman, Umm Al Quwain, Ras Al Khaimah, and Fujairah with packaged AC units, site wild air blowers, and rapid chemical cleaning skids.
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-200 text-[11px] font-bold text-slate-700 flex items-center justify-between">
                        <span>Dispatch SLA:</span>
                        <span class="text-emerald-600 font-extrabold">Within 60–90 Minutes</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom Emergency Hotline Strip -->
    <section class="border-t border-b border-slate-800 bg-gradient-to-r from-slate-950 via-blue-950 to-slate-950 py-10 px-4 text-white">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left max-w-6xl">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-amber-400 block mb-1">Direct Engineering Dispatch</span>
                <h3 class="text-xl sm:text-2xl font-bold font-display text-white">Experiencing a Cooling or Power Failure?</h3>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl font-light">
                    Do not let heat halt your operations. Contact our 24/7 rapid dispatch desk now for immediate emergency chiller, AC, or generator mobilization.
                </p>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-3 shrink-0">
                <a href="tel:+971503692131" class="px-5 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-extrabold shadow-lg transition flex items-center gap-2">
                    <i class="fas fa-phone-alt"></i>
                    <span>Call +971 50 369 2131</span>
                </a>
                <a href="https://wa.me/971503692131?text={{ urlencode('Hello HVAC Clinic, I have an urgent cooling/power requirement.') }}" target="_blank" class="px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold transition flex items-center gap-2 shadow-md">
                    <i class="fab fa-whatsapp text-sm"></i>
                    <span>WhatsApp Engineering</span>
                </a>
            </div>
        </div>
    </section>

</div>
@endsection
