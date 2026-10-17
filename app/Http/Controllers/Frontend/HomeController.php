<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     */
    public function index(): View
    {
        $page = Page::where('slug', 'home')->first();

        $recentPosts = Post::published()
            ->with('categories')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.home', compact('page', 'recentPosts'));
    }

    /**
     * About page for legacy route references.
     */
    public function about(): View
    {
        $page = Page::where('slug', 'about')->first();

        return view('frontend.pages.show', compact('page'));
    }
}
