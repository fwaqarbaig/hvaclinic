<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\RedirectRule;
use App\Models\Service;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SitemapController extends Controller
{
    /**
     * Master XML sitemap index referencing specialized sub-sitemaps.
     */
    public function sitemapIndex(): Response
    {
        $xml = Cache::remember($this->getCacheKey('sitemap_index_xml'), 3600, function (): string {
            $sitemaps = [
                [
                    'loc' => $this->formatSitemapUrl('/post-sitemap.xml'),
                    'lastmod' => Post::published()->latest('updated_at')->first()?->updated_at?->toAtomString() ?? now()->toAtomString(),
                ],
                [
                    'loc' => $this->formatSitemapUrl('/page-sitemap.xml'),
                    'lastmod' => Page::published()->latest('updated_at')->first()?->updated_at?->toAtomString() ?? now()->toAtomString(),
                ],
                [
                    'loc' => $this->formatSitemapUrl('/service-sitemap.xml'),
                    'lastmod' => Service::published()->latest('updated_at')->first()?->updated_at?->toAtomString() ?? now()->toAtomString(),
                ],
                [
                    'loc' => $this->formatSitemapUrl('/category-sitemap.xml'),
                    'lastmod' => Category::latest('updated_at')->first()?->updated_at?->toAtomString() ?? now()->toAtomString(),
                ],
                [
                    'loc' => $this->formatSitemapUrl('/author-sitemap.xml'),
                    'lastmod' => Post::published()->latest('updated_at')->first()?->updated_at?->toAtomString() ?? now()->toAtomString(),
                ],
            ];

            return $this->buildIndexXml($sitemaps);
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }

    /**
     * Dedicated XML sitemap for diesel generator fleet products.
     */
    public function products(): Response
    {
        $xml = Cache::remember($this->getCacheKey('sitemap_products_xml'), 3600, function (): string {
            return $this->buildUrlsetXml($this->getProductsEntries());
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }

    /**
     * Dedicated XML sitemap for blog posts and technical articles.
     */
    public function posts(): Response
    {
        $xml = Cache::remember($this->getCacheKey('sitemap_posts_xml'), 3600, function (): string {
            return $this->buildUrlsetXml($this->getPostsEntries());
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }

    /**
     * Dedicated XML sitemap for static and CMS pages.
     */
    public function pages(): Response
    {
        $xml = Cache::remember($this->getCacheKey('sitemap_pages_xml'), 3600, function (): string {
            return $this->buildUrlsetXml($this->getPagesEntries());
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }

    /**
     * Dedicated XML sitemap for blog categories with active content.
     */
    public function categories(): Response
    {
        $xml = Cache::remember($this->getCacheKey('sitemap_categories_xml'), 3600, function (): string {
            return $this->buildUrlsetXml($this->getCategoriesEntries());
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }

    /**
     * Dedicated XML sitemap for the source website author archive.
     */
    public function authors(): Response
    {
        $xml = Cache::remember($this->getCacheKey('sitemap_authors_xml'), 3600, function (): string {
            return $this->buildUrlsetXml($this->getAuthorsEntries());
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }

    /**
     * Dedicated XML sitemap for commercial generator power services.
     */
    public function services(): Response
    {
        $xml = Cache::remember($this->getCacheKey('sitemap_services_xml'), 3600, function (): string {
            return $this->buildUrlsetXml($this->getServicesEntries());
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }

    /**
     * Dynamic robots.txt response.
     */
    public function robots(): Response
    {
        $sitemapIndexUrl = $this->formatSitemapUrl('/sitemap_index.xml');

        $content = <<<ROBOTS
# robots.txt for HVAC Clinic
# Website: https://hvaclinic.com

User-agent: *
Allow: /
Allow: /images/
Allow: /storage/
Allow: /build/
Allow: /css/
Allow: /js/
Disallow: /admin
Disallow: /admin/
Disallow: /login
Disallow: /login/
Disallow: /register
Disallow: /register/
Disallow: /password/
Disallow: /api/
Disallow: /storage/framework/

# Sitemaps
Sitemap: {$sitemapIndexUrl}
ROBOTS;

        return response(trim($content)."\n", 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }

    /**
     * Compile page entries for sitemaps.
     */
    protected function getPagesEntries(): array
    {
        $activeRedirectSources = RedirectRule::where('is_active', true)
            ->pluck('source_url')
            ->map(fn ($url) => trim($url, '/'))
            ->filter()
            ->all();
        $activeRedirectSet = array_flip($activeRedirectSources);

        $canonicalServiceSlugs = Service::published()
            ->pluck('slug')
            ->map(fn ($slug) => 'services/'.$slug)
            ->all();
        $canonicalServiceSet = array_flip($canonicalServiceSlugs);

        $pages = Page::where('status', 'published')
            ->where('is_indexable', true)
            ->latest('updated_at')
            ->get();

        $entries = [];

        foreach ($pages as $page) {
            $cleanSlug = trim($page->slug, '/');

            // Skip if this Page shadows a canonical top-level Service (emitted in service-sitemap.xml)
            if (isset($canonicalServiceSet[$cleanSlug])) {
                continue;
            }

            // Skip if this Page slug has an active 301 redirect rule (except the home page slug 'home')
            if ($cleanSlug !== 'home' && (isset($activeRedirectSet[$cleanSlug]) || isset($activeRedirectSet['/'.$cleanSlug]))) {
                continue;
            }

            $path = $page->canonical_url ?: ($page->slug === 'home' ? '/' : '/'.$page->slug.'/');
            $cleanPath = trim(parse_url($path, PHP_URL_PATH) ?: $path, '/');

            if ($cleanPath !== '' && (isset($activeRedirectSet[$cleanPath]) || isset($activeRedirectSet['/'.$cleanPath]))) {
                continue;
            }

            $entry = [
                'loc' => $this->formatSitemapUrl($path),
                'lastmod' => $page->updated_at?->toAtomString() ?? now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => $page->slug === 'home' ? '1.0' : '0.7',
            ];

            if ($page->seo_image) {
                $entry['image'] = [
                    'loc' => $page->seo_image,
                    'title' => $page->title,
                ];
            }

            $entries[] = $entry;
        }

        $entries[] = [
            'loc' => $this->formatSitemapUrl('/site-directory/'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'weekly',
            'priority' => '0.8',
        ];

        return $entries;
    }

    /**
     * Compile generator fleet / product entries for sitemaps.
     * All /fleet/{slug} URLs 301 redirect to /used-refurbished-equipment-in-uae/,
     * so product entries are omitted to prevent emitting 301 redirects in XML sitemaps.
     */
    protected function getProductsEntries(): array
    {
        return [];
    }

    /**
     * Compile commercial service entries for sitemaps.
     */
    protected function getServicesEntries(): array
    {
        $services = Service::published()
            ->where('is_indexable', true)
            ->latest('updated_at')
            ->get();

        $entries = [];
        foreach ($services as $service) {
            $serviceUrl = route('service.show', $service->slug);
            if (! str_ends_with($serviceUrl, '/')) {
                $serviceUrl .= '/';
            }

            $entry = [
                'loc' => $this->formatSitemapUrl($serviceUrl),
                'lastmod' => $service->updated_at?->toAtomString() ?? now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ];

            if ($service->image_url) {
                $entry['image'] = [
                    'loc' => $this->formatSitemapUrl($service->image_url),
                    'title' => $service->title.' - HVAC Clinic',
                ];
            }

            $entries[] = $entry;
        }

        return $entries;
    }

    /**
     * Compile published blog posts entries for sitemaps.
     */
    protected function getPostsEntries(): array
    {
        $posts = Post::published()
            ->where('is_indexable', true)
            ->latest('updated_at')
            ->get();

        $entries = [];
        foreach ($posts as $post) {
            $entry = [
                'loc' => $this->formatSitemapUrl($post->canonical_url ?: '/'.$post->slug.'/'),
                'lastmod' => ($post->updated_at ?? $post->published_at ?? now())->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];

            if ($post->featured_image_url) {
                $entry['image'] = [
                    'loc' => $this->formatSitemapUrl($post->featured_image_url),
                    'title' => $post->title,
                ];
            }

            $entries[] = $entry;
        }

        return $entries;
    }

    /**
     * Compile active category entries for sitemaps.
     */
    protected function getCategoriesEntries(): array
    {
        $categories = Category::has('publishedPosts')
            ->with(['publishedPosts' => fn ($q) => $q->latest('updated_at')->take(1)])
            ->get();

        $entries = [];
        foreach ($categories as $category) {
            $latestPost = $category->publishedPosts->first();
            $lastmod = $latestPost?->updated_at?->toAtomString() ?? $category->updated_at?->toAtomString() ?? now()->toAtomString();

            $entries[] = [
                'loc' => $this->formatSitemapUrl('/category/'.$category->slug.'/'),
                'lastmod' => $lastmod,
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        }

        return $entries;
    }

    /**
     * Compile the source website author archive entry.
     *
     * @return array<int, array<string, string>>
     */
    protected function getAuthorsEntries(): array
    {
        if (! Post::published()->exists()) {
            return [];
        }

        return [[
            'loc' => $this->formatSitemapUrl('/author/hvaclinic/'),
            'lastmod' => Post::published()->latest('updated_at')->first()?->updated_at?->toAtomString() ?? now()->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => '0.4',
        ]];
    }

    /**
     * Build valid XML urlset string with optional Google image extensions.
     */
    protected function buildUrlsetXml(array $entries): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">'."\n";

        foreach ($entries as $entry) {
            $loc = $this->formatSitemapUrl($entry['loc']);
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.htmlspecialchars($loc, ENT_XML1, 'UTF-8')."</loc>\n";
            $xml .= "    <lastmod>{$entry['lastmod']}</lastmod>\n";
            $xml .= "    <changefreq>{$entry['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$entry['priority']}</priority>\n";

            if (! empty($entry['image']) && ! empty($entry['image']['loc'])) {
                $imageLoc = $this->formatSitemapUrl($entry['image']['loc']);
                $xml .= "    <image:image>\n";
                $xml .= '      <image:loc>'.htmlspecialchars($imageLoc, ENT_XML1, 'UTF-8')."</image:loc>\n";
                if (! empty($entry['image']['title'])) {
                    $xml .= '      <image:title>'.htmlspecialchars($entry['image']['title'], ENT_XML1, 'UTF-8')."</image:title>\n";
                }
                $xml .= "    </image:image>\n";
            }

            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * Build valid XML sitemapindex string.
     */
    protected function buildIndexXml(array $sitemaps): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($sitemaps as $sitemap) {
            $loc = $this->formatSitemapUrl($sitemap['loc']);
            $xml .= "  <sitemap>\n";
            $xml .= '    <loc>'.htmlspecialchars($loc, ENT_XML1, 'UTF-8')."</loc>\n";
            $xml .= "    <lastmod>{$sitemap['lastmod']}</lastmod>\n";
            $xml .= "  </sitemap>\n";
        }

        $xml .= '</sitemapindex>';

        return $xml;
    }

    /**
     * Resolve the canonical base URL for public sitemaps.
     */
    protected function getBaseUrl(): string
    {
        if (app()->environment('testing')) {
            return rtrim(url('/'), '/');
        }

        $appUrl = config('app.url');
        if (! empty($appUrl) && ! str_contains($appUrl, 'localhost') && ! str_contains($appUrl, '127.0.0.1')) {
            return rtrim($appUrl, '/');
        }

        return 'https://hvaclinic.com';
    }

    /**
     * Format a path or URL into a canonical sitemap URL.
     */
    protected function formatSitemapUrl(string $urlOrPath): string
    {
        $baseUrl = $this->getBaseUrl();

        if (preg_match('#^https?://#i', $urlOrPath)) {
            $parsed = parse_url($urlOrPath);
            $host = strtolower($parsed['host'] ?? '');

            $appHost = strtolower(parse_url(config('app.url') ?? '', PHP_URL_HOST) ?? '');
            $isLocalOrAppHost = in_array($host, ['localhost', '127.0.0.1', 'hvaclinic.com', 'www.hvaclinic.com', $appHost], true)
                || str_ends_with($host, '.test')
                || str_ends_with($host, '.local')
                || empty($host);

            if ($isLocalOrAppHost) {
                $path = $parsed['path'] ?? '';
                $path = preg_replace('#/+#', '/', $path);
                $cleanPath = ltrim($path, '/');
                $fullUrl = $cleanPath === '' ? rtrim($baseUrl, '/') : rtrim($baseUrl, '/').'/'.$cleanPath;

                if (! empty($parsed['query'])) {
                    $fullUrl .= '?'.$parsed['query'];
                }

                return $fullUrl;
            }

            return $urlOrPath;
        }

        $cleanPath = preg_replace('#/+#', '/', $urlOrPath);
        $cleanPath = ltrim($cleanPath, '/');

        return $cleanPath === '' ? rtrim($baseUrl, '/') : rtrim($baseUrl, '/').'/'.$cleanPath;
    }

    /**
     * Generate an environment- and domain-scoped cache key to prevent cross-environment cache leakage.
     */
    protected function getCacheKey(string $key): string
    {
        return $key.'_'.md5($this->getBaseUrl());
    }

    /**
     * Render the comprehensive human- and search-engine-crawlable HTML Site Directory.
     */
    public function siteDirectory(): View
    {
        $corePages = [
            ['title' => 'Home – HVAC & Power Rental Solution', 'url' => route('home'), 'desc' => 'Turnkey HVAC, emergency rental chillers, and temporary power rentals across UAE.'],
            ['title' => 'About HVAC Clinic', 'url' => '/about/', 'desc' => 'Company profile, operational standards, quality commitment, and engineering team.'],
            ['title' => 'Our Engineering Team', 'url' => '/our-team/', 'desc' => 'Senior thermal, HVAC, and generator mechanical engineers with 24/7 dispatch.'],
            ['title' => 'Membership & Accreditations', 'url' => '/membership/', 'desc' => 'Trade associations and global engineering industry memberships.'],
            ['title' => 'Certificates & Quality Standards', 'url' => '/certificates/', 'desc' => 'ISO certified procedures, safety standards, and load bank testing protocols.'],
            ['title' => 'Official Odoo UAE Partner', 'url' => route('odoo.index'), 'desc' => 'Enterprise resource planning, asset maintenance, and ERP solutions for MEP clients.'],
            ['title' => 'All Engineering Services Hub', 'url' => route('service.index'), 'desc' => 'Complete catalog of temporary cooling, chiller hire, and power generation solutions.'],
            ['title' => 'Technical Knowledge Base & Guides', 'url' => route('blog.index'), 'desc' => '270+ technical guides, chiller sizing tutorials, and case studies.'],
            ['title' => 'Contact & Rapid 24/7 Dispatch', 'url' => route('contact'), 'desc' => 'Itemized engineering quotes and rapid 60–120 minute emergency response across UAE.'],
        ];

        $services = Service::published()->ordered()->get();

        $categories = Category::whereHas('publishedPosts')
            ->where('slug', '!=', 'blog')
            ->withCount(['publishedPosts'])
            ->orderBy('name')
            ->get();

        $posts = Post::published()
            ->with(['categories'])
            ->latest('published_at')
            ->get(['id', 'title', 'slug', 'published_at']);

        $nestedServicePages = Page::published()
            ->where('slug', 'like', 'services/%/%')
            ->where('slug', 'not like', 'services/%/%/%') // direct sub-pages
            ->orderBy('title')
            ->get(['id', 'title', 'slug', 'updated_at']);

        $nestedPagesByService = $nestedServicePages->groupBy(function ($page) {
            $parts = explode('/', $page->slug);

            return $parts[1] ?? 'other';
        });

        return view('frontend.sitemap.directory', compact('corePages', 'services', 'categories', 'posts', 'nestedPagesByService'));
    }
}
