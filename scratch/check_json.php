<?php

$f = 'database/data/hvaclinic-content.json';
if (! file_exists($f)) {
    echo "File not found\n";
    exit;
}
$d = json_decode(file_get_contents($f), true);
echo 'Fetched at: '.($d['fetched_at'] ?? 'none')."\n";
echo 'Source: '.($d['source'] ?? 'none')."\n";
echo 'Categories count: '.count($d['categories'] ?? [])."\n";
echo 'Tags count: '.count($d['tags'] ?? [])."\n";
echo 'Records count: '.count($d['records'] ?? [])."\n";

$types = [];
$urls = [];
foreach ($d['records'] as $r) {
    $t = $r['type'] ?? 'unknown';
    $types[$t] = ($types[$t] ?? 0) + 1;
    $urls[$t][] = $r['link'] ?? $r['slug'] ?? '';
}
print_r($types);
foreach ($types as $t => $cnt) {
    echo "Sample $t URLs:\n";
    print_r(array_slice($urls[$t], 0, 5));
}
