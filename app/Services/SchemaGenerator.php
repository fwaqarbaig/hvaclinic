<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Support\Str;

class SchemaGenerator
{
    /**
     * Canonical Organization & HVACBusiness Schema.
     *
     * @return array<string, mixed>
     */
    public static function organization(): array
    {
        $baseUrl = rtrim(config('app.url', 'https://hvaclinic.com'), '/');

        return [
            '@'.'context' => 'https://schema.org',
            '@type' => 'HVACBusiness',
            '@id' => "{$baseUrl}/#organization",
            'name' => 'HVAC Clinic',
            'legalName' => 'HVAC Clinic Commercial Cooling & Power Equipment LLC',
            'alternateName' => [
                'HVAC Clinic UAE',
                'HVAC Clinic Dubai',
                'Rental Chillers UAE',
                'HVAC Clinic Power & Cooling',
            ],
            'url' => "{$baseUrl}/",
            'logo' => [
                '@type' => 'ImageObject',
                '@id' => "{$baseUrl}/#logo",
                'url' => asset('wp-content/uploads/2026/03/hvac.gif'),
                'caption' => 'HVAC Clinic UAE Logo',
            ],
            'image' => asset('wp-content/uploads/2026/03/1.jpg'),
            'telephone' => '+971503692131',
            'email' => 'info@hvaclinic.com',
            'priceRange' => '$$',
            'currenciesAccepted' => 'AED',
            'paymentAccepted' => 'Cash, Credit Card, Bank Transfer, Cheque',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Industrial Area 3, Al Quoz & Dubai Industrial City',
                'addressLocality' => 'Dubai',
                'addressRegion' => 'Dubai',
                'addressCountry' => 'AE',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => 25.1325,
                'longitude' => 55.2341,
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    'opens' => '00:00',
                    'closes' => '23:59',
                ],
            ],
            'areaServed' => [
                ['@type' => 'City', 'name' => 'Dubai'],
                ['@type' => 'City', 'name' => 'Abu Dhabi'],
                ['@type' => 'City', 'name' => 'Sharjah'],
                ['@type' => 'City', 'name' => 'Ajman'],
                ['@type' => 'City', 'name' => 'Ras Al Khaimah'],
                ['@type' => 'City', 'name' => 'Fujairah'],
                ['@type' => 'City', 'name' => 'Umm Al Quwain'],
                ['@type' => 'City', 'name' => 'Al Ain'],
                ['@type' => 'Country', 'name' => 'United Arab Emirates'],
            ],
            'contactPoint' => [
                [
                    '@type' => 'ContactPoint',
                    'telephone' => '+971503692131',
                    'contactType' => 'emergency dispatch & technical sizing',
                    'areaServed' => 'AE',
                    'availableLanguage' => ['English', 'Arabic', 'Hindi', 'Urdu'],
                ],
                [
                    '@type' => 'ContactPoint',
                    'telephone' => '+971506457285',
                    'contactType' => 'customer service & plant sales',
                    'areaServed' => 'AE',
                    'availableLanguage' => ['English', 'Arabic'],
                ],
            ],
            'sameAs' => [
                'https://wa.me/971503692131',
            ],
        ];
    }

    /**
     * Canonical WebSite Schema with SearchAction.
     *
     * @return array<string, mixed>
     */
    public static function website(): array
    {
        $baseUrl = rtrim(config('app.url', 'https://hvaclinic.com'), '/');

        return [
            '@'.'context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => "{$baseUrl}/#website",
            'url' => "{$baseUrl}/",
            'name' => 'HVAC Clinic UAE',
            'description' => 'Commercial Chiller Rental, Temporary AC, Wild Air & Power Generator Solutions in UAE',
            'publisher' => [
                '@id' => "{$baseUrl}/#organization",
            ],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => "{$baseUrl}/blog?search={search_term_string}",
                ],
                'query-input' => 'required name=search_term_string',
            ],
            'inLanguage' => 'en-US',
        ];
    }

    /**
     * Global Linked Graph for Master Layout.
     *
     * @return array<string, mixed>
     */
    public static function globalGraph(): array
    {
        $org = static::organization();
        unset($org['@context']);

        $web = static::website();
        unset($web['@context']);

        return [
            '@'.'context' => 'https://schema.org',
            '@graph' => [
                $org,
                $web,
            ],
        ];
    }

    /**
     * BreadcrumbList Schema.
     *
     * @param  array<int, array{name: string, url?: string|null}>  $crumbs
     * @return array<string, mixed>
     */
    public static function breadcrumbs(array $crumbs): array
    {
        $elements = [];
        $position = 1;

        foreach ($crumbs as $crumb) {
            $item = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $crumb['name'],
            ];

            if (! empty($crumb['url'])) {
                $item['item'] = $crumb['url'];
            }

            $elements[] = $item;
            $position++;
        }

        return [
            '@'.'context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $elements,
        ];
    }

    /**
     * Article Schema for Blog Posts.
     *
     * @return array<string, mixed>
     */
    public static function forPost(Post $post): array
    {
        $baseUrl = rtrim(config('app.url', 'https://hvaclinic.com'), '/');
        $canonical = $post->canonical_url ?: route('post.show', $post->slug);
        $imageUrl = $post->seo_image ?: ($post->featured_image_url ?: asset('wp-content/uploads/2026/03/1.jpg'));

        $schema = [
            '@'.'context' => 'https://schema.org',
            '@type' => 'Article',
            '@id' => "{$canonical}#article",
            'isPartOf' => [
                '@id' => "{$baseUrl}/#website",
            ],
            'headline' => Str::limit($post->title, 110, ''),
            'name' => $post->title,
            'description' => $post->seo_description,
            'url' => $canonical,
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $canonical,
            ],
            'image' => [$imageUrl],
            'datePublished' => $post->published_at?->toIso8601String() ?: now()->toIso8601String(),
            'dateModified' => $post->updated_at?->toIso8601String() ?: now()->toIso8601String(),
            'author' => [
                '@type' => $post->user ? 'Person' : 'Organization',
                'name' => $post->user?->name ?: 'HVAC Clinic Engineering Editorial Team',
                'url' => route('author.show', $post->user?->slug ?: ($post->user?->name ? Str::slug($post->user->name) : 'hvaclinic')),
            ],
            'publisher' => [
                '@id' => "{$baseUrl}/#organization",
            ],
            'inLanguage' => 'en-US',
            'wordCount' => str_word_count(strip_tags($post->content ?? '')),
        ];

        if ($post->meta_keywords) {
            $schema['keywords'] = $post->meta_keywords;
        }

        if ($post->categories && $post->categories->isNotEmpty()) {
            $schema['articleSection'] = $post->categories->pluck('name')->all();
        }

        return $schema;
    }

    /**
     * Service Schema for Core Services.
     *
     * @return array<string, mixed>
     */
    public static function forService(Service $service): array
    {
        $baseUrl = rtrim(config('app.url', 'https://hvaclinic.com'), '/');
        $canonical = $service->canonical_url ?: route('service.show', $service->slug);
        $imageUrl = $service->seo_image ?: ($service->featured_image_url ?: asset('wp-content/uploads/2026/03/1.jpg'));

        return [
            '@'.'context' => 'https://schema.org',
            '@type' => 'Service',
            '@id' => "{$canonical}#service",
            'name' => $service->title,
            'serviceType' => $service->focus_keyword ?: $service->title,
            'description' => $service->seo_description,
            'url' => $canonical,
            'image' => $imageUrl,
            'provider' => [
                '@id' => "{$baseUrl}/#organization",
            ],
            'category' => 'Commercial HVAC & Temporary Power Rental',
            'areaServed' => [
                ['@type' => 'City', 'name' => 'Dubai'],
                ['@type' => 'City', 'name' => 'Abu Dhabi'],
                ['@type' => 'City', 'name' => 'Sharjah'],
                ['@type' => 'City', 'name' => 'Ajman'],
                ['@type' => 'City', 'name' => 'Ras Al Khaimah'],
                ['@type' => 'City', 'name' => 'Fujairah'],
                ['@type' => 'City', 'name' => 'Umm Al Quwain'],
                ['@type' => 'City', 'name' => 'Al Ain'],
                ['@type' => 'Country', 'name' => 'United Arab Emirates'],
            ],
            'offers' => [
                '@type' => 'Offer',
                'availability' => 'https://schema.org/InStock',
                'price' => 'Contact for fast itemized sizing quote',
                'priceCurrency' => 'AED',
                'url' => $canonical,
                'seller' => [
                    '@id' => "{$baseUrl}/#organization",
                ],
            ],
        ];
    }

    /**
     * WebPage Schema for Static & CMS Pages.
     *
     * @return array<string, mixed>
     */
    public static function forPage(Page $page): array
    {
        $baseUrl = rtrim(config('app.url', 'https://hvaclinic.com'), '/');
        $canonical = $page->canonical_url ?: url('/'.ltrim($page->slug, '/').'/');

        $type = match ($page->slug) {
            'about', 'about-us' => 'AboutPage',
            'contact', 'contact-us' => 'ContactPage',
            'our-team' => 'ProfilePage',
            'membership' => 'AboutPage',
            'certificates' => 'ItemPage',
            default => 'WebPage',
        };

        $imageUrl = $page->seo_image ?: ($page->featured_image_url ?: asset('wp-content/uploads/2026/03/1.jpg'));

        return [
            '@'.'context' => 'https://schema.org',
            '@type' => $type,
            '@id' => "{$canonical}#webpage",
            'name' => $page->title,
            'headline' => $page->title,
            'description' => $page->seo_description,
            'url' => $canonical,
            'isPartOf' => [
                '@id' => "{$baseUrl}/#website",
            ],
            'about' => [
                '@id' => "{$baseUrl}/#organization",
            ],
            'publisher' => [
                '@id' => "{$baseUrl}/#organization",
            ],
            'image' => $imageUrl,
            'inLanguage' => 'en-US',
            'datePublished' => $page->created_at?->toIso8601String() ?: now()->toIso8601String(),
            'dateModified' => $page->updated_at?->toIso8601String() ?: now()->toIso8601String(),
        ];
    }

    /**
     * FAQPage Schema for Structured Questions and Answers.
     *
     * @param  array<int, array{question: string, answer: string}>  $faqs
     * @return array<string, mixed>|null
     */
    public static function forFaqs(array $faqs): ?array
    {
        if (empty($faqs)) {
            return null;
        }

        $mainEntity = [];
        foreach ($faqs as $faq) {
            $question = trim($faq['question'] ?? '');
            $answer = trim($faq['answer'] ?? '');

            if ($question === '' || $answer === '') {
                continue;
            }

            $mainEntity[] = [
                '@type' => 'Question',
                'name' => $question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $answer,
                ],
            ];
        }

        if (empty($mainEntity)) {
            return null;
        }

        return [
            '@'.'context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $mainEntity,
        ];
    }

    /**
     * CollectionPage / ItemList Schema for Archives.
     *
     * @param  iterable<int, mixed>  $items
     * @param  callable(mixed, int): array<string, mixed>  $transformer
     * @return array<string, mixed>
     */
    public static function forItemList(string $name, iterable $items, callable $transformer): array
    {
        $elements = [];
        $index = 1;

        foreach ($items as $item) {
            $transformed = $transformer($item, $index);
            if (! empty($transformed)) {
                $elements[] = array_merge([
                    '@type' => 'ListItem',
                    'position' => $index,
                ], $transformed);
                $index++;
            }
        }

        return [
            '@'.'context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => $name,
            'itemListElement' => $elements,
        ];
    }

    /**
     * Extract FAQs from HTML Content (<details><summary> or <h3>Question?</h3><p>Answer</p>).
     *
     * @return array<int, array{question: string, answer: string}>
     */
    public static function extractFaqs(?string $content): array
    {
        if (empty($content)) {
            return [];
        }

        $faqs = [];

        // 1. Try matching <details><summary>Question</summary><div>Answer</div></details>
        if (preg_match_all('/<details[^>]*>\s*<summary[^>]*>(.*?)<\/summary>\s*(?:<div[^>]*>)?(.*?)(?:<\/div>)?\s*<\/details>/is', $content, $detailMatches)) {
            foreach ($detailMatches[1] as $index => $rawQuestion) {
                $cleanQ = preg_replace('/[▼▲►▼]/u', '', strip_tags($rawQuestion));
                $cleanQ = trim($cleanQ);
                $cleanA = trim(strip_tags($detailMatches[2][$index] ?? ''));
                if ($cleanQ !== '' && $cleanA !== '') {
                    $faqs[] = [
                        'question' => $cleanQ,
                        'answer' => $cleanA,
                    ];
                }
            }
        }

        // 2. Fallback: <h3/h4>Question?</h3/h4><p>Answer</p>
        if (empty($faqs)) {
            preg_match_all('/<h[34][^>]*>([^<]*\?[^<]*)<\/h[34]>\s*<p[^>]*>(.*?)<\/p>/is', $content, $headingMatches);
            if (! empty($headingMatches[1])) {
                foreach ($headingMatches[1] as $index => $question) {
                    $q = trim(strip_tags($question));
                    $a = trim(strip_tags($headingMatches[2][$index] ?? ''));
                    if ($q !== '' && $a !== '') {
                        $faqs[] = [
                            'question' => $q,
                            'answer' => $a,
                        ];
                    }
                }
            }
        }

        return $faqs;
    }

    /**
     * Render schema array as HTML script tag.
     */
    public static function render(mixed $schema): string
    {
        if (empty($schema)) {
            return '';
        }

        if (is_string($schema)) {
            $trimmed = trim($schema);
            if (str_starts_with($trimmed, '<script')) {
                return $trimmed;
            }

            return "<script type=\"application/ld+json\">\n{$trimmed}\n</script>";
        }

        $json = json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return "<script type=\"application/ld+json\">\n{$json}\n</script>";
    }

    /**
     * Render primary schema for a model: custom schema markup if provided,
     * otherwise the auto-generated fallback schema.
     */
    public static function renderPrimary(mixed $model, callable $generator): string
    {
        $custom = null;
        if (is_object($model) && isset($model->schema_markup)) {
            $custom = trim((string) $model->schema_markup);
        }

        if (! empty($custom)) {
            return static::render($custom);
        }

        $generated = $generator();
        if (empty($generated)) {
            return '';
        }

        return static::render($generated);
    }
}
