@extends('layouts.app')

@section('seo_meta')
    <title>{{ $page->seo_title }} - {{ config('app.name', 'HVAC Clinic') }}</title>
    <meta name="description" content="{{ $page->seo_description }}">
    @if($page->meta_keywords)
        <meta name="keywords" content="{{ $page->meta_keywords }}">
    @endif
    <link rel="canonical" href="{{ $page->canonical_url ?: url()->current() }}">
    <meta name="robots" content="{{ $page->is_indexable ? 'index, follow' : 'noindex, nofollow' }}">
    <meta property="og:title" content="{{ $page->og_title ?: $page->seo_title }}">
    <meta property="og:description" content="{{ $page->og_description ?: $page->seo_description }}">

    <!-- Schema.org Primary WebPage Schema -->
    {!! \App\Services\SchemaGenerator::renderPrimary($page, fn() => \App\Services\SchemaGenerator::forPage($page)) !!}
@endsection

@section('content')
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <header class="space-y-4 border-b border-slate-100 pb-8">
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">
                {{ $page->title }}
            </h1>
        </header>

        @if($page->featured_image_url)
            <div class="rounded-3xl overflow-hidden aspect-[21/9] shadow-md bg-slate-100">
                <img src="{{ $page->featured_image_url }}" 
                     alt="{{ $page->title }}" 
                     width="1200" 
                     height="514" 
                     loading="eager" 
                     fetchpriority="high" 
                     class="w-full h-full object-cover">
            </div>

        @endif

        <div class="prose prose-slate prose-xl max-w-none leading-relaxed">
            {!! $page->content !!}
        </div>
    </div>
</div>
@endsection
