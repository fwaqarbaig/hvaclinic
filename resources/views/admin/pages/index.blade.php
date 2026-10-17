@extends('layouts.admin')

@section('title', 'All Pages')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>Pages</span>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-200 text-slate-700">{{ $counts['all'] }}</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">Manage static pages like About, Contact, Services, and Privacy Policy</p>
        </div>
        <a href="{{ route('admin.pages.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-500/20 transition self-start sm:self-auto">
            <i data-lucide="plus" class="w-4 h-4"></i> Add New Page
        </a>
    </div>

    <!-- Status Filter Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-200 pb-3 text-xs font-medium">
        <a href="{{ route('admin.pages.index') }}" 
           class="px-3 py-1.5 rounded-lg transition {{ empty($status) ? 'bg-slate-900 text-white font-semibold' : 'text-slate-600 hover:bg-slate-200/60' }}">
            All ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.pages.index', ['status' => 'published']) }}" 
           class="px-3 py-1.5 rounded-lg transition {{ $status === 'published' ? 'bg-emerald-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-200/60' }}">
            Published ({{ $counts['published'] }})
        </a>
        <a href="{{ route('admin.pages.index', ['status' => 'draft']) }}" 
           class="px-3 py-1.5 rounded-lg transition {{ $status === 'draft' ? 'bg-amber-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-200/60' }}">
            Drafts ({{ $counts['draft'] }})
        </a>
    </div>

    <!-- Search Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
        <form action="{{ route('admin.pages.index') }}" method="GET" class="flex items-center gap-3 w-full max-w-sm">
            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <div class="relative w-full">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search pages..."
                       class="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5"></i>
            </div>
            <button type="submit" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl">Search</button>
            @if($search)
                <a href="{{ route('admin.pages.index') }}" class="text-xs text-rose-600 hover:underline">Reset</a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-3 px-4">Title & Slug</th>
                    <th class="py-3 px-4">Focus Keyword</th>
                    <th class="py-3 px-4">Yoast Signal</th>
                    <th class="py-3 px-4">Author</th>
                    <th class="py-3 px-4">Template</th>
                    <th class="py-3 px-4">Status & Date</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($pages as $page)
                    @php
                        $score = $page->seo_score ?? 0;
                        $rating = $score >= 80 ? 'good' : ($score >= 50 ? 'ok' : 'poor');
                    @endphp
                    <tr id="seo-row-page-{{ $page->id }}" class="hover:bg-slate-50/80 transition">
                        <!-- Title & Slug -->
                        <td class="py-4 px-4 max-w-sm">
                            <div class="font-bold text-slate-900 hover:text-brand-600 transition text-sm">
                                <a href="{{ route('admin.pages.edit', $page) }}">{{ $page->title }}</a>
                            </div>
                            <div class="text-[11px] text-slate-400 mt-0.5 font-mono">/page/{{ $page->slug }}</div>
                        </td>

                        <!-- Focus Keyword -->
                        <td class="py-4 px-4 seo-kw-cell">
                            @if($page->focus_keyword)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                    <i data-lucide="tag" class="w-3 h-3 text-purple-500"></i>
                                    <span>{{ $page->focus_keyword }}</span>
                                </span>
                            @else
                                <button type="button" 
                                        @click="$dispatch('open-quick-seo', {
                                            type: 'page',
                                            endpoint: '{{ route('admin.pages.quick-seo', $page) }}',
                                            id: {{ $page->id }},
                                            title: @js($page->title),
                                            slug: @js($page->slug),
                                            focus_keyword: @js($page->focus_keyword ?? ''),
                                            meta_title: @js($page->meta_title ?? ''),
                                            meta_description: @js($page->meta_description ?? ''),
                                            schema_markup: @js($page->schema_markup ?? ''),
                                            seo_score: {{ (int) ($page->seo_score ?? 0) }}
                                        })" 
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-dashed border-rose-300 hover:bg-rose-100 transition">
                                    <i data-lucide="plus" class="w-3 h-3"></i>
                                    <span>+ Add Keyword</span>
                                </button>
                            @endif
                        </td>

                        <!-- Yoast SEO Signal -->
                        <td class="py-4 px-4 seo-sig-cell">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $rating === 'good' ? 'bg-emerald-50 text-emerald-700 border-emerald-200 shadow-xs' : ($rating === 'ok' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                <span class="w-2 h-2 rounded-full {{ $rating === 'good' ? 'bg-emerald-500 animate-pulse' : ($rating === 'ok' ? 'bg-amber-500' : 'bg-rose-500') }}"></span>
                                <span>{{ $score }}/100</span>
                                <span class="uppercase text-[9px] opacity-75">({{ $rating }})</span>
                            </div>
                        </td>

                        <!-- Author -->
                        <td class="py-4 px-4">{{ $page->user->name ?? 'Admin' }}</td>

                        <!-- Template -->
                        <td class="py-4 px-4">
                            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 text-[11px] font-mono capitalize">{{ $page->template }}</span>
                        </td>

                        <!-- Status & Date -->
                        <td class="py-4 px-4 whitespace-nowrap">
                            @if($page->status === 'published')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Published</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">Draft</span>
                            @endif
                            <div class="text-[11px] text-slate-400 mt-1">{{ $page->updated_at->format('M d, Y') }}</div>
                        </td>

                        <!-- Actions -->
                        <td class="py-4 px-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1.5">
                                <button type="button" 
                                        @click="$dispatch('open-quick-seo', {
                                            type: 'page',
                                            endpoint: '{{ route('admin.pages.quick-seo', $page) }}',
                                            id: {{ $page->id }},
                                            title: @js($page->title),
                                            slug: @js($page->slug),
                                            focus_keyword: @js($page->focus_keyword ?? ''),
                                            meta_title: @js($page->meta_title ?? ''),
                                            meta_description: @js($page->meta_description ?? ''),
                                            schema_markup: @js($page->schema_markup ?? ''),
                                            seo_score: {{ (int) ($page->seo_score ?? 0) }}
                                        })"
                                        class="px-2.5 py-1 rounded-lg text-purple-700 hover:text-purple-900 bg-purple-50 hover:bg-purple-100 text-[11px] font-bold border border-purple-200 transition flex items-center gap-1"
                                        title="Quick Edit Keyword & Signals">
                                    <i data-lucide="sparkles" class="w-3 h-3 text-purple-600"></i>
                                    <span>Quick SEO</span>
                                </button>
                                <a href="{{ route('page.show', $page->slug) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition" title="View Public Page">
                                    <i data-lucide="external-link" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.pages.edit', $page) }}" class="p-1.5 text-slate-400 hover:text-brand-600 hover:bg-slate-100 rounded-lg transition" title="Edit Page">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Delete page {{ $page->title }}?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-12 text-center text-slate-400">No pages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($pages->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $pages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
