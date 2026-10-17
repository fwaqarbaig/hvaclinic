<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the Industries We Serve page.
     */
    public function industries(): View
    {
        $jsonPath = storage_path('industries.json');
        $industries = file_exists($jsonPath) ? json_decode(file_get_contents($jsonPath), true) : [];

        $page = Page::where('slug', 'industries')->first();

        return view('frontend.pages.industries', compact('industries', 'page'));
    }

    /**
     * Display the Used & Refurbished Generators and Portacabins page.
     */
    public function usedGenerators(): View
    {
        $jsonPath = storage_path('used_generators.json');
        $items = file_exists($jsonPath) ? json_decode(file_get_contents($jsonPath), true) : [];

        $page = Page::where('slug', 'used-refurbished-generators')->first();

        return view('frontend.pages.used-generators', compact('items', 'page'));
    }

    /**
     * Display the Regional Locations overview page.
     */
    public function locations(): View
    {
        $jsonPath = storage_path('locations.json');
        $locations = file_exists($jsonPath) ? json_decode(file_get_contents($jsonPath), true) : [];

        $page = Page::where('slug', 'locations')->first();

        return view('frontend.pages.locations', compact('locations', 'page'));
    }

    /**
     * Display a specific regional location hub detail page.
     */
    public function locationDetail(string $city): View
    {
        $jsonPath = storage_path('all_cities_data.json');
        $allCities = file_exists($jsonPath) ? json_decode(file_get_contents($jsonPath), true) : [];

        $cityKey = strtolower($city);
        if (! isset($allCities[$cityKey])) {
            abort(404);
        }

        $cityData = $allCities[$cityKey];
        $page = Page::where('slug', 'locations/'.$cityKey)->first();

        return view('frontend.pages.location-detail', compact('cityData', 'allCities', 'cityKey', 'page'));
    }

    /**
     * Display a static CMS page.
     */
    public function show(string $slug): View|RedirectResponse
    {
        // 301 Redirect common alias permalinks to their canonical routes
        $canonicalRedirects = [
            'home' => route('home'),
            'about' => route('about'),
            'about-us' => route('about'),
            'fleet' => route('fleet.index'),
            'products' => route('fleet.index'),
            'services' => route('service.index'),
            'contact' => route('contact'),
            'contact-us' => route('contact'),
            'industries' => route('page.industries'),
            'used-refurbished-generators' => route('page.used-generators'),
            'locations' => route('locations.index'),
        ];

        if (isset($canonicalRedirects[$slug])) {
            return redirect($canonicalRedirects[$slug], 301);
        }

        // If a published service exists with this slug, redirect to official service route to prevent cannibalization
        if ($service = Service::published()->where('slug', $slug)->first()) {
            return redirect()->route('service.show', $service->slug, 301);
        }

        // Handle location sub-paths if called via slug like locations/dubai
        if (str_starts_with($slug, 'locations/')) {
            $city = str_replace('locations/', '', $slug);

            return redirect()->route('locations.show', ['city' => $city], 301);
        }

        $pageQuery = Page::with('user')->where('slug', $slug);

        if (! auth()->check() || ! auth()->user()->canManageContent()) {
            $pageQuery->where('status', 'published');
        }

        $page = $pageQuery->firstOrFail();

        $viewName = match ($page->template) {
            'full-width' => 'frontend.pages.full-width',
            'contact' => 'frontend.pages.contact',
            default => 'frontend.pages.show',
        };

        return view($viewName, compact('page'));
    }
}
