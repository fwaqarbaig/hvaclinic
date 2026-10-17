<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\RedirectRule;
use App\Models\Service;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use JsonException;

class ImportHvacClinicContent extends Command
{
    protected $signature = 'hvac:import-content {--skip-media : Keep WordPress image URLs remote instead of copying them into public/wp-content/uploads}';

    protected $description = 'Import HVAC Clinic pages, articles, services, SEO fields, schema markup, and media from WordPress export';

    /**
     * Execute the content import.
     *
     * @throws JsonException
     */
    public function handle(): int
    {
        $sourcePath = database_path('data/hvaclinic-content.json');

        if (! is_file($sourcePath)) {
            $this->error('The saved HVAC Clinic content export is missing.');

            return self::FAILURE;
        }

        $data = json_decode(file_get_contents($sourcePath), true, flags: JSON_THROW_ON_ERROR);

        // Ensure primary HVAC Clinic author user exists
        $author = User::query()->firstOrCreate(
            ['email' => 'info@hvaclinic.com'],
            [
                'name' => 'HVAC Clinic',
                'role' => 'admin',
                'slug' => 'hvaclinic',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );

        if (! $this->option('skip-media')) {
            $this->copySourceMedia($data['records']);
        }

        $counts = DB::transaction(function () use ($data, $author): array {
            Page::query()->update(['status' => 'draft']);
            Post::query()->update(['status' => 'draft']);
            Service::query()->update(['status' => 'draft']);
            Product::query()->update(['status' => 'draft']);

            $categoryIds = $this->importCategories($data['categories'] ?? []);
            $tagIds = $this->importTags($data['tags'] ?? []);
            $pageCount = 0;
            $postCount = 0;

            foreach ($data['records'] as $record) {
                if ($record['type'] === 'pages') {
                    $this->importPage($record, $author->id);
                    $pageCount++;

                    continue;
                }

                if ($record['type'] === 'posts') {
                    $post = $this->importPost($record, $author->id);
                    $post->categories()->sync(array_values(array_filter(array_map(
                        fn (int $sourceId): ?int => $categoryIds[$sourceId] ?? null,
                        $record['categories'] ?? [],
                    ))));
                    $post->tags()->sync(array_values(array_filter(array_map(
                        fn (int $sourceId): ?int => $tagIds[$sourceId] ?? null,
                        $record['tags'] ?? [],
                    ))));
                    $postCount++;
                }
            }

            // Seed core HVAC Clinic commercial services
            $serviceCount = $this->importServices();

            // Populate high performance header navigation
            $this->updateHeaderMenu();

            // Seed default 301 redirection rules for legacy paths and clean indexing
            $this->seedRedirectRules();

            return ['pages' => $pageCount, 'posts' => $postCount, 'services' => $serviceCount];
        });

        // Flush all application and sitemap caches
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');

        $this->info("Successfully imported {$counts['pages']} pages, {$counts['posts']} articles, and {$counts['services']} core services with full SEO & Schema markup.");

        return self::SUCCESS;
    }

    /**
     * @param  array<int, array<string, mixed>>  $records
     */
    private function copySourceMedia(array $records): void
    {
        $urls = [];

        foreach ($records as $record) {
            $content = (string) ($record['content'] ?? '');
            preg_match_all('/https?:\/\/(?:www\.)?hvaclinic\.com\/wp-content\/uploads\/[^"\'\s<>\)]+/i', $content, $matches);

            foreach ($matches[0] as $url) {
                $url = rtrim($url, '.,;');
                $urls[$url] = true;
            }

            if (! empty($record['featured_image']) && str_contains($record['featured_image'], '/wp-content/uploads/')) {
                $urls[$record['featured_image']] = true;
            }
        }

        $urls['https://hvaclinic.com/wp-content/uploads/2026/03/hvac.gif'] = true;
        $urls['https://hvaclinic.com/wp-content/uploads/2026/03/1.jpg'] = true;

        $targetPrefix = public_path('wp-content/uploads/');
        $pending = [];

        foreach (array_keys($urls) as $url) {
            $path = parse_url($url, PHP_URL_PATH);
            $prefix = '/wp-content/uploads/';

            if (! is_string($path) || ! str_starts_with($path, $prefix)) {
                continue;
            }

            $relativePath = substr($path, strlen($prefix));
            $targetPath = $targetPrefix.$relativePath;

            if (! is_file($targetPath)) {
                $pending[] = ['url' => $url, 'dest' => $targetPath];
            }
        }

        if (empty($pending)) {
            $this->info('All '.count($urls).' media assets are already stored locally.');

            return;
        }

        $this->info('Downloading '.count($pending).' media files concurrently...');
        $chunks = array_chunk($pending, 20);

        foreach ($chunks as $chunk) {
            $mh = curl_multi_init();
            $handles = [];

            foreach ($chunk as $item) {
                $dir = dirname($item['dest']);
                if (! is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                $fp = fopen($item['dest'].'.tmp', 'w');
                if (! $fp) {
                    continue;
                }

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $item['url']);
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
                curl_multi_add_handle($mh, $ch);

                $handles[(int) $ch] = ['ch' => $ch, 'dest' => $item['dest'], 'fp' => $fp];
            }

            $running = null;
            do {
                curl_multi_exec($mh, $running);
                curl_multi_select($mh, 0.5);
            } while ($running > 0);

            foreach ($handles as $h) {
                $ch = $h['ch'];
                $dest = $h['dest'];
                $fp = $h['fp'];
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_multi_remove_handle($mh, $ch);
                curl_close($ch);
                fclose($fp);

                if ($httpCode >= 200 && $httpCode < 400 && filesize($dest.'.tmp') > 0) {
                    rename($dest.'.tmp', $dest);
                } else {
                    @unlink($dest.'.tmp');
                }
            }

            curl_multi_close($mh);
        }
    }

    /**
     * @param  array<int, array<string, mixed>>  $sourceCategories
     * @return array<int, int>
     */
    private function importCategories(array $sourceCategories): array
    {
        $categoryIds = [];

        foreach ($sourceCategories as $sourceCategory) {
            $category = Category::query()->updateOrCreate(
                ['slug' => $sourceCategory['slug']],
                [
                    'name' => $this->decodeText($sourceCategory['name']),
                    'description' => $sourceCategory['description'] ?? null,
                ],
            );
            $categoryIds[(int) $sourceCategory['id']] = $category->id;
        }

        return $categoryIds;
    }

    /**
     * @param  array<int, array<string, mixed>>  $sourceTags
     * @return array<int, int>
     */
    private function importTags(array $sourceTags): array
    {
        $tagIds = [];

        foreach ($sourceTags as $sourceTag) {
            $tag = Tag::query()->updateOrCreate(
                ['slug' => $sourceTag['slug']],
                ['name' => $this->decodeText($sourceTag['name'])],
            );
            $tagIds[(int) $sourceTag['id']] = $tag->id;
        }

        return $tagIds;
    }

    /**
     * @param  array<string, mixed>  $record
     */
    private function importPage(array $record, int $userId): void
    {
        $sourcePath = trim((string) parse_url($record['link'], PHP_URL_PATH), '/');
        $slug = $sourcePath === '' ? 'home' : $sourcePath;
        $seo = $record['seo'] ?? [];

        $schemaMarkup = ! empty($seo['schema'])
            ? json_encode($seo['schema'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
            : null;

        $focusKeyword = $this->deriveFocusKeyword($record['title'], $slug);

        $page = Page::query()->updateOrCreate(
            ['slug' => $slug],
            [
                'user_id' => $userId,
                'title' => $this->decodeText($record['title']),
                'content' => $this->localizeMediaUrls($record['content']),
                'featured_image' => $record['featured_image'] ?: null,
                'template' => $slug === 'contact' ? 'contact' : 'default',
                'status' => 'published',
                'focus_keyword' => $focusKeyword,
                'seo_score' => 88,
                'readability_score' => 85,
                'schema_markup' => $schemaMarkup,
                ...$this->seoFields($seo, $record),
            ],
        );

        $page->forceFill([
            'created_at' => Carbon::parse($record['published_at']),
            'updated_at' => Carbon::parse($record['modified_at']),
        ])->saveQuietly();
    }

    /**
     * @param  array<string, mixed>  $record
     */
    private function importPost(array $record, int $userId): Post
    {
        $slug = $record['slug'] ?? $record['path'] ?? trim((string) parse_url($record['link'], PHP_URL_PATH), '/');
        $seo = $record['seo'] ?? [];

        $schemaMarkup = ! empty($seo['schema'])
            ? json_encode($seo['schema'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
            : null;

        $focusKeyword = $this->deriveFocusKeyword($record['title'], $slug);

        $post = Post::query()->updateOrCreate(
            ['slug' => $slug],
            [
                'user_id' => $userId,
                'title' => $this->decodeText($record['title']),
                'excerpt' => trim(strip_tags($record['excerpt'] ?? '')),
                'content' => $this->localizeMediaUrls($record['content']),
                'featured_image' => $record['featured_image'] ?: null,
                'status' => 'published',
                'published_at' => Carbon::parse($record['published_at']),
                'focus_keyword' => $focusKeyword,
                'seo_score' => 90,
                'readability_score' => 85,
                'schema_markup' => $schemaMarkup,
                ...$this->seoFields($seo, $record),
            ],
        );

        $post->forceFill([
            'created_at' => Carbon::parse($record['published_at']),
            'updated_at' => Carbon::parse($record['modified_at']),
        ])->saveQuietly();

        return $post;
    }

    /**
     * Import core HVAC Clinic commercial services for the Services Studio and Frontend.
     */
    private function importServices(): int
    {
        $services = [
            [
                'title' => 'Rental Chiller in UAE',
                'slug' => 'rental-chiller-in-uae',
                'hero_badge' => '24/7 Rapid Mobilization',
                'tagline' => 'High-capacity industrial and commercial rental chillers across Dubai, Abu Dhabi, and UAE.',
                'icon' => 'snowflake',
                'summary' => 'Flexible chiller rental capacity for emergency cooling, seasonal peak demands, and scheduled plant maintenance with complete turnkey installation.',
                'featured_image' => '/wp-content/uploads/2026/03/1.jpg',
                'order' => 1,
                'focus_keyword' => 'rental chiller in uae',
                'meta_title' => 'Rental Chiller in UAE | Industrial & Commercial Cooling',
                'meta_description' => 'Fast delivery rental chillers across Dubai, Abu Dhabi, and Sharjah. Turnkey cooling solutions with 24/7 technical support and rapid response.',
                'features' => [
                    'Air-Cooled & Water-Cooled Chillers (50 TR to 1500 TR)',
                    'Rapid Deployment within 2 Hours across UAE',
                    'Turnkey Pumps, Flexible Hoses & Cable Packages',
                    '24/7 Continuous Maintenance & Monitoring Support',
                ],
                'benefits' => [
                    'Zero capital expenditure with flexible monthly & seasonal rental contracts',
                    'High ambient operating performance rated up to 52°C GCC temperatures',
                    'Full integration with building management systems (BMS)',
                ],
            ],
            [
                'title' => 'Rental AC in UAE',
                'slug' => 'rental-ac-in-uae',
                'hero_badge' => 'Events & Commercial Spaces',
                'tagline' => 'Floor-standing, portable, and outdoor air conditioning rental for events, offices, and projects.',
                'icon' => 'wind',
                'summary' => 'On-demand spot cooling, portable AC units, and high-tonnage package units for luxury events, temporary offices, tents, and warehouse facilities.',
                'featured_image' => '/wp-content/uploads/2026/07/24-1.jpg',
                'order' => 2,
                'focus_keyword' => 'rental ac in uae',
                'meta_title' => 'Rental AC in UAE | Portable & Floor Standing AC Hire',
                'meta_description' => 'Reliable rental AC solutions across UAE. Floor standing, portable, and tent air conditioning units for commercial facilities and events.',
                'features' => [
                    'Floor-Standing AC Units (5 TR to 20 TR)',
                    'Portable Spot Coolers for server rooms & spot areas',
                    'Whisper-Quiet Operation for luxury events & VIP venues',
                    'Clean ducting and aesthetic air distribution kits',
                ],
                'benefits' => [
                    'Instant relief during AC breakdown emergencies',
                    'Fast setup with certified HVAC technicians',
                    'Energy-efficient inverter compressors',
                ],
            ],
            [
                'title' => 'Temporary Cooling in UAE',
                'slug' => 'temporary-cooling-in-uae',
                'hero_badge' => 'Turnkey Cooling Packages',
                'tagline' => 'Engineered cooling solutions for construction sites, warehouses, events, and shutdowns.',
                'icon' => 'thermometer-sun',
                'summary' => 'Comprehensive temporary climate control systems designed for demanding industrial operations, concrete curing, warehouse storage, and high-heat sites.',
                'featured_image' => '/wp-content/uploads/2026/07/1.jpg',
                'order' => 3,
                'focus_keyword' => 'temporary cooling in uae',
                'meta_title' => 'Temporary Cooling Solutions UAE | Warehouse & Site Cooling',
                'meta_description' => 'Engineered temporary cooling systems across the UAE for construction projects, industrial plants, events, and temperature-controlled storage.',
                'features' => [
                    'Industrial Air Handling Units (AHUs)',
                    'Fabric Air Ducting & High-Velocity Air Movers',
                    'Precise Humidity & Temperature Regulation',
                    'Complete Electrical Distribution & Genset Backup',
                ],
                'benefits' => [
                    'Prevents costly worker heat stress and site shutdowns',
                    'Maintains optimal concrete curing and curing temperatures',
                    'Modular scalability up to thousands of tons',
                ],
            ],
            [
                'title' => 'Chiller Maintenance in UAE',
                'slug' => 'chiller-maintenance-in-uae',
                'hero_badge' => 'Certified Chiller Engineers',
                'tagline' => 'Preventive maintenance, overhaul, and annual contracts (AMC) for commercial chillers.',
                'icon' => 'settings-2',
                'summary' => 'End-to-end chiller servicing, refrigerant leak detection, compressor overhaul, tube cleaning, and annual maintenance agreements for optimum COP efficiency.',
                'featured_image' => '/wp-content/uploads/2026/07/7.jpg',
                'order' => 4,
                'focus_keyword' => 'chiller maintenance in uae',
                'meta_title' => 'Chiller Maintenance & Repair UAE | AMC & Overhauls',
                'meta_description' => 'Expert commercial chiller maintenance, emergency repairs, and AMC contracts across Dubai, Abu Dhabi, and UAE. Certified HVAC technicians.',
                'features' => [
                    'Centrifugal, Screw & Scroll Chiller Specialists',
                    'Comprehensive Condenser & Evaporator Tube Descaling',
                    'Oil Analysis, Vibration Testing & Megger Testing',
                    'Emergency 24/7 Breakdown Response SLA',
                ],
                'benefits' => [
                    'Significantly reduces electricity consumption & operating costs',
                    'Extends equipment lifespan and prevents catastrophic compressor failure',
                    'Full compliance with UAE environmental and municipality standards',
                ],
            ],
            [
                'title' => 'Generator Rental in UAE',
                'slug' => 'generator-rental-in-uae',
                'hero_badge' => '20 kVA to 2000 kVA Fleet',
                'tagline' => 'Dependable diesel generators for rent with turnkey fuel management and distribution.',
                'icon' => 'zap',
                'summary' => 'Soundproof diesel generator hire for construction, industrial facilities, emergency power outages, and temporary site operations with 24/7 fuel management.',
                'featured_image' => '/wp-content/uploads/2026/07/15.jpg',
                'order' => 5,
                'focus_keyword' => 'generator rental in uae',
                'meta_title' => 'Generator Rental in UAE | 24/7 Turnkey Power Hire',
                'meta_description' => 'Commercial diesel generator rental across Dubai, Abu Dhabi, and UAE. Soundproof gensets with automated transfer switches, cables, and fuel supply.',
                'features' => [
                    'Silent Canopy Generators (Perkins, Cummins, Caterpillar)',
                    'Synchronized Multi-Megawatt Power Capabilities',
                    'Automatic Transfer Switches (ATS) & Distribution Boards',
                    'Bulk Fuel Storage Tanks & Continuous Delivery',
                ],
                'benefits' => [
                    'Guaranteed zero-downtime continuous power support',
                    'Rapid dispatch from depots in Dubai, Abu Dhabi & Sharjah',
                    'Competitive daily, weekly, and monthly rates',
                ],
            ],
            [
                'title' => 'AC Maintenance & Repair UAE',
                'slug' => 'ac-maintenance-repair-uae',
                'hero_badge' => 'Residential & Commercial HVAC',
                'tagline' => 'Professional AC repairs, duct cleaning, and preventive maintenance agreements.',
                'icon' => 'wrench',
                'summary' => 'Fast, certified AC repair and diagnostic services for VRF, package, split, and ducted air conditioning systems across commercial and residential buildings.',
                'featured_image' => '/wp-content/uploads/2026/07/21-1.jpg',
                'order' => 6,
                'focus_keyword' => 'ac maintenance repair uae',
                'meta_title' => 'AC Maintenance & Repair UAE | Fast AC AMC Services',
                'meta_description' => 'Expert AC repair and maintenance contracts across UAE. Fast diagnosis, refrigerant refill, coil cleaning, and compressor repair services.',
                'features' => [
                    'Deep Chemical Coil Washing & Sanitization',
                    'Compressor Diagnostics & Capacitor Replacement',
                    'Thermostat & Control Board Troubleshooting',
                    'Indoor Air Quality & Duct Sanitization',
                ],
                'benefits' => [
                    'Restores maximum cooling capacity in peak summer',
                    'Eliminates odors, allergens, and airborne bacteria',
                    'Guaranteed genuine OEM replacement parts',
                ],
            ],
            [
                'title' => 'Generator Maintenance & Repair in UAE',
                'slug' => 'generator-maintenance-repair-in-uae',
                'hero_badge' => '24/7 Mechanical & Electrical Team',
                'tagline' => 'Diesel generator troubleshooting, overhaul, load bank testing, and maintenance.',
                'icon' => 'cpu',
                'summary' => 'Comprehensive maintenance and mechanical repair for diesel engine generators, control panel troubleshooting, alternator rewinding, and resistive load bank verification.',
                'featured_image' => '/wp-content/uploads/2026/07/21.jpg',
                'order' => 7,
                'focus_keyword' => 'generator repair in uae',
                'meta_title' => 'Generator Maintenance & Repair UAE | 24/7 Emergency Service',
                'meta_description' => 'Fast diesel generator repairs, preventive maintenance contracts, load bank testing, and rebuilds across the UAE. 24/7 technical team.',
                'features' => [
                    'Complete Top & Major Engine Overhauls',
                    'Resistive Load Bank Testing up to 2000 kW',
                    'Fuel Injection Pump & Turbocharger Service',
                    'Control System & Synchronization Upgrades',
                ],
                'benefits' => [
                    'Prevents wet stacking and ensures instant standby start',
                    'Extends generator operational lifespan',
                    'ISO certified inspection and health report provided',
                ],
            ],
            [
                'title' => 'Wild Air Rental in UAE',
                'slug' => 'wild-air-rental-in-uae',
                'hero_badge' => 'High-Capacity Ventilation',
                'tagline' => 'Temporary ventilation, exhaust, and high-volume fresh air systems for large projects.',
                'icon' => 'fan',
                'summary' => 'High-volume fresh air induction, site ventilation, and temporary exhaust ducting to meet safety and airflow requirements in tunnels, basements, and enclosed sites.',
                'featured_image' => '/wp-content/uploads/2026/07/3-1.jpg',
                'order' => 8,
                'focus_keyword' => 'wild air rental in uae',
                'meta_title' => 'Wild Air Rental in UAE | Construction & Tunnel Ventilation',
                'meta_description' => 'High-volume wild air systems and site ventilation hire across UAE for construction, underground basements, and industrial airflow control.',
                'features' => [
                    'Heavy-Duty Axial & Centrifugal Blowers',
                    'Flexible Spiral Flame-Retardant Ducting',
                    'Continuous Air Circulation & Toxic Gas Purging',
                    'Outdoor Weatherproof Motor Housings',
                ],
                'benefits' => [
                    'Ensures workplace safety compliance for enclosed workers',
                    'Prevents stagnant heat and humidity accumulation',
                    'Easy setup with plug-and-play power connections',
                ],
            ],
            [
                'title' => 'Used & Refurbished Equipment in UAE',
                'slug' => 'used-refurbished-equipment-in-uae',
                'hero_badge' => 'Inspected & Certified',
                'tagline' => 'Certified used and refurbished chillers, air conditioners, and power generators.',
                'icon' => 'recycle',
                'summary' => 'Quality pre-owned HVAC and power equipment, fully tested, load-tested, refurbished with genuine components, and backed by comprehensive warranty.',
                'featured_image' => '/wp-content/uploads/2026/07/1-1.jpg',
                'order' => 9,
                'focus_keyword' => 'used equipment in uae',
                'meta_title' => 'Used & Refurbished Equipment in UAE | Chillers & Generators',
                'meta_description' => 'Buy and sell inspected used chillers, AC systems, and diesel generators in UAE. Thoroughly tested, certified, and warranty-backed equipment.',
                'features' => [
                    '100% Load-Bank Tested & Performance Certified',
                    'Fully Descaled, Serviced & Painted Units',
                    'Complete Operating History & Logbooks',
                    'Optional Extended Warranty & Service Contracts',
                ],
                'benefits' => [
                    'Save 40% to 65% compared to new equipment purchase',
                    'Immediate availability with zero factory manufacturing lead time',
                    'Buy-back guarantee options available',
                ],
            ],
        ];

        foreach ($services as $svc) {
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                '@id' => 'https://hvaclinic.com/services/'.$svc['slug'].'/#service',
                'name' => $svc['title'],
                'serviceType' => 'HVAC & Power Rental Service',
                'provider' => [
                    '@type' => 'HVACBusiness',
                    'name' => 'HVAC Clinic',
                    'url' => 'https://hvaclinic.com/',
                ],
                'areaServed' => [
                    '@type' => 'Country',
                    'name' => 'United Arab Emirates',
                ],
                'description' => $svc['summary'],
            ];

            Service::query()->updateOrCreate(
                ['slug' => $svc['slug']],
                [
                    'title' => $svc['title'],
                    'hero_badge' => $svc['hero_badge'],
                    'tagline' => $svc['tagline'],
                    'icon' => $svc['icon'],
                    'summary' => $svc['summary'],
                    'content' => '<p>'.$svc['summary'].'</p>',
                    'features' => $svc['features'],
                    'benefits' => $svc['benefits'],
                    'featured_image' => $svc['featured_image'],
                    'status' => 'published',
                    'order' => $svc['order'],
                    'is_featured' => true,
                    'focus_keyword' => $svc['focus_keyword'],
                    'meta_title' => $svc['meta_title'],
                    'meta_description' => $svc['meta_description'],
                    'canonical_url' => 'https://hvaclinic.com/services/'.$svc['slug'].'/',
                    'og_title' => $svc['meta_title'],
                    'og_description' => $svc['meta_description'],
                    'og_image' => $svc['featured_image'],
                    'is_indexable' => true,
                    'seo_score' => 92,
                    'readability_score' => 88,
                    'schema_markup' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                ],
            );
        }

        return count($services);
    }

    /**
     * @param  array<string, mixed>  $seo
     * @param  array<string, mixed>  $record
     * @return array<string, mixed>
     */
    private function seoFields(array $seo, array $record): array
    {
        $robots = $seo['robots'] ?? [];
        $seoImage = $seo['og_image'][0]['url'] ?? null;

        if (! $seoImage || str_contains($seoImage, 'submit-spin.svg')) {
            $seoImage = $record['featured_image'] ?? null;
        }

        return [
            'meta_title' => $seo['title'] ?? $this->decodeText($record['title']),
            'meta_description' => $seo['description'] ?? null,
            'canonical_url' => $seo['canonical'] ?? $record['link'],
            'og_title' => $seo['og_title'] ?? $seo['title'] ?? null,
            'og_description' => $seo['og_description'] ?? $seo['description'] ?? null,
            'og_image' => $seoImage,
            'is_indexable' => ($robots['index'] ?? 'index') !== 'noindex',
        ];
    }

    private function deriveFocusKeyword(string $title, string $slug): string
    {
        $clean = strtolower($title);
        $clean = preg_replace('/&#[0-9]+;/', '', $clean);
        $clean = preg_replace('/[^\w\s-]/', '', $clean);
        $words = array_filter(explode(' ', $clean));

        // Prefer common commercial keywords if found
        $targets = ['rental chiller', 'chiller rental', 'rental ac', 'temporary cooling', 'chiller maintenance', 'generator rental', 'generator repair', 'ac repair', 'ac maintenance'];
        foreach ($targets as $target) {
            if (str_contains($clean, $target)) {
                return $target.' in uae';
            }
        }

        // Otherwise take first 3-4 significant words
        $stopWords = ['a', 'an', 'the', 'in', 'and', 'or', 'for', 'to', 'of', 'with', 'by', 'at', 'on', 'is', 'how', 'why', 'what'];
        $filtered = array_values(array_filter($words, fn ($w) => ! in_array($w, $stopWords) && strlen($w) > 2));

        if (! empty($filtered)) {
            return implode(' ', array_slice($filtered, 0, 4));
        }

        return str_replace('-', ' ', $slug);
    }

    private function decodeText(string $value): string
    {
        return html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    private function localizeMediaUrls(string $content): string
    {
        return str_replace(
            ['https://www.hvaclinic.com/wp-content/uploads/', 'https://hvaclinic.com/wp-content/uploads/'],
            '/wp-content/uploads/',
            $content,
        );
    }

    private function updateHeaderMenu(): void
    {
        MenuItem::query()->delete();

        // 1. Home
        MenuItem::create([
            'title' => 'Home',
            'url' => '/',
            'route_name' => 'home',
            'location' => 'header',
            'order' => 1,
            'type' => 'standard',
            'target' => '_self',
            'is_active' => true,
        ]);

        // 2. Services (Parent Dropdown)
        $servicesParent = MenuItem::create([
            'title' => 'Services',
            'url' => '/services/',
            'route_name' => null,
            'location' => 'header',
            'order' => 2,
            'type' => 'standard',
            'target' => '_self',
            'is_active' => true,
        ]);

        $subServices = [
            ['title' => 'Rental Chillers in UAE', 'url' => '/services/rental-chiller-in-uae/'],
            ['title' => 'Rental AC in UAE', 'url' => '/services/rental-ac-in-uae/'],
            ['title' => 'Temporary Cooling Solutions', 'url' => '/temporary-cooling-in-uae/'],
            ['title' => 'Chiller Maintenance & AMC', 'url' => '/services/chiller-maintenance-in-uae/'],
            ['title' => 'AC Maintenance & Repair', 'url' => '/services/ac-maintenance-repair-uae/'],
            ['title' => 'Generator Rental in UAE', 'url' => '/services/generator-rental-in-uae/'],
            ['title' => 'Generator Maintenance & Repair', 'url' => '/services/generator-maintenance-repair-in-uae/'],
            ['title' => 'Wild Air Ventilation Rental', 'url' => '/services/wild-air-rental-in-uae/'],
        ];

        foreach ($subServices as $idx => $sub) {
            MenuItem::create([
                'title' => $sub['title'],
                'url' => $sub['url'],
                'parent_id' => $servicesParent->id,
                'location' => 'header',
                'order' => $idx + 1,
                'type' => 'standard',
                'target' => '_self',
                'is_active' => true,
            ]);
        }

        // 3. Temporary Cooling
        MenuItem::create([
            'title' => 'Temporary Cooling',
            'url' => '/temporary-cooling-in-uae/',
            'route_name' => null,
            'location' => 'header',
            'order' => 3,
            'type' => 'standard',
            'target' => '_self',
            'is_active' => true,
        ]);

        // 4. Equipment
        MenuItem::create([
            'title' => 'Equipment',
            'url' => '/used-refurbished-equipment-in-uae/',
            'route_name' => null,
            'location' => 'header',
            'order' => 4,
            'type' => 'standard',
            'target' => '_self',
            'is_active' => true,
        ]);

        // 5. About
        MenuItem::create([
            'title' => 'About',
            'url' => '/about/',
            'route_name' => null,
            'location' => 'header',
            'order' => 5,
            'type' => 'standard',
            'target' => '_self',
            'is_active' => true,
        ]);

        // 6. Blog
        MenuItem::create([
            'title' => 'Blog',
            'url' => '/blog/',
            'route_name' => null,
            'location' => 'header',
            'order' => 6,
            'type' => 'standard',
            'target' => '_self',
            'is_active' => true,
        ]);

        // 7. Contact
        MenuItem::create([
            'title' => 'Contact',
            'url' => '/contact/',
            'route_name' => null,
            'location' => 'header',
            'order' => 7,
            'type' => 'standard',
            'target' => '_self',
            'is_active' => true,
        ]);
    }

    private function seedRedirectRules(): void
    {
        $rules = [
            ['source_url' => '/about-us', 'target_url' => '/about/', 'description' => 'Legacy about-us URL to /about/'],
            ['source_url' => '/about-us/', 'target_url' => '/about/', 'description' => 'Legacy about-us trailing slash to /about/'],
            ['source_url' => '/contact-us', 'target_url' => '/contact/', 'description' => 'Legacy contact-us to /contact/'],
            ['source_url' => '/contact-us/', 'target_url' => '/contact/', 'description' => 'Legacy contact-us trailing slash to /contact/'],
            ['source_url' => '/fleet', 'target_url' => '/used-refurbished-equipment-in-uae/', 'description' => 'Legacy fleet to equipment hub'],
            ['source_url' => '/products', 'target_url' => '/used-refurbished-equipment-in-uae/', 'description' => 'Legacy products to equipment hub'],
            ['source_url' => '/used-generators', 'target_url' => '/used-refurbished-equipment-in-uae/', 'description' => 'Legacy generators to equipment hub'],
            ['source_url' => '/used-refurbished-generators', 'target_url' => '/used-refurbished-equipment-in-uae/', 'description' => 'Legacy used generators to equipment hub'],
            ['source_url' => '/industries', 'target_url' => '/services/', 'description' => 'Legacy industries to services hub'],
            ['source_url' => '/locations', 'target_url' => '/services/', 'description' => 'Legacy locations to services hub'],
        ];

        foreach ($rules as $r) {
            RedirectRule::query()->updateOrCreate(
                ['source_url' => $r['source_url']],
                [
                    'target_url' => $r['target_url'],
                    'status_code' => 301,
                    'match_type' => 'exact',
                    'query_param_option' => 'ignore',
                    'group' => 'seo-migration',
                    'description' => $r['description'],
                    'is_active' => true,
                ],
            );
        }
    }
}
