<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class SeoInternalLinker
{
    /**
     * Map a blog post to its most relevant HVAC or power service.
     */
    public function matchServiceForPost(Post $post): ?Service
    {
        $services = Service::published()->get();

        if ($services->isEmpty()) {
            return null;
        }

        $categoriesText = $post->relationLoaded('categories')
            ? $post->categories->pluck('name')->join(' ')
            : $post->categories()->pluck('name')->join(' ');

        $haystack = strtolower(
            $post->title.' '.
            $post->slug.' '.
            $categoriesText.' '.
            Str::limit(strip_tags((string) $post->content), 400)
        );

        // 1. Chiller Maintenance & AMC
        if (str_contains($haystack, 'chiller maintenance') || str_contains($haystack, 'chiller amc') || str_contains($haystack, 'coil cleaning') || str_contains($haystack, 'compressor overhaul') || str_contains($haystack, 'condenser cleaning') || str_contains($haystack, 'amc in dubai')) {
            $service = $services->firstWhere('slug', 'chiller-maintenance-in-uae');
            if ($service) {
                return $service;
            }
        }

        // 2. Wild Air & Ventilation
        if (str_contains($haystack, 'wild air') || str_contains($haystack, 'air mover') || str_contains($haystack, 'construction ventilation') || str_contains($haystack, 'basement cooling') || str_contains($haystack, 'humidity control') || str_contains($haystack, 'wild-air')) {
            $service = $services->firstWhere('slug', 'wild-air-rental-in-uae');
            if ($service) {
                return $service;
            }
        }

        // 3. Rental AC, Spot Coolers & Packaged Units
        if (str_contains($haystack, 'packaged unit') || str_contains($haystack, 'package unit') || str_contains($haystack, 'spot cooler') || str_contains($haystack, 'rental ac') || str_contains($haystack, 'tent cooling') || str_contains($haystack, 'tent ac') || str_contains($haystack, 'air conditioner rental')) {
            $service = $services->firstWhere('slug', 'rental-ac-in-uae');
            if ($service) {
                return $service;
            }
        }

        // 4. Used & Refurbished Chillers / Buyer / Sale
        if (str_contains($haystack, 'used chiller') || str_contains($haystack, 'refurbished chiller') || str_contains($haystack, 'chiller buyer') || str_contains($haystack, 'second hand chiller') || str_contains($haystack, 'used equipment') || str_contains($haystack, 'refurbished equipment')) {
            $service = $services->firstWhere('slug', 'used-refurbished-equipment-in-uae');
            if ($service) {
                return $service;
            }
        }

        // 5. Rental Generator / Power
        if (str_contains($haystack, 'generator rental') || str_contains($haystack, 'diesel generator') || str_contains($haystack, 'rental generator') || str_contains($haystack, 'standby power') || str_contains($haystack, 'kva') || str_contains($haystack, 'generator in dubai')) {
            $service = $services->firstWhere('slug', 'generator-rental-in-uae');
            if ($service) {
                return $service;
            }
        }

        // 6. Generator Repair & Maintenance
        if (str_contains($haystack, 'generator maintenance') || str_contains($haystack, 'generator repair') || str_contains($haystack, 'generator amc') || str_contains($haystack, 'ats switch') || str_contains($haystack, 'power distribution') || str_contains($haystack, 'rental power')) {
            $service = $services->firstWhere('slug', 'generator-maintenance-repair-in-uae')
                ?? $services->firstWhere('slug', 'generator-rental-in-uae');
            if ($service) {
                return $service;
            }
        }

        // 7. Rental Chiller in UAE (Specific flagship service)
        if (str_contains($haystack, 'rental chiller') || str_contains($haystack, 'chiller rental') || str_contains($haystack, 'water chiller') || str_contains($haystack, 'air-cooled chiller') || str_contains($haystack, 'cooling tower')) {
            $service = $services->firstWhere('slug', 'rental-chiller-in-uae')
                ?? $services->firstWhere('slug', 'rental-cooling');
            if ($service) {
                return $service;
            }
        }

        // 8. General Rental Cooling & Temporary Climate Control
        return $services->firstWhere('slug', 'rental-cooling')
            ?? $services->firstWhere('slug', 'rental-chiller-in-uae')
            ?? $services->first();
    }

    /**
     * Get related technical articles for a specific HVAC / power service.
     *
     * @return Collection<int, Post>
     */
    public function getRelatedPostsForService(Service $service, int $limit = 4): Collection
    {
        $keywords = match ($service->slug) {
            'rental-chiller-in-uae' => ['chiller', 'rental chiller', 'emergency chiller', 'ton', 'cooling'],
            'rental-cooling' => ['cooling', 'temporary cooling', 'rental cooling', 'heat', 'shutdown'],
            'rental-ac-in-uae' => ['ac', 'packaged', 'spot cooler', 'tent', 'package unit'],
            'wild-air-rental-in-uae' => ['wild air', 'ventilation', 'fresh air', 'duct', 'moisture'],
            'chiller-maintenance-in-uae' => ['maintenance', 'amc', 'repair', 'compressor', 'service'],
            'generator-rental-in-uae' => ['generator', 'diesel', 'power', 'prime', 'kva'],
            'generator-maintenance-repair-in-uae' => ['generator', 'repair', 'maintenance', 'ats', 'wiring'],
            'used-refurbished-equipment-in-uae' => ['used', 'refurbished', 'buyer', 'sale', 'equipment'],
            'ac-maintenance-repair-uae' => ['ac repair', 'ac maintenance', 'split', 'hvac'],
            'temporary-cooling-in-uae' => ['temporary cooling', 'climate', 'cooling', 'chiller'],
            default => ['cooling', 'chiller', 'rental', 'hvac'],
        };

        $query = Post::published()
            ->with(['user', 'categories'])
            ->where(function ($q) use ($keywords) {
                foreach ($keywords as $kw) {
                    $q->orWhere('title', 'like', "%{$kw}%")
                        ->orWhere('slug', 'like', "%{$kw}%");
                }
            })
            ->latest('published_at');

        $posts = $query->take($limit)->get();

        if ($posts->count() < $limit) {
            $missing = $limit - $posts->count();
            $fallbackPosts = Post::published()
                ->whereNotIn('id', $posts->pluck('id'))
                ->with(['user', 'categories'])
                ->latest('published_at')
                ->take($missing)
                ->get();

            $posts = $posts->merge($fallbackPosts);
        }

        return $posts;
    }

    /**
     * Contextual internal linking engine:
     * Injects 2 to 4 contextual crawlable links into content bodies for high-intent HVAC keywords.
     */
    public function autoLinkContent(?string $html, ?string $currentUrl = null): string
    {
        if (empty($html) || ! is_string($html)) {
            return '';
        }

        $keywords = [
            // Long-tail Chiller Rentals
            'emergency chiller rental in uae' => '/services/rental-chiller-in-uae/emergency-chiller-rental-in-uae/',
            'emergency chiller rental' => '/services/rental-chiller-in-uae/emergency-chiller-rental-in-uae/',
            'air cooled chiller rental in uae' => '/services/rental-chiller-in-uae/air-cooled-chiller-rental-in-uae/',
            'air cooled chiller rental' => '/services/rental-chiller-in-uae/air-cooled-chiller-rental-in-uae/',
            'water cooled chiller in uae' => '/services/rental-chiller-in-uae/water-cooled-chiller-in-uae/',
            'water cooled chiller rental' => '/services/rental-chiller-in-uae/water-cooled-chiller-in-uae/',
            'industrial chiller rental in uae' => '/services/rental-chiller-in-uae/industrial-chiller-rental-in-uae/',
            'industrial chiller rental' => '/services/rental-chiller-in-uae/industrial-chiller-rental-in-uae/',
            'rental chiller in uae' => '/services/rental-chiller-in-uae/',
            'rental chillers in uae' => '/services/rental-chiller-in-uae/',
            'rental chiller in dubai' => '/services/rental-chiller-in-uae/',
            'chiller rental in uae' => '/services/rental-chiller-in-uae/',

            // Long-tail AC Rentals
            'floor standing ac rental in uae' => '/services/rental-ac-in-uae/floor-standing-ac-rental-in-uae/',
            'floor standing ac rental' => '/services/rental-ac-in-uae/floor-standing-ac-rental-in-uae/',
            'portable ac rental in dubai' => '/services/rental-ac-in-uae/portable-ac-rental-in-dubai/',
            'portable ac rental in uae' => '/services/rental-ac-in-uae/portable-ac-rental-in-uae/',
            'portable ac rental' => '/services/rental-ac-in-uae/portable-ac-rental-in-uae/',
            'outdoor ac rental in dubai' => '/services/rental-ac-in-uae/outdoor-ac-rental-in-dubai/',
            'rental packaged unit in uae' => '/services/rental-ac-in-uae/',
            'rental packaged unit' => '/services/rental-ac-in-uae/',
            'rental ac in dubai' => '/services/rental-ac-in-uae/',
            'rental ac in uae' => '/services/rental-ac-in-uae/',
            'rental ac' => '/services/rental-ac-in-uae/',

            // Temporary Cooling & Ventilation
            'rental cooling in dubai' => '/services/rental-cooling/',
            'rental cooling in uae' => '/services/rental-cooling/',
            'rental cooling' => '/services/rental-cooling/',
            'wild air rental in uae' => '/services/wild-air-rental-in-uae/',
            'wild air rental in dubai' => '/services/wild-air-rental-in-uae/',
            'wild air rental' => '/services/wild-air-rental-in-uae/',
            'rental wild air in dubai' => '/services/wild-air-rental-in-uae/',

            // AC Maintenance & Repair (Newly Added Vertical)
            'ac maintenance & repair uae' => '/services/ac-maintenance-repair-uae/',
            'ac maintenance in dubai' => '/services/ac-maintenance-repair-uae/ac-maintenance-in-dubai/',
            'ac maintenance in abu dhabi' => '/services/ac-maintenance-repair-uae/ac-maintenance-in-abu-dhabi/',
            'ac repair in abu dhabi' => '/services/ac-maintenance-repair-uae/ac-repair-in-abu-dhabi/',
            'ac repair in dubai' => '/services/ac-maintenance-repair-uae/ac-repair-in-dubai/',
            'ac amc in uae' => '/services/ac-maintenance-repair-uae/ac-amc-in-uae/',

            // Chiller Maintenance & AMC
            'chiller maintenance in uae' => '/services/chiller-maintenance-in-uae/',
            'chiller maintenance' => '/services/chiller-maintenance-in-uae/',
            'chiller amc in dubai' => '/services/chiller-maintenance-in-uae/',
            'chiller amc in uae' => '/services/chiller-maintenance-in-uae/chiller-amc-in-uae/',
            'chiller amc' => '/services/chiller-maintenance-in-uae/',
            'chiller repair in uae' => '/services/chiller-maintenance-in-uae/chiller-repair-in-uae/',
            'chiller repair in dubai' => '/services/chiller-maintenance-in-uae/chiller-repair-in-dubai/',

            // Power Generation & AMC
            'emergency generator rental uae' => '/services/generator-rental-in-uae/emergency-generator-rental-uae/',
            'generator amc in uae' => '/services/generator-maintenance-repair-in-uae/generator-amc-in-uae/',
            'generator repair in uae' => '/services/generator-maintenance-repair-in-uae/generator-repair-in-uae/',
            'rental generator in uae' => '/services/generator-rental-in-uae/',
            'generator rental in uae' => '/services/generator-rental-in-uae/',
            'generator rental' => '/services/generator-rental-in-uae/',
            'rental power in dubai' => '/services/generator-maintenance-repair-in-uae/',
            'rental power' => '/services/generator-maintenance-repair-in-uae/',

            // Used & Refurbished Equipment
            'refurbished chiller sale in uae' => '/used-refurbished-equipment-in-uae/',
            'used chiller buyer in uae' => '/used-refurbished-equipment-in-uae/',
            'refurbished chiller in uae' => '/used-refurbished-equipment-in-uae/',
            'used chiller buyer' => '/used-refurbished-equipment-in-uae/',
            'refurbished chiller' => '/used-refurbished-equipment-in-uae/',

            // Conversion CTAs
            'request engineering quote' => '/contact/',
            'contact our engineers' => '/contact/',
            'hvac clinic' => '/',
        ];

        // Tokens split by HTML tags
        $tokens = preg_split('/(<[^>]+>)/', $html, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        if (! is_array($tokens)) {
            return $html;
        }

        $inAnchor = false;
        $inHeading = false;
        $linkedCount = 0;
        $maxLinks = 4;
        $usedUrls = [];

        if ($currentUrl) {
            $parsedPath = parse_url($currentUrl, PHP_URL_PATH);
            $cleanCurrent = '/'.trim((string) $parsedPath, '/').'/';
            $usedUrls[$cleanCurrent] = true;
            $usedUrls[rtrim($cleanCurrent, '/')] = true;
        }

        $result = '';
        foreach ($tokens as $token) {
            if (str_starts_with($token, '<')) {
                if (preg_match('/^<a[\s>]/i', $token)) {
                    $inAnchor = true;
                } elseif (preg_match('/^<\/a>/i', $token)) {
                    $inAnchor = false;
                } elseif (preg_match('/^<h[1-6][\s>]/i', $token)) {
                    $inHeading = true;
                } elseif (preg_match('/^<\/h[1-6]>/i', $token)) {
                    $inHeading = false;
                }
                $result .= $token;

                continue;
            }

            if ($inAnchor || $inHeading || $linkedCount >= $maxLinks) {
                $result .= $token;

                continue;
            }

            // Process text node
            $text = $token;
            foreach ($keywords as $kw => $targetUrl) {
                if ($linkedCount >= $maxLinks) {
                    break;
                }

                $cleanTarget = '/'.trim($targetUrl, '/').'/';
                if (isset($usedUrls[$cleanTarget]) || isset($usedUrls[rtrim($cleanTarget, '/')])) {
                    continue;
                }

                $pattern = '/\b('.preg_quote($kw, '/').')\b/i';
                if (preg_match($pattern, $text, $matches)) {
                    $matchedText = $matches[1];
                    $anchor = '<a href="'.$cleanTarget.'" class="text-blue-700 hover:text-blue-900 font-semibold underline decoration-blue-300 hover:decoration-blue-700 transition" title="'.htmlspecialchars(ucwords($kw)).'">'.$matchedText.'</a>';
                    $text = preg_replace($pattern, $anchor, $text, 1);

                    $usedUrls[$cleanTarget] = true;
                    $usedUrls[rtrim($cleanTarget, '/')] = true;
                    $linkedCount++;
                }
            }

            $result .= $text;
        }

        return $result;
    }
}
