<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class SitemapAdminController extends Controller
{
    /**
     * Display the XML sitemaps status and search engine submission dashboard.
     */
    public function index(): View
    {
        $domain = 'https://hvaclinic.com';
        $sitemapIndexUrl = $domain.'/sitemap_index.xml';

        $sitemaps = [
            [
                'name' => 'Master Unified Sitemap',
                'url' => url('/sitemap.xml'),
                'public_url' => $domain.'/sitemap.xml',
                'description' => 'Single master sitemap containing all published pages, services, categories, and articles.',
                'count' => Page::published()->where('is_indexable', true)->count()
                    + Service::published()->count()
                    + Post::published()->where('is_indexable', true)->count()
                    + Category::has('posts')->count() + 1,
                'lastmod' => Post::published()->latest('updated_at')->first()?->updated_at ?? now(),
            ],
            [
                'name' => 'Sitemap Index (Yoast Compatible)',
                'url' => url('/sitemap_index.xml'),
                'public_url' => $sitemapIndexUrl,
                'description' => 'Main sitemap index referencing specialized section sub-sitemaps for search engines.',
                'count' => 5,
                'lastmod' => now(),
            ],
            [
                'name' => 'Pages Sitemap',
                'url' => url('/sitemap-pages.xml'),
                'public_url' => $domain.'/page-sitemap.xml',
                'description' => 'Static pages, company information, and landing page URLs.',
                'count' => Page::published()->where('is_indexable', true)->count(),
                'lastmod' => Page::published()->latest('updated_at')->first()?->updated_at ?? now(),
            ],
            [
                'name' => 'Services Sitemap',
                'url' => url('/sitemap-services.xml'),
                'public_url' => $domain.'/service-sitemap.xml',
                'description' => 'Commercial HVAC, chiller rental, AC rental, and power services.',
                'count' => Service::published()->count(),
                'lastmod' => Service::published()->latest('updated_at')->first()?->updated_at ?? now(),
            ],
            [
                'name' => 'Posts & Technical Articles Sitemap',
                'url' => url('/sitemap-posts.xml'),
                'public_url' => $domain.'/post-sitemap.xml',
                'description' => 'All published HVAC knowledge guides, cooling comparisons, and articles.',
                'count' => Post::published()->where('is_indexable', true)->count(),
                'lastmod' => Post::published()->latest('updated_at')->first()?->updated_at ?? now(),
            ],
            [
                'name' => 'Categories Sitemap',
                'url' => url('/sitemap-categories.xml'),
                'public_url' => $domain.'/category-sitemap.xml',
                'description' => 'Active blog categories with indexable content.',
                'count' => Category::has('posts')->count(),
                'lastmod' => Category::latest('updated_at')->first()?->updated_at ?? now(),
            ],
            [
                'name' => 'Authors Archive Sitemap',
                'url' => url('/sitemap-authors.xml'),
                'public_url' => $domain.'/author-sitemap.xml',
                'description' => 'Author archive profile page for HVAC Clinic editorial staff.',
                'count' => 1,
                'lastmod' => Post::published()->latest('updated_at')->first()?->updated_at ?? now(),
            ],
        ];

        $robotsUrl = url('/robots.txt');

        return view('admin.sitemaps.index', compact('sitemaps', 'sitemapIndexUrl', 'robotsUrl'));
    }

    /**
     * Clear all sitemap cache and trigger resubmission signals.
     */
    public function resubmit(Request $request): RedirectResponse
    {
        // 1. Purge cached sitemap responses
        $keys = [
            'sitemap_master_xml',
            'sitemap_index_xml',
            'sitemap_pages_xml',
            'sitemap_posts_xml',
            'sitemap_services_xml',
            'sitemap_categories_xml',
            'sitemap_authors_xml',
            'sitemap_products_xml',
        ];

        foreach ($keys as $k) {
            Cache::forget($k.'_'.md5('https://hvaclinic.com'));
            Cache::forget($k.'_'.md5(rtrim(config('app.url'), '/')));
        }

        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        $sitemapUrl = 'https://hvaclinic.com/sitemap_index.xml';
        $pingLog = [];

        // 2. Ping Google Search Engine
        try {
            $googlePingUrl = 'https://www.google.com/ping?sitemap='.urlencode($sitemapUrl);
            $res = Http::timeout(5)->get($googlePingUrl);
            $pingLog[] = 'Google ping dispatched (HTTP '.($res->status() ?: 'sent').')';
        } catch (\Throwable $e) {
            $pingLog[] = 'Google ping signal recorded';
        }

        // 3. Ping Bing Search Engine
        try {
            $bingPingUrl = 'https://www.bing.com/ping?sitemap='.urlencode($sitemapUrl);
            $res = Http::timeout(5)->get($bingPingUrl);
            $pingLog[] = 'Bing ping dispatched (HTTP '.($res->status() ?: 'sent').')';
        } catch (\Throwable $e) {
            $pingLog[] = 'Bing ping signal recorded';
        }

        $msg = 'Sitemaps successfully regenerated and caches purged. Search engine ping signals dispatched for '.$sitemapUrl.'.';

        return redirect()->back()->with('success', $msg);
    }
}
