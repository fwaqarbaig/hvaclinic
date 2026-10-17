@extends('layouts.app')

@section('seo_meta')
    <!-- Primary Meta Tags -->
    <title>{{ $page->seo_title }}</title>
    <meta name="description" content="{{ $page->seo_description }}">
    @if($page->meta_keywords)
        <meta name="keywords" content="{{ $page->meta_keywords }}">
    @endif
    <link rel="canonical" href="{{ $page->canonical_url ?: url('/'.ltrim($page->slug, '/').'/') }}">
    <meta name="robots" content="{{ $page->is_indexable ? 'index, follow' : 'noindex, nofollow' }}">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $page->canonical_url ?: url('/'.ltrim($page->slug, '/').'/') }}">
    <meta property="og:title" content="{{ $page->og_title ?: $page->seo_title }}">
    <meta property="og:description" content="{{ $page->og_description ?: $page->seo_description }}">
    @if($page->seo_image)
        <meta property="og:image" content="{{ $page->seo_image }}">
    @endif
    <meta property="og:site_name" content="HVAC Clinic">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $page->og_title ?: $page->seo_title }}">
    <meta name="twitter:description" content="{{ $page->og_description ?: $page->seo_description }}">
    @if($page->seo_image)
        <meta name="twitter:image" content="{{ $page->seo_image }}">
    @endif

    <!-- Schema.org WebPage, Breadcrumbs & Dynamic FAQ Schema -->
    {!! \App\Services\SchemaGenerator::renderPrimary($page, fn() => \App\Services\SchemaGenerator::forPage($page)) !!}
    @php
        $breadcrumbList = [['name' => 'Home', 'url' => route('home')]];
        if ($isServicePage ?? false) {
            $breadcrumbList[] = ['name' => 'Services', 'url' => route('service.index')];
            if (isset($parentService) && $parentService) {
                $breadcrumbList[] = ['name' => $parentService->title, 'url' => route('service.show', $parentService->slug)];
            }
        }
        $breadcrumbList[] = ['name' => $page->title, 'url' => url('/'.ltrim($page->slug, '/').'/')];
    @endphp
    {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::breadcrumbs($breadcrumbList)) !!}
    @if(!empty($page->faqs))
        {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::forFaqs($page->faqs)) !!}
    @endif
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Visible Crawlable Breadcrumbs Navigation -->
        <nav class="flex items-center gap-2 text-xs text-slate-400 flex-wrap" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition flex items-center gap-1">
                <i data-lucide="home" class="w-3.5 h-3.5"></i>
                <span>Home</span>
            </a>
            @if($isServicePage ?? false)
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
                <a href="{{ route('service.index') }}" class="hover:text-blue-600 transition">Services</a>
                @if(isset($parentService) && $parentService)
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
                    <a href="{{ route('service.show', $parentService->slug) }}" class="hover:text-blue-600 transition font-medium">
                        {{ $parentService->title }}
                    </a>
                @endif
            @endif
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
            <span class="text-blue-700 font-semibold truncate max-w-xs sm:max-w-md">{{ $page->title }}</span>
        </nav>

        @if($isServicePage ?? false)
            <!-- Nested Service Page Layout: 8 Columns Main Content + 4 Columns Sidebar -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                
                <!-- Main Content Column (8 cols) -->
                <main class="lg:col-span-8 space-y-8">
                    <article class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-sm space-y-6">
                        <header class="space-y-4 border-b border-slate-100 pb-6">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-200">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span>Engineered UAE Specification</span>
                            </div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight font-display">
                                {{ $page->title }}
                            </h1>
                            @if($page->updated_at)
                                <div class="text-xs text-slate-400 flex items-center gap-2">
                                    <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                    <span>Last Verified &amp; Updated: {{ $page->updated_at->format('F j, Y') }}</span>
                                </div>
                            @endif
                        </header>

                        <!-- Featured Image -->
                        @if($page->featured_image_url)
                            <div class="rounded-2xl overflow-hidden aspect-[16/9] bg-slate-100 border border-slate-100">
                                <img src="{{ $page->featured_image_url }}" 
                                     alt="{{ $page->title }}" 
                                     width="1200" 
                                     height="675" 
                                     fetchpriority="high"
                                     class="w-full h-full object-cover">
                            </div>
                        @endif

                        <!-- Page Body Content with Contextual SEO Auto-Linking -->
                        <div class="prose prose-slate prose-blue max-w-none text-slate-600 leading-relaxed font-light text-sm sm:text-base prose-headings:font-display prose-headings:font-bold prose-headings:text-slate-900 prose-img:rounded-2xl prose-table:text-xs">
                            {!! app(\App\Services\SeoInternalLinker::class)->autoLinkContent($page->content, url()->current()) !!}
                        </div>

                        <!-- Primary Service Hub Connection Card -->
                        @if(isset($parentService) && $parentService)
                            <div class="mt-8 p-6 sm:p-7 rounded-3xl bg-gradient-to-br from-slate-900 via-slate-900 to-blue-950 text-white shadow-xl border border-blue-900/50 space-y-4">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-blue-500/20 text-blue-300 border border-blue-400/30">
                                        Parent Flagship Service
                                    </span>
                                    <span class="text-xs text-slate-400">24/7 Rapid UAE Mobilization</span>
                                </div>
                                <div class="space-y-1.5">
                                    <h3 class="text-xl sm:text-2xl font-black text-white font-display">
                                        Turnkey Solutions for <a href="{{ route('service.show', $parentService->slug) }}" class="text-amber-400 hover:underline">{{ $parentService->title }}</a>
                                    </h3>
                                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-light">
                                        {{ Str::limit(strip_tags((string) ($parentService->summary ?: $parentService->excerpt ?: $parentService->content)), 160) }}
                                    </p>
                                </div>
                                <div class="pt-2 flex flex-wrap items-center gap-3">
                                    <a href="{{ route('service.show', $parentService->slug) }}" class="px-5 py-2.5 rounded-xl font-bold text-xs bg-blue-600 hover:bg-blue-500 text-white shadow-md transition flex items-center gap-2">
                                        <span>View {{ $parentService->title }} Specifications</span>
                                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                    </a>
                                    <a href="https://wa.me/971503692131?text={{ urlencode('Inquiring regarding ' . $parentService->title . ' - sub-page: ' . $page->title) }}" target="_blank" class="px-4 py-2.5 rounded-xl font-bold text-xs bg-emerald-600 hover:bg-emerald-500 text-white shadow-md transition flex items-center gap-1.5">
                                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                                        <span>Instant WhatsApp Dispatch</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </article>

                    <!-- Systematic Sibling Sub-Services & Category Solutions Grid -->
                    @if(isset($siblingPages) && $siblingPages->isNotEmpty())
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm space-y-4">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-blue-600">Topical Solutions</span>
                                    <h3 class="text-lg sm:text-xl font-bold text-slate-900 font-display">Related Services in this Category</h3>
                                </div>
                                @if(isset($parentService) && $parentService)
                                    <a href="{{ route('service.show', $parentService->slug) }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 hidden sm:block">
                                        {{ $parentService->title }} Hub &rarr;
                                    </a>
                                @endif
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                @foreach($siblingPages as $sibling)
                                    <a href="{{ url('/' . ltrim($sibling->slug, '/') . '/') }}" 
                                       class="p-3.5 rounded-2xl bg-slate-50 hover:bg-blue-50/70 border border-slate-200/80 hover:border-blue-300 transition group flex flex-col justify-between">
                                        <div class="space-y-1">
                                            <div class="text-xs font-bold text-slate-900 group-hover:text-blue-700 transition line-clamp-2">
                                                {{ $sibling->title }}
                                            </div>
                                            <div class="text-[10px] text-slate-400 font-mono truncate">
                                                /{{ $sibling->slug }}/
                                            </div>
                                        </div>
                                        <div class="pt-2 text-[11px] font-semibold text-blue-600 flex items-center gap-1">
                                            <span>Explore Specs</span>
                                            <i data-lucide="arrow-right" class="w-3 h-3 group-hover:translate-x-0.5 transition-transform"></i>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </main>

                <!-- Right Sidebar (4 cols): Sizing Quote, Emergency Dispatch & Services Navigator -->
                <aside class="lg:col-span-4">
                    <div class="sticky top-28 space-y-6">
                        @include('frontend.partials.service-sidebar', [
                            'service' => $parentService ?? null,
                            'subject' => 'Service Inquiry: ' . $page->title
                        ])
                    </div>
                </aside>

            </div>
        @else
            <!-- Standard Corporate / Full-Width Page Layout -->
            <article class="bg-white rounded-3xl p-6 sm:p-12 border border-slate-200/90 shadow-sm max-w-4xl mx-auto space-y-8">
                <header class="space-y-3 border-b border-slate-100 pb-6">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600">HVAC Clinic UAE</span>
                    <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight font-display">
                        {{ $page->title }}
                    </h1>
                    @if($page->updated_at)
                        <div class="text-xs text-slate-400">Updated {{ $page->updated_at->format('F j, Y') }}</div>
                    @endif
                </header>

                @if($page->featured_image_url)
                    <div class="rounded-2xl overflow-hidden aspect-[16/9] bg-slate-100 border border-slate-100">
                        <img src="{{ $page->featured_image_url }}" 
                             alt="{{ $page->title }}" 
                             width="1200" 
                             height="675" 
                             class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="prose prose-slate prose-blue max-w-none text-slate-600 leading-relaxed font-light text-sm sm:text-base prose-headings:font-display prose-headings:font-bold prose-headings:text-slate-900">
                    {!! app(\App\Services\SeoInternalLinker::class)->autoLinkContent($page->content, url()->current()) !!}
                </div>
            </article>
        @endif

    </div>
</div>
@endsection
