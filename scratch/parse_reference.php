<?php

$file = 'C:/Users/Graphics/.gemini/antigravity/brain/99223166-76a5-4f13-90a2-b4a2df221838/.system_generated/steps/215/content.md';
$html = file_get_contents($file);

// Extract title, h1, h2, h3
preg_match('/<title>(.*?)<\/title>/is', $html, $mTitle);
echo 'TITLE: '.($mTitle[1] ?? 'None')."\n\n";

preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $html, $mH1);
echo 'H1: '.trim(strip_tags($mH1[1] ?? 'None'))."\n\n";

preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $html, $mH2);
echo "H2 HEADINGS:\n";
foreach ($mH2[1] as $h2) {
    echo '  - '.trim(strip_tags($h2))."\n";
}

preg_match_all('/<h3[^>]*>(.*?)<\/h3>/is', $html, $mH3);
echo "\nH3 HEADINGS:\n";
foreach ($mH3[1] as $h3) {
    echo '  - '.trim(strip_tags($h3))."\n";
}

// Extract Schema JSON-LD
preg_match_all('/<script type=["\']application\/ld\+json["\'][^>]*>(.*?)<\/script>/is', $html, $mSchema);
echo "\nSCHEMA JSON-LD BLOCKS FOUND: ".count($mSchema[1])."\n";
foreach ($mSchema[1] as $i => $s) {
    echo '--- Schema block '.($i + 1)." ---\n";
    $json = json_decode($s, true);
    if ($json) {
        echo 'Type: '.($json['@type'] ?? (isset($json['@graph']) ? 'Graph with '.count($json['@graph']).' nodes' : 'unknown'))."\n";
        if (isset($json['@graph'])) {
            foreach ($json['@graph'] as $node) {
                echo '   * '.($node['@type'] ?? 'unknown')."\n";
            }
        }
    } else {
        echo substr($s, 0, 300)."...\n";
    }
}

// Extract images
preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*alt=["\']([^"\']*)["\']/is', $html, $mImages);
echo "\nIMAGES FOUND:\n";
foreach ($mImages[1] as $idx => $src) {
    if (str_contains($src, 'wp-content/uploads')) {
        echo '  - '.$src.' (Alt: '.($mImages[2][$idx] ?? '').")\n";
    }
}
