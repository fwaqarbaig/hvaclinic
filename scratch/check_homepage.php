<?php

$d = json_decode(file_get_contents('database/data/hvaclinic-content.json'), true);
foreach ($d['records'] as $r) {
    if ($r['link'] === 'https://hvaclinic.com/' || $r['slug'] === 'home' || trim(parse_url($r['link'], PHP_URL_PATH), '/') === '') {
        echo "Found Homepage Record:\n";
        echo 'Title: '.$r['title']."\n";
        echo 'Link: '.$r['link']."\n";
        echo 'Type: '.$r['type']."\n";
        echo 'Content Length: '.strlen($r['content'])."\n";
        echo 'SEO: '.json_encode($r['seo'])."\n";
        echo 'Snippet: '.substr(strip_tags($r['content']), 0, 500)."\n";
    }
}
