<?php

$f = __DIR__.'/../database/data/hvaclinic-content.json';
$d = json_decode(file_get_contents($f), true);

$urls = [];
$urls['https://hvaclinic.com/wp-content/uploads/2026/04/fav.png'] = true;
$urls['https://hvaclinic.com/wp-content/uploads/2026/03/hvac.gif'] = true;
$urls['https://hvaclinic.com/wp-content/uploads/2026/03/1.jpg'] = true;

foreach ($d['records'] as $r) {
    if (! empty($r['featured_image'])) {
        $urls[$r['featured_image']] = true;
    }
    $content = $r['content'] ?? '';
    preg_match_all('/https?:\/\/(?:www\.)?hvaclinic\.com\/wp-content\/uploads\/[^\s"\'<>\)]+/i', $content, $m);
    foreach ($m[0] as $u) {
        $clean = rtrim($u, '.,;)\\"\'');
        $urls[$clean] = true;
    }
}

echo 'Total unique image/media URLs extracted: '.count($urls)."\n";

$existing = 0;
$missing = [];
foreach (array_keys($urls) as $url) {
    $parsed = parse_url($url, PHP_URL_PATH);
    if (! $parsed || ! str_starts_with($parsed, '/wp-content/uploads/')) {
        continue;
    }
    $localPath = __DIR__.'/../public'.$parsed;
    if (file_exists($localPath) && filesize($localPath) > 0) {
        $existing++;
    } else {
        $missing[] = ['url' => $url, 'local' => $localPath];
    }
}

echo "Existing local media files: $existing\n";
echo 'Missing local media files: '.count($missing)."\n";

if (count($missing) > 0) {
    echo "First 10 missing:\n";
    foreach (array_slice($missing, 0, 10) as $m) {
        echo "  {$m['url']}\n";
    }
}
