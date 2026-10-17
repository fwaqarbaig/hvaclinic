@extends('layouts.app')

@section('seo_meta')
    <title>Site Directory & Topical Crawl Index | HVAC Clinic UAE</title>
    <meta name="description" content="Complete architectural index and crawl directory of HVAC Clinic UAE: emergency rental chillers, temporary cooling, generator rentals, AMC maintenance, and all 270+ technical guides.">
    <link rel="canonical" href="{{ rtrim(url('/site-directory'), '/') . '/' }}">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="HVAC Clinic">
    <meta property="og:title" content="Site Directory & Topical Crawl Index | HVAC Clinic UAE">
    <meta property="og:description" content="Explore all core services, corporate pages, topical categories, and 270+ engineering guides published by HVAC Clinic.">
    <meta property="og:url" content="{{ rtrim(url('/site-directory'), '/') . '/' }}">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Schema.org BreadcrumbList -->
    {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::breadcrumbs([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Site Directory', 'url' => rtrim(url('/site-directory'), '/') . '/'],
    ])) !!}
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen py-12" x-data="{ searchQuery: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs text-slate-400" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Home</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
            <span class="text-blue-600 font-semibold">Site Directory & Crawl Hub</span>
        </nav>

        <!-- Hero Header -->
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/90 shadow-sm space-y-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-3 max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-200">
                        <i data-lucide="sitemap" class="w-3.5 h-3.5"></i>
                        <span>Complete Website Architecture</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight font-display">
                        Site Directory &amp; Crawl Index
                    </h1>
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-light">
                        This directory indexes every official HVAC &amp; Power service page, corporate hub, topical category, and technical engineering guide published across HVAC Clinic for both readers and search engine crawlers.
                    </p>
                </div>

                <!-- Live Filter Input -->
                <div class="w-full md:w-80 space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Filter Any Page / Guide</label>
                    <div class="relative">
                        <input type="text" 
                               x-model="searchQuery" 
                               placeholder="Filter by keyword (e.g., chiller, amc, generator)..." 
                               class="w-full pl-9 pr-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white shadow-xs">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-3 pointer-events-none"></i>
                    </div>
                    <div class="text-[11px] text-slate-400 flex items-center justify-between">
                        <span>Total Published Guides: <strong>{{ $posts->count() }}</strong></span>
                        <span>Core Services: <strong>{{ $services->count() }}</strong></span>
                    </div>
                </div>
            </div>

            <!-- Quick Section Anchor Jump Bar -->
            <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center gap-2 text-xs">
                <span class="font-bold text-slate-400 uppercase tracking-wider text-[11px] mr-1">Quick Jump:</span>
                <a href="#core-services" class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 font-semibold transition">
                    Core Services ({{ $services->count() }})
                </a>
                <a href="#corporate-pages" class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 font-semibold transition">
                    Corporate Pages ({{ count($corePages) }})
                </a>
                <a href="#knowledge-categories" class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-semibold transition">
                    Topic Categories ({{ $categories->count() }})
                </a>
                <a href="#technical-guides" class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 font-semibold transition">
                    All Guides ({{ $posts->count() }})
                </a>
                <a href="#xml-sitemaps" class="px-3 py-1.5 rounded-lg bg-purple-50 text-purple-700 hover:bg-purple-100 font-semibold transition">
                    XML Sitemaps
                </a>
            </div>
        </div>

        <!-- 1. Core Engineering Services Section -->
        <section id="core-services" class="space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Flagship Solutions</span>
                    <h2 class="text-2xl font-black text-slate-900 font-display">Core Engineered HVAC &amp; Power Services</h2>
                </div>
                <a href="{{ route('service.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700">
                    Services Hub &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($services as $svc)
                    @php
                        $subPages = $nestedPagesByService[$svc->slug] ?? collect();
                    @endphp
                    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs hover:shadow-md hover:border-blue-400 transition flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                                <i data-lucide="layers" class="w-5 h-5"></i>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition">
                                <a href="{{ route('service.show', $svc->slug) }}">
                                    {{ $svc->title }}
                                </a>
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $svc->summary ?: Str::limit(strip_tags((string)$svc->content), 120) }}
                            </p>

                            @if($subPages->isNotEmpty())
                                <div class="pt-3 border-t border-slate-100">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1.5">
                                        Specializations ({{ $subPages->count() }})
                                    </span>
                                    <ul class="space-y-1 max-h-48 overflow-y-auto pr-1">
                                        @foreach($subPages as $sub)
                                            <li>
                                                <a href="{{ url($sub->slug) }}/" class="text-xs text-slate-600 hover:text-blue-600 hover:underline flex items-start gap-1.5 transition">
                                                    <i data-lucide="corner-down-right" class="w-3 h-3 text-slate-400 shrink-0 mt-0.5"></i>
                                                    <span class="line-clamp-1">{{ $sub->title }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="pt-4 border-t border-slate-100 mt-4 flex items-center justify-between">
                            <a href="{{ route('service.show', $svc->slug) }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                                <span>Service Details</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            <span class="text-[10px] font-mono text-slate-400">/services/{{ $svc->slug }}/</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- 2. Core Corporate & Operational Pages Section -->
        <section id="corporate-pages" class="space-y-6">
            <div class="border-b border-slate-200 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Company &amp; Operations</span>
                <h2 class="text-2xl font-black text-slate-900 font-display">Corporate Pages &amp; Regional Hubs</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($corePages as $page)
                    <a href="{{ $page['url'] }}" class="p-5 rounded-2xl bg-white border border-slate-200/90 hover:border-blue-400 hover:shadow-sm transition group flex flex-col justify-between">
                        <div class="space-y-1.5">
                            <div class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition flex items-center justify-between">
                                <span>{{ $page['title'] }}</span>
                                <i data-lucide="arrow-up-right" class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition"></i>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                {{ $page['desc'] }}
                            </p>
                        </div>
                        <div class="text-[11px] font-mono text-slate-400 pt-3 mt-2 border-t border-slate-50">
                            {{ $page['url'] }}
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- 3. Topical Knowledge Categories Section -->
        <section id="knowledge-categories" class="space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">Topical Taxonomy</span>
                    <h2 class="text-2xl font-black text-slate-900 font-display">Engineering Knowledge Categories</h2>
                </div>
                <a href="{{ route('blog.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                    Knowledge Base Hub &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('category.show', $category->slug) }}" class="p-5 rounded-2xl bg-white border border-slate-200/90 hover:border-emerald-400 hover:shadow-sm transition group flex items-start justify-between gap-4">
                        <div class="space-y-1">
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition">
                                {{ $category->name }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2">
                                {{ $category->description ?: 'Browse practical engineering and sizing guides under ' . $category->name . '.' }}
                            </p>
                            <span class="text-[11px] font-mono text-slate-400 block pt-1">
                                /category/{{ $category->slug }}/
                            </span>
                        </div>
                        <span class="shrink-0 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-mono font-bold text-xs border border-emerald-200">
                            {{ $category->published_posts_count }} guides
                        </span>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- 4. Complete Technical Knowledge Base (All 270+ Articles) -->
        <section id="technical-guides" class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 pb-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-600">Full Archive</span>
                    <h2 class="text-2xl font-black text-slate-900 font-display">All Technical Guides &amp; Sizing Articles ({{ $posts->count() }})</h2>
                </div>
                <div class="text-xs text-slate-500">
                    Showing all crawlable guide permalinks
                </div>
            </div>

            <!-- Articles Directory Grid -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-4">
                    @foreach($posts as $post)
                        <div class="text-xs py-2 border-b border-slate-100 flex items-start justify-between gap-3"
                             x-show="!searchQuery || '{{ strtolower(addslashes($post->title . ' ' . $post->slug)) }}'.includes(searchQuery.toLowerCase())">
                            <div class="space-y-0.5 min-w-0">
                                <a href="{{ route('post.show', $post->slug) }}" class="font-medium text-slate-800 hover:text-blue-600 transition block line-clamp-2" title="{{ $post->title }}">
                                    {{ $post->title }}
                                </a>
                                <div class="text-[10px] text-slate-400 font-mono truncate">
                                    /{{ $post->slug }}/
                                </div>
                            </div>
                            <span class="shrink-0 text-[10px] text-slate-400 font-mono">
                                {{ $post->published_at ? $post->published_at->format('M Y') : '' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- 5. Search Engine Feeds & XML Sitemaps Section -->
        <section id="xml-sitemaps" class="space-y-6">
            <div class="border-b border-slate-200 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-purple-600">Machine-Readable Feeds</span>
                <h2 class="text-2xl font-black text-slate-900 font-display">Search Engine Sitemaps &amp; Protocol Feeds</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="/sitemap_index.xml" target="_blank" class="p-5 rounded-2xl bg-white border border-slate-200/90 hover:border-purple-400 hover:shadow-sm transition group">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-slate-900 group-hover:text-purple-600 transition flex items-center gap-2">
                            <i data-lucide="file-code" class="w-4 h-4 text-purple-500"></i>
                            <span>Master Sitemap Index</span>
                        </span>
                        <i data-lucide="external-link" class="w-3.5 h-3.5 text-slate-400"></i>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">The canonical entry point for Googlebot and Bingbot.</p>
                    <span class="text-[11px] font-mono text-purple-600 block mt-2">/sitemap_index.xml</span>
                </a>

                <a href="/sitemap-services.xml" target="_blank" class="p-5 rounded-2xl bg-white border border-slate-200/90 hover:border-purple-400 hover:shadow-sm transition group">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-slate-900 group-hover:text-purple-600 transition flex items-center gap-2">
                            <i data-lucide="file-code" class="w-4 h-4 text-blue-500"></i>
                            <span>Services XML Sitemap</span>
                        </span>
                        <i data-lucide="external-link" class="w-3.5 h-3.5 text-slate-400"></i>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Indexes all published commercial HVAC and power services.</p>
                    <span class="text-[11px] font-mono text-blue-600 block mt-2">/sitemap-services.xml</span>
                </a>

                <a href="/sitemap-posts.xml" target="_blank" class="p-5 rounded-2xl bg-white border border-slate-200/90 hover:border-purple-400 hover:shadow-sm transition group">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-slate-900 group-hover:text-purple-600 transition flex items-center gap-2">
                            <i data-lucide="file-code" class="w-4 h-4 text-amber-500"></i>
                            <span>Articles &amp; Guides XML Sitemap</span>
                        </span>
                        <i data-lucide="external-link" class="w-3.5 h-3.5 text-slate-400"></i>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">All 270+ published technical knowledge guides.</p>
                    <span class="text-[11px] font-mono text-amber-600 block mt-2">/sitemap-posts.xml</span>
                </a>

                <a href="/sitemap-categories.xml" target="_blank" class="p-5 rounded-2xl bg-white border border-slate-200/90 hover:border-purple-400 hover:shadow-sm transition group">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-slate-900 group-hover:text-purple-600 transition flex items-center gap-2">
                            <i data-lucide="file-code" class="w-4 h-4 text-emerald-500"></i>
                            <span>Categories XML Sitemap</span>
                        </span>
                        <i data-lucide="external-link" class="w-3.5 h-3.5 text-slate-400"></i>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Taxonomy landing pages and topical hubs.</p>
                    <span class="text-[11px] font-mono text-emerald-600 block mt-2">/sitemap-categories.xml</span>
                </a>

                <a href="/sitemap-pages.xml" target="_blank" class="p-5 rounded-2xl bg-white border border-slate-200/90 hover:border-purple-400 hover:shadow-sm transition group">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-slate-900 group-hover:text-purple-600 transition flex items-center gap-2">
                            <i data-lucide="file-code" class="w-4 h-4 text-sky-500"></i>
                            <span>Pages XML Sitemap</span>
                        </span>
                        <i data-lucide="external-link" class="w-3.5 h-3.5 text-slate-400"></i>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Corporate hubs, about, team, and contact URLs.</p>
                    <span class="text-[11px] font-mono text-sky-600 block mt-2">/sitemap-pages.xml</span>
                </a>

                <a href="/robots.txt" target="_blank" class="p-5 rounded-2xl bg-white border border-slate-200/90 hover:border-purple-400 hover:shadow-sm transition group">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-slate-900 group-hover:text-purple-600 transition flex items-center gap-2">
                            <i data-lucide="bot" class="w-4 h-4 text-slate-700"></i>
                            <span>Robots.txt Directive File</span>
                        </span>
                        <i data-lucide="external-link" class="w-3.5 h-3.5 text-slate-400"></i>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Search crawler directive rules and sitemap declaration.</p>
                    <span class="text-[11px] font-mono text-slate-700 block mt-2">/robots.txt</span>
                </a>
            </div>
        </section>

    </div>
</div>
@endsection
