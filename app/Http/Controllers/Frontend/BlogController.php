<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Service;
use App\Models\Tag;
use App\Models\User;
use App\Services\SeoInternalLinker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts.
     */
    public function index(Request $request): View
    {
        $search = $request->query('q');

        $query = Post::published()->with(['user', 'categories', 'tags'])->latest('published_at');

        if ($search) {
            $query->search($search);
        }

        $posts = $query->paginate(9)->withQueryString();
        $categories = Category::whereHas('publishedPosts')
            ->withCount(['publishedPosts'])
            ->get();
        $tags = Tag::whereHas('publishedPosts')
            ->withCount(['publishedPosts'])
            ->get();

        return view('frontend.blog.index', compact('posts', 'search', 'categories', 'tags'));
    }

    /**
     * Display the specified blog post with SEO and related content.
     */
    public function show(string $slug, ?SeoInternalLinker $linker = null): View|RedirectResponse
    {
        $linker = $linker ?? app(SeoInternalLinker::class);

        $postQuery = Post::with(['user', 'categories', 'tags'])
            ->where('slug', $slug);

        // If not logged in as content manager, only show published posts
        if (! auth()->check() || ! auth()->user()->canManageContent()) {
            $postQuery->where('status', 'published')
                ->where('published_at', '<=', now());
        }

        $post = $postQuery->firstOrFail();

        // Match targeted commercial recovery service for contextual internal linking
        $targetedService = $linker->matchServiceForPost($post);

        // Related posts in same categories
        $categoryIds = $post->categories->pluck('id')->toArray();
        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->whereHas('categories', fn ($q) => $q->whereIn('categories.id', $categoryIds))
            ->with(['user', 'categories'])
            ->latest('published_at')
            ->take(3)
            ->get();

        // Prev and Next posts
        $previousPost = Post::published()
            ->where('published_at', '<', $post->published_at ?? now())
            ->latest('published_at')
            ->first();

        $nextPost = Post::published()
            ->where('published_at', '>', $post->published_at ?? now())
            ->oldest('published_at')
            ->first();

        $services = Service::published()->ordered()->get();
        $categories = Category::whereHas('publishedPosts')
            ->withCount(['publishedPosts'])
            ->orderByDesc('published_posts_count')
            ->get();

        return view('frontend.blog.show', compact('post', 'relatedPosts', 'previousPost', 'nextPost', 'targetedService', 'services', 'categories'));
    }

    /**
     * Display posts for a specific category.
     */
    public function category(string $slug): View|RedirectResponse
    {
        if ($slug === 'blog') {
            return redirect()->route('blog.index', [], 301);
        }

        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = $category->publishedPosts()
            ->with(['user', 'categories', 'tags'])
            ->latest('published_at')
            ->paginate(9);

        $categories = Category::withCount(['posts' => fn ($q) => $q->where('status', 'published')])->get();

        $canonicalUrl = $category->canonical_url ?: route('category.show', $category->slug);
        if (! str_ends_with($canonicalUrl, '/')) {
            $canonicalUrl .= '/';
        }

        return view('frontend.blog.archive', [
            'archiveTitle' => $category->meta_title ?: $category->name,
            'archiveHeading' => $category->name,
            'archiveLabel' => 'Article category',
            'archiveDescription' => $category->meta_description ?: ($category->description ?: 'Read HVAC Clinic articles and practical guidance in '.$category->name.'.'),
            'canonicalUrl' => $canonicalUrl,
            'isIndexable' => $category->is_indexable ?? true,
            'posts' => $posts,
            'categories' => $categories,
            'services' => Service::published()->ordered()->get(),
        ]);
    }

    /**
     * Display posts for a specific tag.
     */
    public function tag(string $slug): View
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $posts = $tag->publishedPosts()
            ->with(['user', 'categories', 'tags'])
            ->latest('published_at')
            ->paginate(9);

        $tags = Tag::withCount(['posts' => fn ($q) => $q->where('status', 'published')])->get();
        $categories = Category::whereHas('publishedPosts')->withCount(['publishedPosts'])->get();

        $canonicalUrl = $tag->canonical_url ?: route('tag.show', $tag->slug);
        if (! str_ends_with($canonicalUrl, '/')) {
            $canonicalUrl .= '/';
        }

        return view('frontend.blog.archive', [
            'archiveTitle' => $tag->meta_title ?: $tag->name,
            'archiveHeading' => $tag->name,
            'archiveLabel' => 'Article topic',
            'archiveDescription' => $tag->meta_description ?: ($tag->description ?: 'Read HVAC Clinic articles related to '.$tag->name.'.'),
            'canonicalUrl' => $canonicalUrl,
            'isIndexable' => $tag->is_indexable ?? true,
            'posts' => $posts,
            'categories' => $categories,
            'services' => Service::published()->ordered()->get(),
        ]);
    }

    /**
     * Display posts for a specific author or redirect legacy numeric ID.
     */
    public function author(string $slug): View|RedirectResponse
    {
        if (is_numeric($slug)) {
            $user = User::find((int) $slug);
            if ($user && ! empty($user->slug)) {
                return redirect()->route('author.show', $user->slug, 301);
            }

            return redirect()->route('blog.index', [], 301);
        }

        if ($slug === 'hvaclinic') {
            $author = User::query()->firstOrFail();
            $author->setAttribute('name', 'HVAC Clinic Editorial Team');
            $author->setAttribute('slug', 'hvaclinic');
            $posts = Post::published()
                ->with(['user', 'categories', 'tags'])
                ->latest('published_at')
                ->paginate(9);

            $canonicalUrl = route('author.show', 'hvaclinic');
            if (! str_ends_with($canonicalUrl, '/')) {
                $canonicalUrl .= '/';
            }

            return view('frontend.blog.archive', [
                'archiveTitle' => 'HVAC Clinic Editorial Team',
                'archiveHeading' => 'HVAC Clinic Editorial Team',
                'archiveLabel' => 'Articles by',
                'archiveDescription' => 'Practical HVAC and cooling guidance from the HVAC Clinic team.',
                'canonicalUrl' => $canonicalUrl,
                'isIndexable' => true,
                'posts' => $posts,
                'categories' => Category::whereHas('publishedPosts')->withCount(['publishedPosts'])->get(),
                'services' => Service::published()->ordered()->get(),
            ]);
        }

        $author = User::where('slug', $slug)->firstOrFail();

        $posts = $author->posts()
            ->published()
            ->with(['user', 'categories', 'tags'])
            ->latest('published_at')
            ->paginate(9);

        $canonicalUrl = route('author.show', $author->slug);
        if (! str_ends_with($canonicalUrl, '/')) {
            $canonicalUrl .= '/';
        }

        return view('frontend.blog.archive', [
            'archiveTitle' => $author->name,
            'archiveHeading' => $author->name,
            'archiveLabel' => 'Articles by',
            'archiveDescription' => $author->bio ?: 'Articles authored by '.$author->name.' for HVAC Clinic UAE.',
            'canonicalUrl' => $canonicalUrl,
            'isIndexable' => true,
            'posts' => $posts,
        ]);
    }
}
