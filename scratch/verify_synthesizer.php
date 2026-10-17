<?php

require __DIR__.'/test_article_synthesis.php';

// Test 1 topic from each of the 8 clusters
$testTopics = [
    [
        'num' => 1,
        'cluster' => 1,
        'title' => 'How to Size a 50 kVA Diesel Generator: Single-Phase vs 3-Phase UAE Guide',
        'slug' => 'size-50-kva-generator-uae',
        'keyword' => '50 kva generator rental',
        'intent' => 'Commercial / Sizing',
    ],
    [
        'num' => 51,
        'cluster' => 2,
        'title' => 'Generator Rental in JAFZA (Jebel Ali Free Zone): Customs Gate Passes & Logistics',
        'slug' => 'generator-rental-jafza-dubai-permits',
        'keyword' => 'generator rental jafza dubai',
        'intent' => 'Transactional / Geo Logistics',
    ],
    [
        'num' => 111,
        'cluster' => 3,
        'title' => 'Generator AMC Contract Checklist in Dubai: What Should Your Service Agreement Include?',
        'slug' => 'generator-amc-contract-checklist-dubai',
        'keyword' => 'generator amc dubai',
        'intent' => 'Commercial Investigation',
    ],
    [
        'num' => 161,
        'cluster' => 4,
        'title' => 'Multi-Megawatt Generator Synchronization: Paralleling 1000 kVA to 2000 kVA Sets in UAE',
        'slug' => 'multi-megawatt-generator-synchronization-uae',
        'keyword' => 'generator synchronization uae',
        'intent' => 'Technical / Megawatt Power',
    ],
    [
        'num' => 201,
        'cluster' => 5,
        'title' => 'Temporary Power for Marine Shipyards & Drydocks in Dubai Maritime City & Fujairah',
        'slug' => 'temporary-power-marine-shipyards-drydock-uae',
        'keyword' => 'shipyard temporary power uae',
        'intent' => 'Commercial / Marine Sector',
    ],
    [
        'num' => 251,
        'cluster' => 6,
        'title' => 'How to Value a Used Diesel Generator in UAE: Running Hours vs True Engine Wear',
        'slug' => 'value-used-diesel-generator-uae-hours',
        'keyword' => 'used generator valuation uae',
        'intent' => 'Commercial / Trading',
    ],
    [
        'num' => 291,
        'cluster' => 7,
        'title' => 'Used Portacabins in Dubai & UAE: The Ultimate Buyer & Seller Inspection Manual',
        'slug' => 'used-portacabins-dubai-buyers-guide',
        'keyword' => 'used portacabin dubai buy sell',
        'intent' => 'Commercial / Modular Cabins',
    ],
    [
        'num' => 351,
        'cluster' => 8,
        'title' => '50-Person Construction Site Compound: Modular Portacabin Layout & MEP Sizing Guide',
        'slug' => '50-person-construction-compound-portacabin-design',
        'keyword' => 'construction site office layout uae',
        'intent' => 'Technical / Modular Planning',
    ],
];

echo "========================================================\n";
echo "TESTING ARTICLE SYNTHESIS WORD COUNTS (ALL 8 CLUSTERS)\n";
echo "========================================================\n\n";

$allPassed = true;

foreach ($testTopics as $t) {
    $art = ArticleSynthesizer::synthesize($t);
    $plainText = strip_tags($art['content']);
    $wordCount = str_word_count($plainText);
    $status = ($wordCount >= 1000) ? 'PASS' : 'FAIL (<1000 words)';
    if ($wordCount < 1000) {
        $allPassed = false;
    }

    echo sprintf(
        "Cluster %d (Topic #%03d): %-48s -> %4d words [%s]\n",
        $t['cluster'],
        $t['num'],
        substr($art['slug'], 0, 48),
        $wordCount,
        $status
    );
}

echo "\nResult: ".($allPassed ? 'ALL 8 CLUSTERS EXCEED 1,000 WORDS! PASS' : 'SOME CLUSTERS UNDER 1,000 WORDS')."\n";
