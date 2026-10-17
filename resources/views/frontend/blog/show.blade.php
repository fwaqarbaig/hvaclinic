@extends('layouts.app')

@section('seo_meta')
    <title>{{ $post->seo_title }}</title>
    <meta name="description" content="{{ $post->seo_description }}">
    @if($post->meta_keywords)
        <meta name="keywords" content="{{ $post->meta_keywords }}">
    @endif
    <link rel="canonical" href="{{ $post->canonical_url ?: route('post.show', $post->slug) }}">
    <meta name="robots" content="{{ $post->is_indexable ? 'index, follow' : 'noindex, nofollow' }}">
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="HVAC Clinic">
    <meta property="og:url" content="{{ $post->canonical_url ?: route('post.show', $post->slug) }}">
    <meta property="og:title" content="{{ $post->og_title ?: $post->seo_title }}">
    <meta property="og:description" content="{{ $post->og_description ?: $post->seo_description }}">
    @if($post->seo_image)
        <meta property="og:image" content="{{ $post->seo_image }}">
        <meta name="twitter:image" content="{{ $post->seo_image }}">
    @endif
    <meta property="article:published_time" content="{{ $post->published_at?->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ $post->updated_at?->toIso8601String() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post->og_title ?: $post->seo_title }}">
    <meta name="twitter:description" content="{{ $post->og_description ?: $post->seo_description }}">

    <!-- Schema.org Article, Breadcrumbs & Dynamic FAQ Schema -->
    {!! \App\Services\SchemaGenerator::renderPrimary($post, fn() => \App\Services\SchemaGenerator::forPost($post)) !!}
    {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::breadcrumbs([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Blogs', 'url' => route('blog.index')],
        ['name' => $post->title, 'url' => route('post.show', $post->slug)],
    ])) !!}
    @if(!empty($post->faqs))
        {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::forFaqs($post->faqs)) !!}
    @endif
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-8 flex-wrap" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Home</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
            <a href="{{ route('blog.index') }}" class="hover:text-blue-600 transition">Articles</a>
            @if($post->categories->first())
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
                <a href="{{ route('category.show', $post->categories->first()->slug) }}" class="text-blue-600 hover:underline">
                    {{ $post->categories->first()->name }}
                </a>
            @endif
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
            <span class="text-slate-700 truncate max-w-xs">{{ $post->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

            <!-- Left Main Column: Article Body & Content (8 cols) -->
            <div class="lg:col-span-8 space-y-10">

                <article class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-sm space-y-8">
                    <!-- Article Categories & Header -->
                    <header class="space-y-6">
                        <div class="flex items-center gap-2 flex-wrap">
                            @foreach($post->categories as $category)
                                <a href="{{ route('category.show', $category->slug) }}" 
                                   class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Verified Guide
                            </span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-black text-slate-900 tracking-tight leading-tight font-display">
                            {{ $post->title }}
                        </h1>

                        @if($post->excerpt)
                            <p class="text-base sm:text-lg text-slate-600 leading-relaxed font-normal">
                                {{ $post->excerpt }}
                            </p>
                        @endif

                        <!-- Publication Metadata Row -->
                        <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4 text-xs text-slate-500">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs">
                                    HC
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900">HVAC Clinic Engineering Team</div>
                                    <div class="text-[11px] text-slate-400">
                                        Published {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }} &bull; {{ $post->reading_time ?: 5 }} min read
                                    </div>
                                </div>
                            </div>

                            @auth
                                @if(auth()->user()->canManageContent())
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition flex items-center gap-1">
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        <span>Edit Article</span>
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </header>

                    <!-- Featured Image -->
                    @if($post->featured_image_url)
                        <div class="rounded-2xl overflow-hidden aspect-[16/9] bg-slate-100 border border-slate-100">
                            <img src="{{ $post->featured_image_url }}" 
                                 alt="{{ $post->title }}" 
                                 width="1200" 
                                 height="675" 
                                 fetchpriority="high"
                                 class="w-full h-full object-cover">
                        </div>
                    @endif

                    <!-- Article Body Content with Contextual SEO Internal Links -->
                    <div class="prose prose-slate prose-blue max-w-none text-slate-600 leading-relaxed font-light text-sm sm:text-base prose-headings:font-display prose-headings:font-bold prose-headings:text-slate-900 prose-img:rounded-2xl prose-table:text-xs">
                        {!! app(\App\Services\SeoInternalLinker::class)->autoLinkContent($post->content, route('post.show', $post->slug)) !!}
                    </div>

                    <!-- Primary Service Solution Callout (Contextual Internal Link Hub) -->
                    @if(isset($targetedService) && $targetedService)
                        <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-slate-900 via-slate-900 to-blue-950 text-white shadow-xl border border-blue-900/50 space-y-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-blue-500/20 text-blue-300 border border-blue-400/30">
                                    Official UAE Service Hub
                                </span>
                                <span class="text-xs text-slate-400">24/7 Rapid Emergency Dispatch</span>
                            </div>
                            <div class="space-y-1.5">
                                <h3 class="text-xl sm:text-2xl font-black text-white font-display">
                                    Looking for <a href="{{ route('service.show', $targetedService->slug) }}" class="text-amber-400 hover:underline">{{ $targetedService->title }}</a>?
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-light">
                                    {{ Str::limit(strip_tags((string) ($targetedService->excerpt ?: $targetedService->summary ?: $targetedService->content)), 160) }}
                                </p>
                            </div>
                            <div class="pt-2 flex flex-wrap items-center gap-3">
                                <a href="{{ route('service.show', $targetedService->slug) }}" class="px-5 py-2.5 rounded-xl font-bold text-xs bg-blue-600 hover:bg-blue-500 text-white shadow-md transition flex items-center gap-2">
                                    <span>Explore {{ $targetedService->title }}</span>
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>
                                <a href="https://wa.me/971503692131?text={{ urlencode('Inquiring regarding ' . $targetedService->title . ' from article: ' . $post->title) }}" target="_blank" class="px-4 py-2.5 rounded-xl font-bold text-xs bg-emerald-600 hover:bg-emerald-500 text-white shadow-md transition flex items-center gap-1.5">
                                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                                    <span>Instant WhatsApp Sizing</span>
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Article Tags -->
                    @if($post->tags->isNotEmpty())
                        <div class="pt-6 border-t border-slate-100">
                            <div class="flex items-center gap-2 flex-wrap text-xs">
                                <span class="font-bold text-slate-500 uppercase tracking-wider text-[11px]">Topics:</span>
                                @foreach($post->tags as $tag)
                                    <a href="{{ route('tag.show', $tag->slug) }}" 
                                       class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-blue-50 hover:text-blue-700 text-slate-700 font-medium transition">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Previous & Next Guide Navigation -->
                    <div class="pt-8 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @if($previousPost)
                            <a href="{{ route('post.show', $previousPost->slug) }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-blue-50/50 border border-slate-200/80 transition group flex flex-col justify-between">
                                <div class="text-[11px] font-bold text-slate-400 flex items-center gap-1 mb-1">
                                    <i data-lucide="arrow-left" class="w-3.5 h-3.5 group-hover:-translate-x-1 transition-transform"></i>
                                    <span>Previous Guide</span>
                                </div>
                                <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition line-clamp-2">
                                    {{ $previousPost->title }}
                                </div>
                            </a>
                        @else
                            <div></div>
                        @endif

                        @if($nextPost)
                            <a href="{{ route('post.show', $nextPost->slug) }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-blue-50/50 border border-slate-200/80 transition group flex flex-col justify-between text-right">
                                <div class="text-[11px] font-bold text-slate-400 flex items-center justify-end gap-1 mb-1">
                                    <span>Next Guide</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                                </div>
                                <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition line-clamp-2">
                                    {{ $nextPost->title }}
                                </div>
                            </a>
                        @endif
                    </div>
                </article>

                <!-- Related Articles Section (3-card grid) -->
                @if(isset($relatedPosts) && $relatedPosts->isNotEmpty())
                    <div class="space-y-6 pt-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-widest text-blue-600 block mb-1">Continue Learning</span>
                                <h3 class="text-2xl font-black text-slate-900 font-display">Related Technical Guides</h3>
                            </div>
                            <a href="{{ route('blog.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 hidden sm:block">
                                All Guides &rarr;
                            </a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            @foreach($relatedPosts as $relPost)
                                <article class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col justify-between group">
                                    <a href="{{ route('post.show', $relPost->slug) }}" class="aspect-[16/9] block relative overflow-hidden bg-slate-100">
                                        @if($relPost->featured_image_url)
                                            <img src="{{ $relPost->featured_image_url }}" 
                                                 alt="{{ $relPost->title }}" 
                                                 width="400" 
                                                 height="225" 
                                                 loading="lazy" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400">
                                                <i data-lucide="snowflake" class="w-8 h-8"></i>
                                            </div>
                                        @endif
                                    </a>
                                    <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                                        <div>
                                            <div class="text-[10px] text-slate-400 mb-1">
                                                {{ $relPost->published_at ? $relPost->published_at->format('M d, Y') : $relPost->created_at->format('M d, Y') }}
                                            </div>
                                            <h4 class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition line-clamp-2">
                                                <a href="{{ route('post.show', $relPost->slug) }}">{{ $relPost->title }}</a>
                                            </h4>
                                        </div>
                                        <div class="pt-2 border-t border-slate-100 flex items-center justify-end">
                                            <a href="{{ route('post.show', $relPost->slug) }}" class="text-[11px] font-semibold text-blue-600 hover:text-blue-700" aria-label="Read {{ $relPost->title }}">
                                                Read &rarr;
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <!-- Right Sidebar (4 cols) -->
            <aside class="lg:col-span-4 space-y-6">
                <div class="sticky top-28 space-y-6">

                    <!-- Emergency 24/7 Hotline Card -->
                    <div class="bg-gradient-to-br from-slate-900 via-slate-900 to-blue-950 text-white rounded-3xl p-6 border border-slate-800 shadow-md space-y-4">
                        <div class="flex items-center gap-2 text-xs font-bold uppercase text-amber-400">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                            <span>24/7 Rapid Emergency Dispatch</span>
                        </div>
                        <div class="space-y-1">
                            <div class="text-xs text-slate-400">Facing a chiller breakdown or site power issue?</div>
                            <a href="tel:+971503692131" class="text-xl font-black text-white hover:text-amber-400 transition block font-mono">
                                +971 50 369 2131
                            </a>
                            <div class="text-[11px] text-slate-400">Secondary: <a href="tel:+971506457285" class="hover:text-amber-300 font-mono">+971 50 645 7285</a></div>
                        </div>
                        <a href="https://wa.me/971503692131?text={{ urlencode('Hello HVAC Clinic, I am reading ' . $post->title . ' and need assistance.') }}" target="_blank" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center justify-center gap-2 transition shadow-md">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            <span>Chat on WhatsApp</span>
                        </a>
                        <div class="pt-2 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
                            <span>Mobilization: <strong>60–120 Min</strong></span>
                            <span>All 7 Emirates</span>
                        </div>
                    </div>

                    <!-- Technical Sizing & Quote Form Card -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-4">
                        <div class="flex items-center gap-2 text-xs font-bold uppercase text-blue-600">
                            <i data-lucide="calculator" class="w-4 h-4"></i>
                            <span>Technical Sizing Quote</span>
                        </div>
                        <h4 class="text-lg font-black text-slate-900 font-display">Need Equipment on Site?</h4>
                        <p class="text-xs text-slate-500">Get an itemized engineering quote for chillers, packaged AC, wild air, or generators within 15 minutes.</p>

                        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-3 pt-1">
                            @csrf
                            <input type="hidden" name="subject" value="Article Inquiry: {{ $post->title }}">
                            <div style="display:none!important;" aria-hidden="true"><input type="text" name="_hp_website"></div>

                            <div>
                                <label class="block text-[11px] font-bold uppercase text-slate-700 mb-1">Your Name</label>
                                <input type="text" name="name" required placeholder="Full Name" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold uppercase text-slate-700 mb-1">Phone / WhatsApp</label>
                                <input type="tel" name="phone" required placeholder="+971 50 123 4567" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold uppercase text-slate-700 mb-1">Equipment Category</label>
                                <select name="capacity_range" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-white">
                                    <option value="Rental Chillers">Rental Chillers (50–1500 TR)</option>
                                    <option value="Rental AC">Rental AC & Spot Coolers</option>
                                    <option value="Wild Air">Wild Air & Ventilation</option>
                                    <option value="Rental Generators">Diesel Generators (20–2500 kVA)</option>
                                    <option value="Chiller Maintenance">Chiller Maintenance / AMC</option>
                                    <option value="Used Equipment">Used & Refurbished Equipment</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full py-3 rounded-xl font-bold text-xs bg-blue-600 hover:bg-blue-700 text-white shadow-md transition">
                                Request Engineering Quote
                            </button>
                        </form>
                    </div>

                    <!-- Core Services Navigator -->
                    @if(isset($services) && $services->isNotEmpty())
                        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-4">
                            <h5 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                                <i data-lucide="layers" class="w-4 h-4 text-blue-500"></i>
                                <span>Core Engineering Solutions</span>
                            </h5>
                            <div class="space-y-1.5">
                                @foreach($services as $svc)
                                    <a href="{{ route('service.show', $svc->slug) }}" 
                                       class="flex items-center justify-between p-3 rounded-2xl text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-900 transition group border border-transparent hover:border-blue-200">
                                        <span class="truncate">{{ $svc->title }}</span>
                                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-0.5 transition shrink-0"></i>
                                    </a>
                                @endforeach
                            </div>
                            <div class="pt-2">
                                <a href="{{ route('service.index') }}" class="block text-center py-2 text-xs font-bold text-blue-600 hover:text-blue-700 transition">
                                    Explore All Services &rarr;
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Knowledge Hub Categories Navigator -->
                    @if(isset($categories) && $categories->isNotEmpty())
                        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-4">
                            <h5 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                                <i data-lucide="folder" class="w-4 h-4 text-sky-500"></i>
                                <span>Topical Knowledge Hubs</span>
                            </h5>
                            <div class="space-y-1.5">
                                @foreach($categories as $categoryItem)
                                    @if($categoryItem->slug !== 'blog')
                                        <a href="{{ route('category.show', $categoryItem->slug) }}" 
                                           class="flex items-center justify-between p-2.5 rounded-xl text-xs font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-900 transition group">
                                            <span class="truncate">{{ $categoryItem->name }}</span>
                                            <span class="text-[10px] text-slate-400 bg-slate-100 group-hover:bg-sky-100 group-hover:text-sky-700 font-mono px-2 py-0.5 rounded-full transition">
                                                {{ $categoryItem->published_posts_count ?? $categoryItem->posts_count ?? 0 }}
                                            </span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                            <div class="pt-2 border-t border-slate-100">
                                <a href="{{ route('blog.index') }}" class="block text-center py-1 text-xs font-bold text-sky-600 hover:text-sky-700 transition">
                                    All Knowledge Categories &rarr;
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </aside>

        </div>
    </div>
</div>
@endsection
