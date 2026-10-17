@extends('layouts.app')

@section('seo_meta')
    <title>{{ $category->name }} | HVAC Clinic Dubai</title>
    <meta name="description" content="{{ $category->description ?: 'Browse articles in category ' . $category->name . ' - HVAC Clinic Dubai' }}">
    <link rel="canonical" href="{{ $posts->currentPage() > 1 ? $posts->url($posts->currentPage()) : route('category.show', $category->slug) }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="HVAC Clinic">
    <meta property="og:title" content="{{ $category->name }} | HVAC Clinic Dubai">
    <meta property="og:description" content="{{ $category->description ?: 'Browse articles in category ' . $category->name }}">
    <meta property="og:url" content="{{ route('category.show', $category->slug) }}">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Schema.org BreadcrumbList & ItemList -->
    {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::breadcrumbs([
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Blogs', 'url' => route('blog.index')],
        ['name' => $category->name, 'url' => route('category.show', $category->slug)],
    ])) !!}
    {!! \App\Services\SchemaGenerator::render(\App\Services\SchemaGenerator::forItemList(
        $category->name . ' Articles - HVAC Clinic',
        $posts,
        fn($post) => [
            'name' => $post->title,
            'url' => route('post.show', $post->slug),
            'description' => $post->seo_description,
            'image' => $post->featured_image_url,
        ]
    )) !!}
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs text-slate-400" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Home</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
            <a href="{{ route('blog.index') }}" class="hover:text-blue-600 transition">Blogs</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
            <span class="text-blue-600 font-semibold">{{ $category->name }}</span>
        </nav>

        <!-- Header -->
        <div class="border-b border-slate-200 pb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-blue-600 block mb-1">Article Category</span>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    {{ $category->name }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-2 max-w-2xl">
                    {{ $category->description ?: 'Explore technical guides and operational insights under ' . $category->name . '.' }}
                </p>
            </div>

            <!-- Search Bar -->
            <form action="{{ route('blog.index') }}" method="GET" class="relative w-full md:w-80">
                <input type="text" 
                       name="q" 
                       placeholder="Search articles..."
                       class="w-full pl-9 pr-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white shadow-xs">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-3 pointer-events-none"></i>
            </form>
        </div>

        <!-- Posts Grid (3-column card grid) -->
        @if($posts->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <article class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col justify-between group">
                        <!-- Featured Image Thumbnail -->
                        <a href="{{ route('post.show', $post->slug) }}" class="aspect-[16/9] block relative overflow-hidden bg-slate-100">
                            @if($post->featured_image_url)
                                <img src="{{ $post->featured_image_url }}" 
                                     alt="{{ $post->title }}" 
                                     width="600" 
                                     height="338" 
                                     loading="lazy" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                     onerror="this.onerror=null; this.src='/wp-content/uploads/2026/03/hvac.gif';">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-blue-50 text-blue-400">
                                    <i data-lucide="snowflake" class="w-10 h-10 stroke-[1.5]"></i>
                                </div>
                            @endif

                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[10px] font-bold bg-white/95 text-slate-800 shadow-sm backdrop-blur-xs">
                                {{ $category->name }}
                            </span>
                        </a>

                        <!-- Card Body -->
                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <div class="flex items-center gap-2 text-[11px] text-slate-400 mb-1.5">
                                    <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $post->reading_time ?: 5 }} min read</span>
                                </div>
                                <h2 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition line-clamp-2">
                                    <a href="{{ route('post.show', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h2>
                                <p class="text-xs text-slate-500 line-clamp-3 mt-2 leading-relaxed">
                                    {{ $post->excerpt ?: $post->seo_description }}
                                </p>
                            </div>

                            <!-- Card Footer -->
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                                <a href="{{ route('post.show', $post->slug) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1 group/btn">
                                    <span>Read</span>
                                    <span class="group-hover/btn:translate-x-0.5 transition-transform">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination Bar -->
            @if($posts->hasPages())
                <div class="pt-8 flex justify-center">
                    {{ $posts->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/90 shadow-sm space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                    <i data-lucide="book-open" class="w-8 h-8"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900">No articles in this category</h3>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                    Browse all our published engineering guides.
                </p>
                <div class="pt-2">
                    <a href="{{ route('blog.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white transition inline-block">
                        View All Articles
                    </a>
                </div>
            </div>
        @endif

        <!-- Bottom Assistance / Emergency CTA Banner -->
        <div class="rounded-3xl bg-gradient-to-br from-slate-900 via-slate-900 to-blue-950 text-white p-8 sm:p-12 border border-slate-800 shadow-xl flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="space-y-3 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500/15 text-amber-400 border border-amber-500/30">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>24/7 Rapid UAE Engineering Support</span>
                </div>
                <h3 class="text-2xl sm:text-3xl font-black font-display tracking-tight">
                    Need Technical HVAC or Temporary Power Sizing?
                </h3>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-light">
                    Our certified refrigeration and electrical engineers provide 24/7 on-site technical diagnostics, psychrometric load audits, and rapid 60–120 minute mobilization across all 7 Emirates.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="tel:+971503692131" class="px-5 py-3 rounded-xl font-bold text-xs bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-lg shadow-amber-500/20 transition flex items-center gap-2">
                    <i data-lucide="phone-call" class="w-4 h-4"></i>
                    <span>+971 50 369 2131</span>
                </a>
                <a href="https://wa.me/971503692131?text={{ urlencode('Hello HVAC Clinic, I need technical assistance with cooling or power.') }}" target="_blank" class="px-5 py-3 rounded-xl font-bold text-xs bg-emerald-600 hover:bg-emerald-500 text-white shadow-lg transition flex items-center gap-2">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>WhatsApp</span>
                </a>
                <a href="{{ route('contact') }}" class="px-5 py-3 rounded-xl font-bold text-xs bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition flex items-center gap-2">
                    <span>Request Quote</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
