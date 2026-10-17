@php
    $sidebarSubject = $subject ?? (isset($service) ? 'HVAC & Power Inquiry: ' . $service->title : (isset($product) ? 'Equipment Inquiry: ' . $product->title : 'HVAC & Power Rental Inquiry'));
    $whatsappText = $whatsappMessage ?? (isset($service) ? 'Hello HVAC Clinic, I need urgent pricing & availability for ' . $service->title : (isset($product) ? 'Hello HVAC Clinic, I am inquiring about ' . $product->title : 'Hello HVAC Clinic, I need a rental cooling and power quote.'));

    // Resolve services list for the navigator
    if (!isset($navServices)) {
        if (isset($otherServices) && $otherServices->isNotEmpty()) {
            $navServices = $otherServices;
        } elseif (isset($services) && $services->isNotEmpty()) {
            $navServices = isset($service) ? $services->where('id', '!=', $service->id) : $services;
        } else {
            $allServices = \App\Models\Service::published()->ordered()->get();
            $navServices = isset($service) ? $allServices->where('id', '!=', $service->id) : $allServices;
        }
    }
@endphp

<div id="quote-box" class="space-y-6">

    <!-- Flash Message Notification -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-600 text-white shadow-lg space-y-1">
            <div class="flex items-center gap-2 font-bold text-xs uppercase tracking-wide">
                <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
                <span>Quote Request Dispatched!</span>
            </div>
            <p class="text-xs text-emerald-50 leading-relaxed">{{ session('success') }}</p>
        </div>
    @endif

    <!-- 1. Rapid Sizing & Quote Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm space-y-4">
        <div class="flex items-center gap-2 text-xs font-bold uppercase text-amber-600">
            <i data-lucide="calculator" class="w-4 h-4"></i>
            <span>Instant Technical Sizing</span>
        </div>
        <h4 class="text-xl font-black text-slate-900 font-display">Request Engineering Quote</h4>
        <p class="text-xs text-slate-500">Submit your thermal or electrical requirements for an itemized proposal within <strong>15 minutes</strong>.</p>

        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4 pt-1">
            @csrf
            <input type="hidden" name="subject" value="{{ $sidebarSubject }}">

            <!-- Anti-Bot Silent Honeypot -->
            <div style="display: none !important;" aria-hidden="true">
                <input type="text" name="_hp_website" tabindex="-1" autocomplete="off">
                <input type="text" name="bot_check" tabindex="-1" autocomplete="off">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Your Full Name</label>
                <input type="text" name="name" required placeholder="e.g. Eng. Tariq Al Mazrouei" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">UAE Phone / WhatsApp</label>
                <input type="tel" name="phone" required placeholder="+971 50 123 4567" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Email Address</label>
                <input type="email" name="email" required placeholder="projects@contractor.ae" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Required Capacity</label>
                    <select name="capacity_range" class="w-full px-3 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 bg-white">
                        <optgroup label="Rental Chillers">
                            <option value="50-150 TR Chiller">50 – 150 TR Chiller</option>
                            <option value="200-400 TR Chiller" selected>200 – 400 TR Chiller</option>
                            <option value="500-1000 TR Chiller">500 – 1000 TR Chiller</option>
                            <option value="Multi-MW Chiller Plant">1200+ TR Multi-MW</option>
                        </optgroup>
                        <optgroup label="Rental AC & Wild Air">
                            <option value="5-25 TR Package AC">5 – 25 TR Package AC</option>
                            <option value="30-50 TR Rooftop Unit">30 – 50 TR Rooftop AC</option>
                            <option value="5000-25000 CFM Air Mover">5,000–25,000 CFM Air Mover</option>
                        </optgroup>
                        <optgroup label="Rental Generators & Power">
                            <option value="50-150 kVA Generator">50 – 150 kVA Generator</option>
                            <option value="200-500 kVA Generator">200 – 500 kVA Generator</option>
                            <option value="800-1250 kVA Generator">800 – 1250 kVA Generator</option>
                            <option value="Multi-MW Power Plant">1 MW – 20 MW Power</option>
                        </optgroup>
                        <optgroup label="Maintenance & Sales">
                            <option value="Chiller Maintenance AMC">Chiller Maintenance / AMC</option>
                            <option value="Used & Refurbished Buy/Sell">Used Equipment Purchase</option>
                        </optgroup>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Location / Emirate</label>
                    <select name="emirate" class="w-full px-3 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 bg-white">
                        <option value="Dubai" selected>Dubai</option>
                        <option value="Abu Dhabi">Abu Dhabi</option>
                        <option value="Sharjah">Sharjah</option>
                        <option value="Ajman">Ajman</option>
                        <option value="Ras Al Khaimah">Ras Al Khaimah</option>
                        <option value="Fujairah">Fujairah</option>
                        <option value="Umm Al Quwain">Umm Al Quwain</option>
                        <option value="Al Ain">Al Ain</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Project Details / Scope</label>
                <textarea name="message" rows="3" placeholder="Describe cooling or power load, required delivery date, expected duration (daily, weekly, monthly, annual AMC), and site location..." class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500"></textarea>
            </div>

            <div class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200/80">
                <input type="checkbox" id="turnkey_accessories" name="turnkey_accessories" value="yes" checked class="rounded text-amber-600 focus:ring-amber-500">
                <label for="turnkey_accessories" class="text-[11px] text-slate-600 font-medium">Include <strong>Turnkey Hoses, Quick-Couplings, Pumps & Power Cables</strong></label>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-xs bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 shadow-lg shadow-amber-500/20 transition transform hover:-translate-y-0.5">
                Request Engineering Quote
            </button>
        </form>
    </div>

    <!-- 2. Emergency 24/7 Dispatch Card -->
    <div class="bg-gradient-to-br from-slate-900 via-slate-900 to-slate-950 text-white rounded-3xl p-6 border border-slate-800 shadow-md space-y-4">
        <div class="flex items-center gap-2 text-xs font-bold uppercase text-amber-400">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
            <span>24/7 Emergency Dispatch</span>
        </div>
        <div class="space-y-1">
            <div class="text-xs text-slate-400">Chiller breakdown or power outage? Call 24/7:</div>
            <a href="tel:+971503692131" class="text-xl font-black text-white hover:text-amber-400 transition block font-mono">
                +971 50 369 2131
            </a>
            <div class="text-[11px] text-slate-400">Alt / Secondary: <a href="tel:+971506457285" class="hover:text-amber-300 font-mono">+971 50 645 7285</a></div>
        </div>
        <a href="https://wa.me/971503692131?text={{ urlencode($whatsappText) }}" target="_blank" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center justify-center gap-2 transition shadow-md">
            <i data-lucide="message-circle" class="w-4 h-4"></i>
            <span>Chat on WhatsApp</span>
        </a>
        <div class="pt-2 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
            <span>Average Mobilization: <strong>60–120 Min</strong></span>
            <span>All 7 Emirates</span>
        </div>
    </div>

    <!-- Contextual Category Specializations (Nested/Sibling Pages) -->
    @php
        $contextualPages = (isset($nestedPages) && $nestedPages->isNotEmpty()) 
            ? $nestedPages 
            : ((isset($siblingPages) && $siblingPages->isNotEmpty()) ? $siblingPages : collect());
    @endphp
    @if($contextualPages->isNotEmpty())
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-4">
            <h5 class="text-xs font-bold uppercase tracking-wider text-blue-600 flex items-center gap-2">
                <i data-lucide="git-branch" class="w-4 h-4 text-blue-600"></i>
                <span>Specialized Services &amp; Hubs</span>
            </h5>
            <div class="space-y-1.5 max-h-64 overflow-y-auto pr-1">
                @foreach($contextualPages as $cPage)
                    <a href="{{ url($cPage->slug) }}/" class="flex items-center justify-between p-2.5 rounded-xl text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition group border border-transparent hover:border-blue-200">
                        <span class="truncate">{{ $cPage->title }}</span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-0.5 transition shrink-0"></i>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- 3. Core HVAC & Power Services Navigator -->
    @if(isset($navServices) && $navServices->isNotEmpty())
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-4">
            <h5 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                <i data-lucide="layers" class="w-4 h-4 text-amber-500"></i>
                <span>Our Core Services</span>
            </h5>
            <div class="space-y-1.5">
                @foreach($navServices as $navSvc)
                    <a href="{{ route('service.show', $navSvc->slug) }}" class="flex items-center justify-between p-3 rounded-2xl text-xs font-semibold text-slate-700 hover:bg-amber-50 hover:text-amber-900 transition group border border-transparent hover:border-amber-200">
                        <span class="truncate">{{ $navSvc->title }}</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-slate-400 group-hover:text-amber-600 group-hover:translate-x-0.5 transition shrink-0"></i>
                    </a>
                @endforeach
            </div>
            <div class="pt-2">
                <a href="{{ route('service.index') }}" class="block text-center py-2 text-xs font-bold text-amber-700 hover:text-amber-800 transition">
                    Explore All Engineering Services &rarr;
                </a>
            </div>
        </div>
    @endif

    <!-- 4. Quick Depot & Service Coverage Links -->
    <div class="p-5 rounded-3xl bg-slate-100 border border-slate-200/60 text-xs space-y-2">
        <span class="font-extrabold uppercase text-[10px] text-slate-500 tracking-wider">Fast Regional Dispatch:</span>
        <div class="flex flex-wrap gap-1.5 pt-1">
            <span class="px-2.5 py-1 rounded-lg bg-white text-slate-700 font-bold border border-slate-200 text-[11px]">Dubai</span>
            <span class="px-2.5 py-1 rounded-lg bg-white text-slate-700 font-bold border border-slate-200 text-[11px]">Abu Dhabi</span>
            <span class="px-2.5 py-1 rounded-lg bg-white text-slate-700 font-bold border border-slate-200 text-[11px]">Sharjah</span>
            <span class="px-2.5 py-1 rounded-lg bg-white text-slate-700 font-bold border border-slate-200 text-[11px]">Ajman</span>
            <span class="px-2.5 py-1 rounded-lg bg-white text-slate-700 font-bold border border-slate-200 text-[11px]">RAK</span>
            <span class="px-2.5 py-1 rounded-lg bg-white text-slate-700 font-bold border border-slate-200 text-[11px]">Fujairah</span>
            <span class="px-2.5 py-1 rounded-lg bg-white text-slate-700 font-bold border border-slate-200 text-[11px]">Al Ain</span>
        </div>
        <div class="pt-2 border-t border-slate-200">
            <a href="{{ route('contact') }}" class="text-amber-700 hover:underline font-bold flex items-center gap-1 text-[11px]">
                <i data-lucide="map-pin" class="w-3 h-3"></i>
                <span>Depot Locations & Coverage Map &rarr;</span>
            </a>
        </div>
    </div>

</div>
