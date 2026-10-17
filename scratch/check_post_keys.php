<?php

$d = json_decode(file_get_contents('database/data/hvaclinic-content.json'), true);
foreach ($d['records'] as $r) {
    if ($r['type'] === 'posts') {
        echo "Post record keys:\n";
        print_r(array_keys($r));
        echo 'path: '.($r['path'] ?? 'none')."\n";
        echo 'slug: '.($r['slug'] ?? 'none')."\n";
        echo 'link: '.($r['link'] ?? 'none')."\n";
        break;
    }
}
