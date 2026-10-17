@extends('layouts.app')

@section('seo_meta')
    <title>{{ $page->seo_title }} - {{ config('app.name', 'Generator Dubai') }}</title>
    <meta name="description" content="{{ $page->seo_description }}">
    @if($page->meta_keywords)
        <meta name="keywords" content="{{ $page->meta_keywords }}">
    @endif
    <link rel="canonical" href="{{ $page->canonical_url ?: url()->current() }}">
    <meta name="robots" content="{{ $page->is_indexable ? 'index, follow' : 'noindex, nofollow' }}">
    <meta property="og:title" content="{{ $page->og_title ?: $page->seo_title }}">
    <meta property="og:description" content="{{ $page->og_description ?: $page->seo_description }}">
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <header class="text-center max-w-3xl mx-auto space-y-3">
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">{{ $page->title }}</h1>
            @if($page->content)
                <div class="prose prose-slate max-w-none text-slate-600 text-sm sm:text-base leading-relaxed">
                    {!! $page->content !!}
                </div>
            @endif
        </header>

        <!-- Evaluation / Contact Intake -->
        <div class="max-w-2xl mx-auto bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-sm space-y-6">
            <h2 class="text-xl font-black text-slate-900 flex items-center gap-2">
                <i data-lucide="zap" class="w-5 h-5 text-amber-500"></i>
                <span>Submit Power & Generator Inquiry</span>
            </h2>

            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="subject" value="Inquiry from {{ $page->title }}">

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Your Full Name</label>
                    <input type="text" name="name" required placeholder="e.g. Tariq Al Nuaimi" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">UAE Phone / WhatsApp</label>
                        <input type="tel" name="phone" required placeholder="+971 50 123 4567" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Email Address</label>
                        <input type="email" name="email" required placeholder="name@company.ae" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Power kVA Capacity</label>
                        <select name="kva_capacity" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20 bg-white">
                            <option value="50-150 kVA">50 – 150 kVA</option>
                            <option value="200-350 kVA">200 – 350 kVA</option>
                            <option value="500-800 kVA" selected>500 – 800 kVA</option>
                            <option value="1000-1250 kVA">1000 – 1250 kVA</option>
                            <option value="Multi-MW Plant">Multi-MW Plant</option>
                            <option value="Portacabin">Portacabin Office</option>
                            <option value="AMC / Maintenance">AMC / Maintenance</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Location / Emirate</label>
                        <select name="emirate" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20 bg-white">
                            <option value="Dubai" selected>Dubai</option>
                            <option value="Abu Dhabi">Abu Dhabi</option>
                            <option value="Sharjah">Sharjah</option>
                            <option value="Ajman">Ajman</option>
                            <option value="Ras Al Khaimah">Ras Al Khaimah</option>
                            <option value="Fujairah">Fujairah</option>
                            <option value="Umm Al Quwain">Umm Al Quwain</option>
                            <option value="Oman">Oman</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Project Scope or Technical Notes</label>
                    <textarea name="message" rows="4" placeholder="Describe your site location, duration of rental, inductive load, or maintenance scope..." class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20"></textarea>
                </div>

                <div class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200/80">
                    <input type="checkbox" id="pickup_requested_page" name="pickup_requested" value="yes" class="rounded text-brand-600 focus:ring-brand-500">
                    <label for="pickup_requested_page" class="text-[11px] text-slate-600 font-medium">Request <strong>Free On-Site Technical Power Audit</strong></label>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-xs bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-lg shadow-amber-500/20 transition">
                    Request Power Quote
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
