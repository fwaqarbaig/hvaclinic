<?php

$f = __DIR__.'/../database/data/hvaclinic-content.json';
$d = json_decode(file_get_contents($f), true);

echo "JSON metadata / summary:\n";
echo 'Export Date: '.($d['exported_at'] ?? 'none')."\n";
echo 'Categories: '.count($d['categories'] ?? [])."\n";
echo 'Tags: '.count($d['tags'] ?? [])."\n";
echo 'Total Records: '.count($d['records'] ?? [])."\n";

$pages = 0;
$posts = 0;
$aboutSubpages = [];
$servicesSubpages = [];

foreach ($d['records'] as $r) {
    if ($r['type'] === 'pages') {
        $pages++;
        $link = $r['link'] ?? '';
        $title = $r['title'] ?? '';
        if (str_contains($link, '/about') || str_contains($link, '/team') || str_contains($link, '/membership') || str_contains($link, '/certificate')) {
            $aboutSubpages[] = ['title' => $title, 'link' => $link];
        }
    } elseif ($r['type'] === 'posts') {
        $posts++;
    }
}

echo "Pages in JSON: $pages\n";
echo "Posts in JSON: $posts\n";
echo "\nAbout-related pages:\n";
print_r($aboutSubpages);
