@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="space-y-6" x-data="{ editModalOpen: false, editCategory: { id: null, name: '', slug: '', description: '', parent_id: '', meta_title: '', meta_description: '', canonical_url: '', is_indexable: true, schema_markup: '' } }">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Categories</h1>
            <p class="text-xs text-slate-500 mt-1">Organize articles and content into structured categories</p>
        </div>
    </div>

    <!-- 2-Column WordPress Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <!-- Left: Add New Category Form -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
            <h2 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                <i data-lucide="folder-plus" class="w-4 h-4 text-brand-600"></i>
                Add New Category
            </h2>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="catName" class="block text-xs font-bold text-slate-700 mb-1">Name</label>
                    <input type="text" id="catName" name="name" required placeholder="e.g. Artificial Intelligence"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500">
                    <p class="text-[10px] text-slate-400 mt-1">The name is how it appears on your site.</p>
                </div>

                <div>
                    <label for="catSlug" class="block text-xs font-bold text-slate-700 mb-1">Slug (Optional)</label>
                    <input type="text" id="catSlug" name="slug" placeholder="e.g. artificial-intelligence"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500">
                    <p class="text-[10px] text-slate-400 mt-1">URL-friendly version of the name. Auto-generated if empty.</p>
                </div>

                <div>
                    <label for="catParent" class="block text-xs font-bold text-slate-700 mb-1">Parent Category</label>
                    <select id="catParent" name="parent_id" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                        <option value="">None (Top Level)</option>
                        @foreach($allCategories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="catDesc" class="block text-xs font-bold text-slate-700 mb-1">Description</label>
                    <textarea id="catDesc" name="description" rows="3" placeholder="Category summary..."
                              class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500"></textarea>
                </div>

                <div class="border-t border-slate-100 pt-3 space-y-3">
                    <span class="block text-xs font-bold text-slate-800">SEO Settings</span>
                    <div>
                        <label for="catMetaTitle" class="block text-xs font-semibold text-slate-600 mb-1">Meta Title</label>
                        <input type="text" id="catMetaTitle" name="meta_title" placeholder="SEO Page Title"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    </div>
                    <div>
                        <label for="catMetaDesc" class="block text-xs font-semibold text-slate-600 mb-1">Meta Description</label>
                        <textarea id="catMetaDesc" name="meta_description" rows="2" placeholder="SEO Description..."
                                  class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20"></textarea>
                    </div>
                    <div>
                        <label for="catCanonical" class="block text-xs font-semibold text-slate-600 mb-1">Canonical URL</label>
                        <input type="url" id="catCanonical" name="canonical_url" placeholder="https://hvaclinic.com/category/..."
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="catIndexable" name="is_indexable" value="1" checked
                               class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                        <label for="catIndexable" class="text-xs text-slate-700">Allow search engines to index</label>
                    </div>
                </div>

                <div>
                    <label for="catSchema" class="block text-xs font-bold text-slate-700 mb-1 flex items-center justify-between">
                        <span>Schema.org JSON-LD (Optional)</span>
                        <span class="text-[10px] text-slate-400 font-normal">CollectionPage / BreadcrumbList</span>
                    </label>
                    <textarea id="catSchema" name="schema_markup" rows="3" placeholder='{"@@context":"https://schema.org","@type":"CollectionPage", ...}'
                              class="w-full font-mono px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500"></textarea>
                    <p class="text-[10px] text-slate-400 mt-1">Custom JSON-LD schema injected on this category page.</p>
                </div>

                <button type="submit" class="w-full py-2.5 px-4 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-bold shadow-md shadow-brand-500/20 transition">
                    Add New Category
                </button>
            </form>
        </div>

        <!-- Right: Category Table -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Search -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <form action="{{ route('admin.categories.index') }}" method="GET" class="flex items-center gap-2 w-full max-w-sm">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search categories..."
                               class="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5"></i>
                    </div>
                    <button type="submit" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl">Search</button>
                    @if($search)
                        <a href="{{ route('admin.categories.index') }}" class="text-xs text-rose-600 hover:underline">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4">Slug</th>
                            <th class="py-3 px-4">Parent</th>
                            <th class="py-3 px-4 text-center">Posts Count</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($categories as $cat)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('category.show', $cat->slug) }}" target="_blank" class="hover:text-brand-600">
                                            {{ $cat->name }}
                                        </a>
                                        @if(!empty($cat->schema_markup))
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono bg-purple-50 text-purple-700 border border-purple-200" title="Custom Schema.org configured">
                                                JSON-LD
                                            </span>
                                        @endif
                                    </div>
                                    @if($cat->description)
                                        <p class="text-[11px] font-normal text-slate-400 line-clamp-1 mt-0.5">{{ $cat->description }}</p>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-mono text-[11px] text-slate-500">{{ $cat->slug }}</td>
                                <td class="py-3.5 px-4 text-slate-600">{{ $cat->parent->name ?? '—' }}</td>
                                <td class="py-3.5 px-4 text-center font-semibold">
                                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[11px]">{{ $cat->posts_count }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1">
                                        <button type="button" 
                                                @click="editCategory = { id: {{ $cat->id }}, name: '{{ addslashes($cat->name) }}', slug: '{{ $cat->slug }}', description: '{{ addslashes($cat->description ?? '') }}', parent_id: '{{ $cat->parent_id ?? '' }}', meta_title: '{{ addslashes($cat->meta_title ?? '') }}', meta_description: '{{ addslashes($cat->meta_description ?? '') }}', canonical_url: '{{ addslashes($cat->canonical_url ?? '') }}', is_indexable: {{ $cat->is_indexable ? 'true' : 'false' }}, schema_markup: {{ json_encode($cat->schema_markup ?? '') }} }; editModalOpen = true"
                                                class="p-1.5 text-slate-400 hover:text-brand-600 hover:bg-slate-100 rounded-lg transition" title="Edit">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Delete category {{ $cat->name }}?');" class="inline">
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
                                <td colspan="5" class="p-8 text-center text-slate-400">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($categories->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 space-y-4" @click.outside="editModalOpen = false">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="font-bold text-slate-900 text-sm">Edit Category</h3>
                <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>

            <form :action="'{{ url('admin/categories') }}/' + editCategory.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Name</label>
                    <input type="text" name="name" x-model="editCategory.name" required
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Slug</label>
                    <input type="text" name="slug" x-model="editCategory.slug"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Parent Category</label>
                    <select name="parent_id" x-model="editCategory.parent_id" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200">
                        <option value="">None (Top Level)</option>
                        @foreach($allCategories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Description</label>
                    <textarea name="description" x-model="editCategory.description" rows="3"
                              class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200"></textarea>
                </div>

                <div class="border-t border-slate-100 pt-3 space-y-3">
                    <span class="block text-xs font-bold text-slate-800">SEO Settings</span>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" x-model="editCategory.meta_title"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Meta Description</label>
                        <textarea name="meta_description" x-model="editCategory.meta_description" rows="2"
                                  class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Canonical URL</label>
                        <input type="url" name="canonical_url" x-model="editCategory.canonical_url"
                               class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200">
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_indexable" value="1" x-model="editCategory.is_indexable"
                               class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                        <label class="text-xs text-slate-700">Allow search engines to index</label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center justify-between">
                        <span>Schema.org JSON-LD (Optional)</span>
                        <span class="text-[10px] text-slate-400 font-normal">CollectionPage / BreadcrumbList</span>
                    </label>
                    <textarea name="schema_markup" x-model="editCategory.schema_markup" rows="4"
                              placeholder='{"@@context":"https://schema.org","@type":"CollectionPage", ...}'
                              class="w-full font-mono px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-xs font-semibold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-xs font-bold rounded-xl bg-brand-600 hover:bg-brand-700 text-white">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
