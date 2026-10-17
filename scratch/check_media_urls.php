<?php

$d = json_decode(file_get_contents('database/data/hvaclinic-content.json'), true);
$urls = [];
foreach ($d['records'] as $record) {
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
echo 'Total unique media URLs: '.count($urls)."\n";
echo "Sample URLs:\n";
print_r(array_slice(array_keys($urls), 0, 10));
