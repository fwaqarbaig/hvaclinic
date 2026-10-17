@extends('layouts.app')

@section('seo_meta')
    <title>{{ $page?->seo_title ?: 'HVAC Clinic | Industrial Rental Chillers, AC & Power Solutions UAE' }}</title>
    <meta name="description" content="{{ $page?->seo_description ?: 'Turnkey rental chillers (50 to 1500 TR), temporary AC, wild air systems and soundproof diesel generators across UAE. Rapid 2-hour mobilization with 24/7 certified engineering support.' }}">
    <link rel="canonical" href="{{ $page?->canonical_url ?: 'https://hvaclinic.com/' }}">
    <meta name="robots" content="{{ $page?->is_indexable === false ? 'noindex, nofollow' : 'index, follow' }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="HVAC Clinic">
    <meta property="og:title" content="{{ $page?->og_title ?: $page?->seo_title ?: 'HVAC Clinic | Industrial Rental Chillers, AC & Power Solutions UAE' }}">
    <meta property="og:description" content="{{ $page?->og_description ?: $page?->seo_description ?: 'Turnkey rental chillers, temporary AC, wild air systems and soundproof diesel generators across UAE.' }}">
    <meta property="og:url" content="{{ $page?->canonical_url ?: 'https://hvaclinic.com/' }}">
    @if($page?->seo_image)
        <meta property="og:image" content="{{ $page->seo_image }}">
        <meta name="twitter:image" content="{{ $page->seo_image }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $page?->og_title ?: $page?->seo_title ?: 'HVAC Clinic | Industrial Rental Chillers, AC & Power Solutions UAE' }}">
    <meta name="twitter:description" content="{{ $page?->og_description ?: $page?->seo_description ?: 'Turnkey rental chillers, temporary AC, wild air systems and soundproof diesel generators across UAE.' }}">
    <!-- Schema.org Homepage WebPage Schema -->
    {!! \App\Services\SchemaGenerator::renderPrimary($page, fn() => [
        '@'.'context' => 'https://schema.org',
        '@type' => 'WebPage',
        '@id' => url('/') . '#webpage',
        'url' => url('/'),
        'name' => 'HVAC Clinic | Industrial Rental Chillers, AC & Power Solutions UAE',
        'description' => 'Turnkey rental chillers, temporary AC, wild air systems and soundproof diesel generators across Dubai, Abu Dhabi & UAE.',
        'isPartOf' => ['@id' => config('app.url', 'https://hvaclinic.com') . '/#website'],
        'about' => ['@id' => config('app.url', 'https://hvaclinic.com') . '/#organization'],
    ]) !!}
@endsection

