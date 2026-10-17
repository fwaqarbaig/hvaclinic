<?php

$d = json_decode(file_get_contents('database/data/hvaclinic-content.json'), true);
echo "Searching for home / front-page in records:\n";
$foundHome = false;
foreach ($d['records'] as $idx => $r) {
    $p = trim($r['path'] ?? '', '/');
    $link = trim($r['link'] ?? '', '/');
    if ($p === '' || $p === 'home' || $link === 'https://hvaclinic.com' || str_contains($r['title'], 'Home')) {
        echo "Match at index $idx: Path='{$r['path']}', Link='{$r['link']}', Title='{$r['title']}'\n";
        $foundHome = true;
    }
}
if (! $foundHome) {
    echo "NO HOME PAGE RECORD IN JSON!\n";
}
