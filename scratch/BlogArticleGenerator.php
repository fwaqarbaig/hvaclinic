<?php

class BlogArticleGenerator
{
    private static array $mediaImages = [
        'generator' => [
            '/storage/media/2026/10/blog/generator-sizing-guide.jpg',
            '/storage/media/2026/10/blog/prime-vs-standby.jpg',
            '/storage/media/2026/10/blog/fuel-consumption.jpg',
            '/storage/media/2026/10/blog/high-ambient-50c.jpg',
            '/storage/media/2026/10/blog/ats-switch-guide.jpg',
            '/storage/media/2026/10/01-lptck9.jpg',
            '/storage/media/2026/10/02-xbimnj.jpg',
            '/storage/media/2026/10/03-8ab0vq.jpg',
            '/storage/media/2026/10/04-be9wys.jpg',
            '/storage/media/2026/10/05-6dnzah.jpg',
            '/storage/media/2026/10/2-im4l8z.jpg',
            '/storage/media/2026/10/4-s0ctda.jpg',
            '/storage/media/2026/10/5-5gbsbw.jpg',
            '/storage/media/2026/10/a-s4fzr8.jpg',
            '/storage/media/2026/10/b-wchmjz.jpg',
            '/storage/media/2026/10/c-br1a7y.jpg',
        ],
        'portacabin' => [
            '/storage/media/2026/10/blog/portacabin-power-wiring.jpg',
            '/storage/media/2026/10/06-wx9o27.jpg',
            '/storage/media/2026/10/03-8ab0vq.jpg',
            '/storage/media/2026/10/04-be9wys.jpg',
            '/storage/media/2026/10/01-lptck9.jpg',
            '/storage/media/2026/10/d-exewmv.jpg',
            '/storage/media/2026/10/e-sajmqx.jpg',
        ],
    ];

    public static function getImageForTopic(int $cluster, int $topicNum): string
    {
        if ($cluster === 7 || $cluster === 8) {
            $pool = self::$mediaImages['portacabin'];
        } else {
            $pool = self::$mediaImages['generator'];
        }

        return $pool[$topicNum % count($pool)];
    }

    public static function getCategorySlugForTopic(int $cluster): string
    {
        return match ($cluster) {
            1 => 'rental-power',
            2 => 'rental-power',
            3 => 'amc-generator',
            4 => 'power-plant',
            5 => 'services',
            6 => 'used-refurbished-generators',
            7 => 'portacabin',
            8 => 'portacabin',
            default => 'rental-power',
        };
    }

    public static function getTagsForTopic(array $topic): array
    {
        $cluster = (int) $topic['cluster'];
        $baseTags = match ($cluster) {
            1 => ['Generator Rental', 'Diesel Generators', 'Generator Sizing', 'Construction Power'],
            2 => ['UAE Logistics', 'Generator Rental', 'Industrial Power', 'JAFZA Power'],
            3 => ['Generator Maintenance', 'Generator AMC', 'Preventative Service', 'Diesel Overhaul'],
            4 => ['Multi-MW Power', 'Generator Synchronization', 'Medium Voltage', 'Substation Bypass'],
            5 => ['Industrial Power', 'Temporary Power', 'Event Power', 'Construction Power'],
            6 => ['Used Generators', 'Generator Buyback', 'Refurbished Gensets', 'Equipment Valuation'],
            7 => ['Used Portacabins', 'Scrap Portacabins', 'Portacabin Buy & Sell', 'Site Demolition'],
            8 => ['Portacabin Offices', 'Modular Buildings', 'Civil Defense Code', 'Sandwich Panels'],
            default => ['Generator Rental', 'Dubai Power'],
        };

        // Add topic-specific tag if applicable
        if (str_contains(strtolower($topic['title']), 'scrap')) {
            $baseTags[] = 'Scrap Portacabins';
        }
        if (str_contains(strtolower($topic['title']), 'amc')) {
            $baseTags[] = 'Generator AMC';
        }
        if (str_contains(strtolower($topic['title']), 'dubai')) {
            $baseTags[] = 'Dubai Power';
        }
        if (str_contains(strtolower($topic['title']), 'abu dhabi')) {
            $baseTags[] = 'Abu Dhabi Power';
        }

        return array_values(array_unique($baseTags));
    }
}
echo "BlogArticleGenerator base loaded.\n";