@section('content')

    <!-- =========================================================================
         1. HERO SECTION: Industrial High-Performance Engineering Aesthetic
         ========================================================================= -->
    <section class="relative bg-gradient-to-b from-[#051124] via-[#091b38] to-[#0d2347] text-white pt-10 pb-20 lg:pt-16 lg:pb-28 overflow-hidden">
        <!-- Ambient Radial Glow Highlights -->
        <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-10 w-[600px] h-[600px] bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <!-- Subtle Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff08_1px,transparent_1px),linear-gradient(to_bottom,#ffffff08_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] pointer-events-none"></div>

        <div class="site-container relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- Left Column: High-Impact Headlines & Value Proposition -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <!-- Trust Pill / Status Badge -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold text-slate-200">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                        </span>
                        <span>UAE's Certified HVAC &amp; Temporary Power Specialist</span>
                        <span class="text-white/30">&bull;</span>
                        <span class="text-amber-400 font-bold">24/7 Emergency Response</span>
                    </div>

                    <!-- Main Punchy Title -->
                    <h1 class="text-3xl sm:text-4xl md:text-5xl xl:text-6xl font-extrabold tracking-tight text-white leading-[1.12]">
                        Engineered Cooling &amp; Power Rental in UAE.
                        <span class="block mt-2 bg-gradient-to-r from-cyan-400 via-blue-400 to-indigo-300 bg-clip-text text-transparent">
                            Zero Downtime Guaranteed.
                        </span>
                    </h1>

                    <!-- Authoritative Subtitle -->
                    <p class="text-base sm:text-lg text-slate-300 max-w-2xl leading-relaxed">
                        Rapid deployment of high-capacity Rental chillers (50 to 1,500 TR), Temporary cooling units, packaged AC systems, construction wild air, and soundproof diesel generators. Complete turnkey delivery, hydraulic piping, and commissioning within 2 hours across all 7 Emirates.
                    </p>

                    <!-- CTAs & Direct Contact -->
                    <div class="pt-2 flex flex-wrap items-center gap-4">
                        <a href="#quick-consultation" 
                           class="inline-flex items-center justify-center gap-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-bold text-sm sm:text-base px-7 py-3.5 rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-500/50 transition-all transform hover:-translate-y-0.5">
                            <span>Request Free Consultation</span>
                            <i data-lucide="arrow-up-right" class="size-4"></i>
                        </a>

                        <a href="tel:+971503692131" 
                           class="inline-flex items-center justify-center gap-2.5 bg-white/10 hover:bg-white/20 text-white font-bold text-sm sm:text-base px-6 py-3.5 rounded-xl border border-white/20 backdrop-blur-sm transition-all">
                            <i class="fas fa-phone-alt text-amber-400"></i>
                            <span>+971 50 369 2131</span>
                        </a>

                        <a href="https://wa.me/971503692131?text=Hi%2C%20i%20am%20interested%20in%20HVAC%20Clinic%20rental%20cooling%20and%20power%20services." 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="inline-flex items-center justify-center gap-2 bg-[#25D366]/20 hover:bg-[#25D366]/30 text-[#25D366] font-bold text-sm sm:text-base px-5 py-3.5 rounded-xl border border-[#25D366]/30 transition-all">
                            <i class="fab fa-whatsapp text-lg"></i>
                            <span class="hidden sm:inline">WhatsApp</span>
                        </a>
                    </div>

                    <!-- Trust Checkpoints Grid -->
                    <div class="pt-4 grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs sm:text-sm font-semibold text-slate-300">
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="size-4 text-emerald-400 shrink-0"></i>
                            <span>2-Hour Rapid Dispatch</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="size-4 text-emerald-400 shrink-0"></i>
                            <span>50–1500 TR Fleet</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="size-4 text-emerald-400 shrink-0"></i>
                            <span>Turnkey Rig &amp; Pipe</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="size-4 text-emerald-400 shrink-0"></i>
                            <span>24/7 Field Engineers</span>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Interactive Quick Consultation Card (Clean High-Converting Intake) -->
                <div class="lg:col-span-5" id="quick-consultation">
                    <div class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8 text-slate-900 border border-slate-100 relative">
                        
                        <!-- Header of Card -->
                        <div class="mb-5 border-b border-slate-100 pb-4">
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                                    <i data-lucide="zap" class="size-3 text-amber-500 fill-amber-500"></i> Free Engineering Survey
                                </span>
                                <span class="text-xs text-slate-400 font-medium flex items-center gap-1">
                                    <i data-lucide="clock" class="size-3 text-emerald-500"></i> &lt; 15 min callback
                                </span>
                            </div>
                            <h2 class="text-xl font-extrabold text-slate-900 mt-2">Book Expert Consultation</h2>
                            <p class="text-xs text-slate-500 mt-1">Direct support for emergency cooling, maintenance or generator power.</p>
                        </div>

                        <!-- Form mapped to ContactController@submit -->
                        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-3.5" id="hero-quote-form">
                            @csrf
                            
                            <!-- Full Name -->
                            <div>
                                <label for="hero_name" class="block text-xs font-bold text-slate-700 mb-1">Full Name <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <i data-lucide="user" class="size-4 absolute left-3 top-3 text-slate-400"></i>
                                    <input type="text" 
                                           id="hero_name" 
                                           name="name" 
                                           required 
                                           placeholder="e.g. Tariq Al Mansoori" 
                                           class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition outline-none">
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="hero_phone" class="block text-xs font-bold text-slate-700 mb-1">Phone Number (UAE) <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <i data-lucide="phone" class="size-4 absolute left-3 top-3 text-slate-400"></i>
                                    <input type="tel" 
                                           id="hero_phone" 
                                           name="phone" 
                                           required 
                                           placeholder="+971 50 000 0000" 
                                           class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition outline-none">
                                </div>
                            </div>

                            <!-- Service Selection (Featuring the 7 Exact Services) -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label for="hero_service" class="block text-xs font-bold text-slate-700 mb-1">Required Service</label>
                                    <div class="relative">
                                        <select id="hero_service" 
                                                name="service" 
                                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition outline-none bg-white">
                                            <option value="Rental Chiller">Rental Chiller in UAE (50-1500 TR)</option>
                                            <option value="Rental Cooling">Rental Cooling</option>
                                            <option value="Rental AC">Rental AC (Packaged &amp; Portable)</option>
                                            <option value="AC Maintenance">AC Maintenance &amp; Repair</option>
                                            <option value="Wild Air Rental">Wild Air Rental</option>
                                            <option value="Chiller Maintenance">Chiller Maintenance &amp; AMC</option>
                                            <option value="Rental Generator">Rental Generator (20-2000 kVA)</option>
                                            <option value="Rental Power">Rental Power &amp; Substations</option>
                                            <option value="Used &amp; Refurbished">Used &amp; Refurbished Equipment</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Emirate / Location -->
                                <div>
                                    <label for="hero_location" class="block text-xs font-bold text-slate-700 mb-1">Location</label>
                                    <div class="relative">
                                        <select id="hero_location" 
                                                name="subject" 
                                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-medium focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition outline-none bg-white">
                                            <option value="Dubai Site">Dubai</option>
                                            <option value="Abu Dhabi Site">Abu Dhabi</option>
                                            <option value="Sharjah Site">Sharjah</option>
                                            <option value="Ajman Site">Ajman</option>
                                            <option value="RAK Site">Ras Al Khaimah</option>
                                            <option value="Fujairah Site">Fujairah</option>
                                            <option value="UAQ Site">Umm Al Quwain</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Optional Message / Load Details -->
                            <div>
                                <label for="hero_message" class="block text-xs font-bold text-slate-700 mb-1">Tonnage / kVA or Project Details <span class="text-slate-400 font-normal">(Optional)</span></label>
                                <textarea id="hero_message" 
                                          name="message" 
                                          rows="2" 
                                          placeholder="e.g. Need 200 TR chiller rental for a 3-week shutdown in JAFZA..." 
                                          class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition outline-none resize-none"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    id="hero-submit-btn" 
                                    class="w-full py-3.5 px-6 rounded-xl font-extrabold text-sm text-white bg-[#0844bd] hover:bg-[#063696] shadow-md shadow-blue-900/20 hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                <span>Get Instant Engineering Proposal</span>
                                <i data-lucide="send" class="size-4"></i>
                            </button>

                            <!-- Privacy / Confidentiality Notice -->
                            <div class="flex items-center justify-center gap-1.5 text-[11px] text-slate-400 pt-1">
                                <i data-lucide="shield-check" class="size-3.5 text-emerald-500"></i>
                                <span>100% Confidential. Zero spam. Certified UAE engineers.</span>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- =========================================================================
         2. STATS & KEY PERFORMANCE COUNTER STRIP
         ========================================================================= -->
    <section class="bg-[#040d1c] border-y border-white/10 py-8 relative">
        <div class="site-container">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8">
                
                <div class="flex items-center gap-4 p-3 rounded-xl bg-white/[0.03] border border-white/5">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 shrink-0">
                        <i data-lucide="clock" class="size-6"></i>
                    </div>
                    <div>
                        <div class="text-2xl lg:text-3xl font-extrabold text-white tracking-tight">2 Hours</div>
                        <div class="text-xs text-slate-400 font-medium">Emergency Dispatch UAE</div>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-3 rounded-xl bg-white/[0.03] border border-white/5">
                    <div class="w-12 h-12 rounded-xl bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-cyan-400 shrink-0">
                        <i data-lucide="snowflake" class="size-6"></i>
                    </div>
                    <div>
                        <div class="text-2xl lg:text-3xl font-extrabold text-white tracking-tight">50–1500 TR</div>
                        <div class="text-xs text-slate-400 font-medium">Modular Chiller Fleet</div>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-3 rounded-xl bg-white/[0.03] border border-white/5">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 shrink-0">
                        <i data-lucide="zap" class="size-6"></i>
                    </div>
                    <div>
                        <div class="text-2xl lg:text-3xl font-extrabold text-white tracking-tight">2,000 kVA</div>
                        <div class="text-xs text-slate-400 font-medium">Generator Sync Fleet</div>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-3 rounded-xl bg-white/[0.03] border border-white/5">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 shrink-0">
                        <i data-lucide="shield-check" class="size-6"></i>
                    </div>
                    <div>
                        <div class="text-2xl lg:text-3xl font-extrabold text-white tracking-tight">100% Uptime</div>
                        <div class="text-xs text-slate-400 font-medium">Turnkey 24/7 AMC Support</div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- =========================================================================
         3. CORE SERVICES: Featuring All 7 Exact Services in a Modern 8-Card Grid
         ========================================================================= -->
    <section class="py-16 sm:py-24 bg-slate-50" id="services">
        <div class="site-container">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-blue-100 text-blue-800 tracking-wider uppercase mb-3">
                    Our Core Specializations
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Comprehensive HVAC &amp; Temporary Power Fleet
                </h2>
                <p class="text-base text-slate-600 mt-3 leading-relaxed">
                    Designed for heavy-duty industrial environments, scheduled maintenance shutdowns, commercial events, and emergency plant breakdowns across the UAE.
                </p>
            </div>

            <!-- The 8-Card Grid (7 Core Services + 1 Emergency Hot Card) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- 1. Rental Cooling -->
                <div class="group bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-blue-300 transition-all duration-200 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-5 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-200">
                            <i data-lucide="snowflake" class="size-6"></i>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-700 transition">Rental Cooling</h3>
                            <span class="text-[11px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">50–1500 TR</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                            High-efficiency air-cooled and water-cooled Rental chillers and Temporary cooling solutions equipped with pumps, heat exchangers, and quick-connect flexible hoses.
                        </p>
                        <ul class="space-y-1.5 text-xs text-slate-500 mb-6">
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> District cooling augmentation</li>
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Industrial plant shutdowns</li>
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Turnkey crane rigging &amp; piping</li>
                        </ul>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="/services/rental-cooling/" class="text-xs font-bold text-blue-700 hover:text-blue-900 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            Explore Cooling <i data-lucide="arrow-right" class="size-3.5"></i>
                        </a>
                        <span class="text-[11px] text-slate-400">UAE-Wide</span>
                    </div>
                </div>

                <!-- 2. Rental AC -->
                <div class="group bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-blue-300 transition-all duration-200 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center mb-5 group-hover:bg-sky-600 group-hover:text-white transition-colors duration-200">
                            <i data-lucide="wind" class="size-6"></i>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-sky-700 transition">Rental AC</h3>
                            <span class="text-[11px] font-bold text-sky-600 bg-sky-50 px-2 py-0.5 rounded-md">5–50 TR</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                            Commercial packaged air conditioners, floor-standing units, and portable spot coolers with modular flexible air ducting.
                        </p>
                        <ul class="space-y-1.5 text-xs text-slate-500 mb-6">
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Events, exhibitions &amp; VIP tents</li>
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Portable spot coolers for server rooms</li>
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Plug-and-play same-day delivery</li>
                        </ul>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="/services/rental-ac-in-uae/" class="text-xs font-bold text-sky-700 hover:text-sky-900 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            Explore Rental AC <i data-lucide="arrow-right" class="size-3.5"></i>
                        </a>
                        <span class="text-[11px] text-slate-400">Plug &amp; Play</span>
                    </div>
                </div>

                <!-- 3. Wild Air Rental -->
                <div class="group bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-blue-300 transition-all duration-200 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-5 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-200">
                            <i data-lucide="fan" class="size-6"></i>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-700 transition">Wild Air Rental</h3>
                            <span class="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">High-CFM</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                            High-volume temporary air conditioning for construction fit-outs, paint drying, timber curing, and pre-commissioning phases.
                        </p>
                        <ul class="space-y-1.5 text-xs text-slate-500 mb-6">
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Humidity &amp; moisture mitigation</li>
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Protects expensive architectural finishes</li>
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Compliant with civil contractor standards</li>
                        </ul>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="/services/wild-air-rental-in-uae/" class="text-xs font-bold text-indigo-700 hover:text-indigo-900 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            Explore Wild Air <i data-lucide="arrow-right" class="size-3.5"></i>
                        </a>
                        <span class="text-[11px] text-slate-400">Construction</span>
                    </div>
                </div>

                <!-- 4. Chiller Maintenance -->
                <div class="group bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-blue-300 transition-all duration-200 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-5 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-200">
                            <i data-lucide="wrench" class="size-6"></i>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-amber-700 transition">Chiller Maintenance</h3>
                            <span class="text-[11px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md">24/7 AMC</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                            Certified HVAC preventive maintenance, compressor rebuilding, coil descaling, and 24/7 emergency repair contracts.
                        </p>
                        <ul class="space-y-1.5 text-xs text-slate-500 mb-6">
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Annual Maintenance Contracts (AMC)</li>
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> OEM parts for Trane, Carrier, York</li>
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Rapid emergency breakdown dispatch</li>
                        </ul>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="/services/chiller-maintenance-in-uae/" class="text-xs font-bold text-amber-700 hover:text-amber-900 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            Explore Maintenance <i data-lucide="arrow-right" class="size-3.5"></i>
                        </a>
                        <span class="text-[11px] text-slate-400">Certified</span>
                    </div>
                </div>

                <!-- 5. Rental Generator -->
                <div class="group bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-blue-300 transition-all duration-200 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center mb-5 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-200">
                            <i data-lucide="zap" class="size-6"></i>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-orange-700 transition">Rental Generator</h3>
                            <span class="text-[11px] font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-md">20–2000 kVA</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                            Soundproof, super-silent diesel generators with Cummins and Perkins engines, internal dual-wall fuel tanks, and ATS panels.
                        </p>
                        <ul class="space-y-1.5 text-xs text-slate-500 mb-6">
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Low decibel residential acoustic canopy</li>
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Automatic transfer switches (ATS)</li>
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Continuous on-site fuel management</li>
                        </ul>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="/services/generator-rental-in-uae/" class="text-xs font-bold text-orange-700 hover:text-orange-900 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            Explore Generators <i data-lucide="arrow-right" class="size-3.5"></i>
                        </a>
                        <span class="text-[11px] text-slate-400">Silent Diesel</span>
                    </div>
                </div>

                <!-- 6. Rental Power -->
                <div class="group bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-blue-300 transition-all duration-200 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-5 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-200">
                            <i data-lucide="activity" class="size-6"></i>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-purple-700 transition">Rental Power</h3>
                            <span class="text-[11px] font-bold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-md">Multi-MW</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                            Turnkey power plants, step-up transformers (11kV / 33kV), sync load-sharing switchgear, and heavy-duty distribution panels.
                        </p>
                        <ul class="space-y-1.5 text-xs text-slate-500 mb-6">
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Multi-megawatt generator synchronization</li>
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Feeder cables, distribution boxes &amp; mats</li>
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Certified electrical installation team</li>
                        </ul>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="/services/generator-maintenance-repair-in-uae/" class="text-xs font-bold text-purple-700 hover:text-purple-900 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            Explore Rental Power <i data-lucide="arrow-right" class="size-3.5"></i>
                        </a>
                        <span class="text-[11px] text-slate-400">Turnkey Plant</span>
                    </div>
                </div>

                <!-- 7. USed & Refurbished -->
                <div class="group bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-blue-300 transition-all duration-200 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-200">
                            <i data-lucide="repeat" class="size-6"></i>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-700 transition">USed &amp; Refurbished</h3>
                            <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">Tested &amp; Warranted</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                            Inspected, fully load-bank tested pre-owned chillers and generators with warranty, installation, or buyback options.
                        </p>
                        <ul class="space-y-1.5 text-xs text-slate-500 mb-6">
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> 100% full-load performance certified</li>
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> 6 to 12-month comprehensive warranty</li>
                            <li class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-emerald-500"></i> Top-value equipment buyback program</li>
                        </ul>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="/used-refurbished-equipment-in-uae/" class="text-xs font-bold text-emerald-700 hover:text-emerald-900 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            Browse Inventory <i data-lucide="arrow-right" class="size-3.5"></i>
                        </a>
                        <span class="text-[11px] text-slate-400">Buy &amp; Sell</span>
                    </div>
                </div>

                <!-- 8. 24/7 Emergency Dispatch Callout Card -->
                <div class="bg-gradient-to-br from-[#071327] to-[#122e5a] rounded-2xl p-6 text-white shadow-xl flex flex-col justify-between border border-blue-500/20 relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-500/20 rounded-full blur-2xl pointer-events-none"></div>
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-400 shadow-[0_0_10px_#34d399]"></span>
                            <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-300">Immediate Support</span>
                        </div>
                        <h3 class="text-xl font-extrabold text-white mb-2 leading-tight">Need Urgent Cooling or Power Right Now?</h3>
                        <p class="text-xs text-slate-300 leading-relaxed mb-6">
                            Our emergency mobile units are pre-rigged for immediate dispatch across Dubai, Abu Dhabi, Sharjah, and Northern Emirates.
                        </p>
                    </div>
                    <div class="space-y-2.5">
                        <a href="tel:+971503692131" class="w-full py-3 px-4 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-900 font-extrabold text-xs flex items-center justify-center gap-2 transition">
                            <i class="fas fa-phone-alt"></i> Call Hotline: +971 50 369 2131
                        </a>
                        <a href="https://wa.me/971503692131?text=Urgent%20Cooling%20or%20Power%20Request" target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs flex items-center justify-center gap-2 border border-white/15 transition">
                            <i class="fab fa-whatsapp text-emerald-400"></i> WhatsApp Support
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- =========================================================================
         4. WHY CHOOSE HVAC CLINIC (Technical Fleet Capabilities & Real Imagery)
         ========================================================================= -->
    <section class="py-16 sm:py-24 bg-white border-t border-slate-200">
        <div class="site-container">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Visual Column: High-Res Local Equipment Showcase -->
                <div class="lg:col-span-6 relative">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-100 aspect-[4/3] bg-slate-900">
                        <img src="/wp-content/uploads/2026/03/1.jpg" 
                             alt="HVAC Clinic UAE Chiller and Power Rental" 
                             width="960" 
                             height="720" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                        
                        <!-- Floating Badge on Image -->
                        <div class="absolute bottom-5 left-5 right-5 bg-white/95 backdrop-blur-md p-4 rounded-2xl shadow-lg border border-white/40 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-extrabold text-lg">
                                    <i data-lucide="award" class="size-5"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900">Turnkey Commissioning</div>
                                    <div class="text-[11px] text-slate-500">Pumps, Cables, Piping &amp; Load Testing</div>
                                </div>
                            </div>
                            <span class="text-xs font-extrabold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">ISO Certified</span>
                        </div>
                    </div>

                    <!-- Secondary Overlapping Image -->
                    <div class="hidden sm:block absolute -bottom-8 -right-6 w-52 rounded-2xl overflow-hidden shadow-2xl border-4 border-white bg-slate-100">
                        <img src="/wp-content/uploads/2026/03/power-1.jpg" 
                             alt="HVAC Clinic Generator Fleet" 
                             width="400" 
                             height="300" 
                             class="w-full h-auto object-cover">
                    </div>
                </div>

                <!-- Right Feature Column: Engineering Capabilities -->
                <div class="lg:col-span-6 space-y-6">
                    <div>
                        <span class="text-xs font-extrabold tracking-wider text-blue-600 uppercase bg-blue-50 px-3 py-1 rounded-full">
                            Engineering Reliability
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-3">
                            Engineered for UAE’s Most Demanding Heat &amp; Power Conditions
                        </h2>
                        <p class="text-base text-slate-600 mt-3 leading-relaxed">
                            When high ambient temperatures hit 50°C, ordinary HVAC systems fail. HVAC Clinic provides high-ambient tropicalized cooling machinery and generator systems built to maintain peak thermal efficiency without derating.
                        </p>
                    </div>

                    <div class="space-y-4 pt-2">
                        
                        <div class="flex items-start gap-3.5 p-3.5 rounded-xl hover:bg-slate-50 transition border border-transparent hover:border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="zap" class="size-5"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">2-Hour Rapid Mobilization</h3>
                                <p class="text-xs text-slate-600 mt-1 leading-relaxed">Strategic equipment holding yards across Dubai, Abu Dhabi, and Sharjah ensure immediate transport and deployment.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5 p-3.5 rounded-xl hover:bg-slate-50 transition border border-transparent hover:border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="shield-check" class="size-5"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Full Turnkey Hookup &amp; Rigging</h3>
                                <p class="text-xs text-slate-600 mt-1 leading-relaxed">We handle crane offloading, chilled water flanged piping, header balancing, heavy-duty electrical cabling, and start-up.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5 p-3.5 rounded-xl hover:bg-slate-50 transition border border-transparent hover:border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="settings" class="size-5"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Tier-1 Global Manufacturers</h3>
                                <p class="text-xs text-slate-600 mt-1 leading-relaxed">Fleet maintained to OEM specifications using Trane, Carrier, York, Daikin, Cummins, and Perkins machinery.</p>
                            </div>
                        </div>

                    </div>

                    <div class="pt-2 flex items-center gap-4">
                        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-[#0844bd] hover:bg-[#063696] text-white px-6 py-3 rounded-xl font-bold text-sm shadow-md transition">
                            <span>Schedule Site Survey</span>
                            <i data-lucide="arrow-right" class="size-4"></i>
                        </a>
                        <a href="/about/" class="text-sm font-bold text-slate-700 hover:text-blue-700 transition">
                            Learn More About Our Fleet &rarr;
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </section>


    <!-- =========================================================================
         5. HOW IT WORKS: 4-Step Seamless Turnkey Workflow
         ========================================================================= -->
    <section class="py-16 sm:py-24 bg-slate-900 text-white relative">
        <div class="site-container">
            
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs font-extrabold tracking-wider text-cyan-400 uppercase bg-cyan-950/70 border border-cyan-800/60 px-3 py-1 rounded-full">
                    Execution Workflow
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mt-3">
                    Fast, Rigorous &amp; Turnkey From First Call
                </h2>
                <p class="text-base text-slate-300 mt-3 leading-relaxed">
                    How HVAC Clinic takes you from emergency heat stress to a fully commissioned, chilled site in 4 simple steps.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Step 01 -->
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6 relative flex flex-col justify-between hover:border-cyan-400/40 transition">
                    <div>
                        <div class="text-4xl font-extrabold text-cyan-400/40 mb-4 font-mono">01</div>
                        <h3 class="text-lg font-bold text-white mb-2">Thermal Sizing</h3>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                            Our HVAC engineers analyze your square footage, ambient heat load, or electrical requirements to match the precise tonnage or kVA.
                        </p>
                    </div>
                    <div class="pt-4 mt-6 border-t border-white/10 text-xs text-cyan-300 font-semibold flex items-center gap-1.5">
                        <i data-lucide="check" class="size-3.5"></i> Custom Load Assessment
                    </div>
                </div>

                <!-- Step 02 -->
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6 relative flex flex-col justify-between hover:border-cyan-400/40 transition">
                    <div>
                        <div class="text-4xl font-extrabold text-cyan-400/40 mb-4 font-mono">02</div>
                        <h3 class="text-lg font-bold text-white mb-2">Fleet Mobilization</h3>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                            Selected chillers, generator sets, hoses, and distribution panels are secured onto lowbed trailers and dispatched immediately.
                        </p>
                    </div>
                    <div class="pt-4 mt-6 border-t border-white/10 text-xs text-cyan-300 font-semibold flex items-center gap-1.5">
                        <i data-lucide="truck" class="size-3.5"></i> UAE-Wide 2-Hour Window
                    </div>
                </div>

                <!-- Step 03 -->
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6 relative flex flex-col justify-between hover:border-cyan-400/40 transition">
                    <div>
                        <div class="text-4xl font-extrabold text-cyan-400/40 mb-4 font-mono">03</div>
                        <h3 class="text-lg font-bold text-white mb-2">Turnkey Hookup</h3>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                            Certified pipefitters and electricians connect to your building’s chilled water loop, sync generators, and conduct safety pressure checks.
                        </p>
                    </div>
                    <div class="pt-4 mt-6 border-t border-white/10 text-xs text-cyan-300 font-semibold flex items-center gap-1.5">
                        <i data-lucide="wrench" class="size-3.5"></i> Full Pressure &amp; Load Test
                    </div>
                </div>

                <!-- Step 04 -->
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6 relative flex flex-col justify-between hover:border-cyan-400/40 transition">
                    <div>
                        <div class="text-4xl font-extrabold text-cyan-400/40 mb-4 font-mono">04</div>
                        <h3 class="text-lg font-bold text-white mb-2">24/7 AMC &amp; Standby</h3>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                            Dedicated technicians perform round-the-clock monitoring, routine preventative servicing, and automated diesel fuel replenishment.
                        </p>
                    </div>
                    <div class="pt-4 mt-6 border-t border-white/10 text-xs text-cyan-300 font-semibold flex items-center gap-1.5">
                        <i data-lucide="shield-check" class="size-3.5"></i> Zero Downtime Handover
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- =========================================================================
         6. INDUSTRIES WE SERVE
         ========================================================================= -->
    <section class="py-16 bg-slate-100/70 border-b border-slate-200">
        <div class="site-container">
            
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-extrabold tracking-wider text-slate-500 uppercase">Sectors Covered</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Trusted Across Key UAE Industries</h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                
                <div class="bg-white p-5 rounded-2xl border border-slate-200/70 text-center shadow-2xs hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="building-2" class="size-5"></i>
                    </div>
                    <h3 class="text-xs font-bold text-slate-800">Civil &amp; Fit-Out</h3>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200/70 text-center shadow-2xs hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="factory" class="size-5"></i>
                    </div>
                    <h3 class="text-xs font-bold text-slate-800">Manufacturing</h3>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200/70 text-center shadow-2xs hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="server" class="size-5"></i>
                    </div>
                    <h3 class="text-xs font-bold text-slate-800">Data Centers</h3>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200/70 text-center shadow-2xs hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="tent" class="size-5"></i>
                    </div>
                    <h3 class="text-xs font-bold text-slate-800">Events &amp; Tents</h3>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200/70 text-center shadow-2xs hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="heart-pulse" class="size-5"></i>
                    </div>
                    <h3 class="text-xs font-bold text-slate-800">Healthcare</h3>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200/70 text-center shadow-2xs hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="anchor" class="size-5"></i>
                    </div>
                    <h3 class="text-xs font-bold text-slate-800">Marine &amp; Oil/Gas</h3>
                </div>

            </div>

        </div>
    </section>


    <!-- =========================================================================
         7. RECENT BLOG ARTICLES (From Database 'Blog' Category)
         ========================================================================= -->
    @if(isset($recentPosts) && $recentPosts->isNotEmpty())
        <section class="py-16 sm:py-24 bg-white" id="blogs">
            <div class="site-container">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                    <div>
                        <span class="text-xs font-extrabold tracking-wider text-blue-600 uppercase bg-blue-50 px-3 py-1 rounded-full">
                            Technical Articles &amp; Insights
                        </span>
                        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-2">
                            Latest from Our Engineering Blog
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Insights on temporary chiller sizing, generator maintenance, and cooling best practices in the UAE.
                        </p>
                    </div>
                    <a href="/blog/" class="inline-flex items-center gap-1.5 text-sm font-bold text-blue-700 hover:text-blue-900 transition">
                        <span>View All Blogs</span>
                        <i data-lucide="arrow-right" class="size-4"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($recentPosts as $post)
                        <article class="bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-xl transition-all duration-200 overflow-hidden flex flex-col justify-between group">
                            <div>
                                <!-- Post Image -->
                                <a href="{{ route('post.show', $post->slug) }}" class="block aspect-[16/10] overflow-hidden bg-slate-100 relative">
                                    @if($post->featured_image_url)
                                        <img src="{{ $post->featured_image_url }}" 
                                             alt="{{ $post->title }}" 
                                             loading="lazy" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400">
                                            <i data-lucide="image" class="size-8"></i>
                                        </div>
                                    @endif
                                    <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-blue-800 text-[11px] font-bold px-2.5 py-1 rounded-md shadow-xs">
                                        {{ $post->categories->first()?->name ?? 'Blog' }}
                                    </span>
                                </a>

                                <div class="p-6">
                                    <!-- Date & Read Time -->
                                    <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                                        <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Recent' }}</span>
                                        <span>&bull;</span>
                                        <span>{{ $post->reading_time }} min read</span>
                                    </div>

                                    <!-- Title -->
                                    <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-700 transition leading-snug line-clamp-2 mb-2">
                                        <a href="{{ route('post.show', $post->slug) }}">
                                            {{ $post->title }}
                                        </a>
                                    </h3>

                                    <!-- Excerpt -->
                                    <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                        {{ $post->seo_description }}
                                    </p>
                                </div>
                            </div>

                            <div class="px-6 pb-6 pt-2">
                                <a href="{{ route('post.show', $post->slug) }}" class="text-xs font-bold text-blue-700 hover:text-blue-900 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                    Read Article <i data-lucide="arrow-right" class="size-3.5"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

            </div>
        </section>
    @endif


    <!-- =========================================================================
         8. CERTIFIED OPERATIONS & QUALITY ASSURANCE STRIP
         ========================================================================= -->
    <section class="py-12 bg-slate-50 border-t border-slate-200">
        <div class="site-container">
            <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/90 shadow-xs flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <div class="bg-slate-100 p-2 rounded-xl shrink-0">
                        <img src="/wp-content/uploads/2026/03/0-2-2.gif" alt="HVAC Clinic UAE Certified" class="h-16 w-auto object-contain">
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">Certified Quality &amp; Safety Compliance</h3>
                        <p class="text-xs text-slate-500 max-w-xl mt-1 leading-relaxed">
                            All HVAC Clinic rental equipment and installation procedures strictly adhere to UAE Civil Defence, Municipality safety guidelines, and international ISO quality standards.
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <a href="/certificates/" class="text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 px-4 py-2.5 rounded-xl transition">
                        View Certificates &rarr;
                    </a>
                    <a href="/our-team/" class="text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 px-4 py-2.5 rounded-xl transition">
                        Meet Our Team &rarr;
                    </a>
                </div>
            </div>
        </div>
    </section>


    <!-- =========================================================================
         9. HIGH-IMPACT BOTTOM CTA BANNER
         ========================================================================= -->
    <section class="py-16 bg-gradient-to-r from-[#061224] via-[#091e3d] to-[#07162c] text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(37,99,235,0.2),transparent_50%)]"></div>
        <div class="site-container relative z-10 text-center max-w-3xl mx-auto space-y-6">
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/20 text-amber-300 text-xs font-bold border border-amber-400/30">
                <i data-lucide="phone-call" class="size-3.5"></i> 24/7 Rapid Emergency Response
            </div>

            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white leading-tight">
                Need Chiller, AC or Generator Support On Site Today?
            </h2>

            <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-xl mx-auto">
                Speak directly with an HVAC application engineer. We assess your requirements and deploy from our nearest Dubai, Abu Dhabi or Sharjah depot.
            </p>

            <div class="pt-2 flex flex-wrap items-center justify-center gap-4">
                <a href="tel:+971503692131" 
                   class="inline-flex items-center justify-center gap-2 bg-amber-400 hover:bg-amber-300 text-slate-900 font-extrabold text-sm sm:text-base px-7 py-3.5 rounded-xl shadow-lg transition">
                    <i class="fas fa-phone-alt"></i> Call +971 50 369 2131
                </a>
                
                <a href="https://wa.me/971503692131?text=Hello%20HVAC%20Clinic%2C%20I%20need%20cooling%20support" 
                   target="_blank" 
                   class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm sm:text-base px-6 py-3.5 rounded-xl shadow-lg transition">
                    <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                </a>

                <a href="{{ route('contact') }}" 
                   class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white font-bold text-sm sm:text-base px-6 py-3.5 rounded-xl border border-white/20 transition">
                    Contact Us Online
                </a>
            </div>

            <div class="pt-4 flex flex-wrap items-center justify-center gap-6 text-xs text-slate-400">
                <span class="flex items-center gap-1.5"><i data-lucide="clock" class="size-3.5 text-cyan-400"></i> Average dispatch under 2 hours</span>
                <span class="flex items-center gap-1.5"><i data-lucide="check" class="size-3.5 text-cyan-400"></i> No hidden delivery charges</span>
                <span class="flex items-center gap-1.5"><i data-lucide="shield" class="size-3.5 text-cyan-400"></i> 100% Guaranteed performance</span>
            </div>

        </div>
    </section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('hero-quote-form');
        const submitBtn = document.getElementById('hero-submit-btn');

        if (form && submitBtn) {
            form.addEventListener('submit', function () {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Submitting Request...';
            });
        }
    });
</script>
@endpush
@endsection
