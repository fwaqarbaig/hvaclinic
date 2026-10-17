<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View as ViewContract;

class ContentController extends Controller
{
    /**
     * Resolve an imported WordPress permalink to its page or article.
     */
    public function show(string $path): ViewContract|RedirectResponse
    {
        $path = trim($path, '/');

        $aliases = [
            'home' => '/',
            'about-us' => '/about/',
            'contact-us' => '/contact/',
            'used-generators' => '/used-refurbished-equipment-in-uae/',
            'used-refurbished-generators' => '/used-refurbished-equipment-in-uae/',
            'fleet' => '/used-refurbished-equipment-in-uae/',
            'products' => '/used-refurbished-equipment-in-uae/',
        ];

        if (isset($aliases[$path])) {
            return redirect($aliases[$path], 301);
        }

        if ($path === 'services') {
            return app(ServiceController::class)->index(request());
        }

        if ($path === 'used-refurbished-equipment-in-uae') {
            return app(ServiceController::class)->show('used-refurbished-equipment-in-uae');
        }

        $service = Service::published()->where('slug', $path)->first();
        if ($service) {
            return app(ServiceController::class)->show($service->slug);
        }

        $page = Page::query()->where('slug', $path)->first();

        if ($page && $this->canViewPage($page)) {
            $normalizedView = str_replace('/', '.', $path);
            if (view()->exists("frontend.pages.{$normalizedView}")) {
                return view("frontend.pages.{$normalizedView}", compact('page'));
            }

            return view('frontend.pages.show', $this->preparePageData($page));
        }

        $postQuery = Post::query()
            ->with(['user', 'categories', 'tags'])
            ->where('slug', $path);

        if (! $this->canManageContent()) {
            $postQuery->published();
        }

        $post = $postQuery->first();

        if ($post) {
            return app(BlogController::class)->show($post->slug);
        }

        abort(404);
    }

    /**
     * Resolve a source service path while keeping its full nested permalink.
     */
    public function showService(string $path): ViewContract|RedirectResponse
    {
        $cleanPath = trim($path, '/');

        // 1. Direct exact slug match for published services
        $service = Service::published()->where('slug', $cleanPath)->first();
        if ($service) {
            return app(ServiceController::class)->show($service->slug);
        }

        // 2. Backward compatibility & short aliases
        $serviceAliases = [
            'rental-chiller' => 'rental-chiller-in-uae',
            'rental-power' => 'generator-maintenance-repair-in-uae',
            'rental-generator' => 'generator-rental-in-uae',
            'temporary-cooling' => 'rental-cooling',
            'used-refurbished-equipment' => 'used-refurbished-equipment-in-uae',
            'used-refurbished' => 'used-refurbished-equipment-in-uae',
        ];

        $targetSlug = $serviceAliases[$cleanPath] ?? null;
        if ($targetSlug) {
            $aliasedService = Service::published()->where('slug', $targetSlug)->first();
            if ($aliasedService) {
                return app(ServiceController::class)->show($aliasedService->slug);
            }
        }

        $fullPath = 'services/'.$cleanPath;

        $page = Page::query()
            ->where('slug', $fullPath)
            ->orWhere('slug', $cleanPath)
            ->first();

        if ($page && $this->canViewPage($page)) {
            return view('frontend.pages.show', $this->preparePageData($page));
        }

        abort(404);
    }

    /**
     * Prepare context-rich view data for a page, including parent services and sibling sub-pages.
     */
    private function preparePageData(Page $page): array
    {
        $isServicePage = str_starts_with($page->slug, 'services/');
        $parentService = null;
        $siblingPages = collect();
        $parentSlug = null;

        if ($isServicePage) {
            $parts = explode('/', $page->slug);
            $parentSlug = $parts[1] ?? null;
            if ($parentSlug) {
                $parentService = Service::where('slug', $parentSlug)->first();
                $siblingPages = Page::published()
                    ->where('slug', 'like', "services/{$parentSlug}/%")
                    ->where('id', '!=', $page->id)
                    ->orderBy('title')
                    ->get();
            }
        }

        $allServices = Service::published()->ordered()->get();

        return compact('page', 'isServicePage', 'parentService', 'siblingPages', 'parentSlug', 'allServices');
    }

    private function canViewPage(Page $page): bool
    {
        return $page->status === 'published' || $this->canManageContent();
    }

    private function canManageContent(): bool
    {
        return auth()->check() && auth()->user()->canManageContent();
    }
}
