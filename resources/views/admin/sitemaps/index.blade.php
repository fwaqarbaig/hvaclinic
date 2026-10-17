@extends('layouts.admin')

@section('title', 'XML Sitemaps & Search Engine Indexing')

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div class="max-w-2xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 mb-3">
                <i data-lucide="network" class="w-3.5 h-3.5"></i> Google Search Console & Yoast Compatible Sitemaps
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">XML Sitemaps & Resubmitting</h1>
            <p class="mt-2 text-sm text-slate-300 leading-relaxed">
                Automatically generate high-performance XML sitemaps for Google, Bing, and search crawlers. Keep every service page, article, and static URL indexed with zero 404s.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 shrink-0">
            <form action="{{ route('admin.sitemaps.resubmit') }}" method="POST">
                @csrf
                <button type="submit" class="w-full sm:w-auto px-5 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs shadow-lg shadow-emerald-500/30 transition flex items-center justify-center gap-2">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    <span>Resubmit & Flush Sitemaps</span>
                </button>
            </form>
            <a href="{{ $sitemapIndexUrl }}" target="_blank" class="w-full sm:w-auto px-4 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs backdrop-blur-sm transition flex items-center justify-center gap-1.5">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                <span>Open Index</span>
            </a>
        </div>
    </div>

    <!-- Quick Info Banner -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Search Console Loc</span>
                <p class="text-xs font-mono font-bold text-slate-800 break-all select-all mt-0.5">https://hvaclinic.com/sitemap_index.xml</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                <i data-lucide="file-code" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Robots.txt Location</span>
                <p class="text-xs font-mono font-bold text-slate-800 break-all mt-0.5">
                    <a href="{{ $robotsUrl }}" target="_blank" class="text-sky-600 hover:underline">/robots.txt (Live)</a>
                </p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                <i data-lucide="zap" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Cache Status</span>
                <p class="text-xs font-bold text-emerald-600 mt-0.5">Active Fast-Cache (Hourly auto-refresh)</p>
            </div>
        </div>
    </div>

    <!-- Sitemaps List -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70 flex items-center justify-between">
            <h2 class="text-sm font-black text-slate-900 flex items-center gap-2">
                <i data-lucide="list" class="w-4 h-4 text-emerald-600"></i>
                <span>Generated XML Sitemaps</span>
            </h2>
            <span class="text-xs font-bold text-slate-500">{{ count($sitemaps) }} XML feeds active</span>
        </div>

        <div class="divide-y divide-slate-100">
            @foreach($sitemaps as $sitemap)
                <div class="p-6 hover:bg-slate-50/60 transition flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2.5">
                            <h3 class="text-sm font-bold text-slate-900">{{ $sitemap['name'] }}</h3>
                            <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">
                                {{ $sitemap['count'] }} URLs
                            </span>
                        </div>
                        <p class="text-xs text-slate-500">{{ $sitemap['description'] }}</p>
                        <div class="flex items-center gap-3 text-[11px] text-slate-400 font-mono">
                            <span>Loc: <strong class="text-slate-700">{{ $sitemap['public_url'] }}</strong></span>
                            <span>&bull;</span>
                            <span>Updated: {{ is_string($sitemap['lastmod']) ? $sitemap['lastmod'] : $sitemap['lastmod']->format('M j, Y H:i') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ $sitemap['url'] }}" target="_blank" class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                            <i data-lucide="external-link" class="w-3.5 h-3.5 text-slate-400"></i>
                            <span>View XML</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
