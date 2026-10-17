<?php

$f = __DIR__.'/../database/data/hvaclinic-content.json';
$d = json_decode(file_get_contents($f), true);

$allPagesLinks = [];
foreach ($d['records'] as $r) {
    if ($r['type'] === 'pages') {
        $allPagesLinks[] = $r['link'];
    }
}

echo 'Found '.count($allPagesLinks)." page links in JSON:\n";
foreach ($allPagesLinks as $l) {
    echo "  $l\n";
}
