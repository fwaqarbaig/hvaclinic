<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $categories = Category::with('parent')
            ->withCount('posts')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $allCategories = Category::orderBy('name')->get();

        return view('admin.categories.index', compact('categories', 'allCategories', 'search'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'canonical_url' => ['nullable', 'string', 'max:255'],
            'is_indexable' => ['nullable', 'boolean'],
            'schema_markup' => ['nullable', 'string'],
        ]);

        $slug = ! empty($validated['slug'])
            ? Category::createUniqueSlug($validated['slug'])
            : Category::createUniqueSlug($validated['name']);

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'parent_id' => $validated['parent_id'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'canonical_url' => $validated['canonical_url'] ?? null,
            'is_indexable' => $request->boolean('is_indexable', true),
            'schema_markup' => $validated['schema_markup'] ?? null,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', "Category '{$validated['name']}' created successfully.");
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug,'.$category->id],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:categories,id', 'not_in:'.$category->id],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'canonical_url' => ['nullable', 'string', 'max:255'],
            'is_indexable' => ['nullable', 'boolean'],
            'schema_markup' => ['nullable', 'string'],
        ]);

        $slug = ! empty($validated['slug'])
            ? Category::createUniqueSlug($validated['slug'], $category->id)
            : Category::createUniqueSlug($validated['name'], $category->id);

        $category->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'parent_id' => $validated['parent_id'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'canonical_url' => $validated['canonical_url'] ?? null,
            'is_indexable' => $request->boolean('is_indexable', true),
            'schema_markup' => $validated['schema_markup'] ?? null,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', "Category '{$category->name}' updated successfully.");
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $name = $category->name;
        $category->posts()->detach();
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', "Category '{$name}' deleted successfully.");
    }
}
