<?php

$d = json_decode(file_get_contents('database/data/hvaclinic-content.json'), true);
echo "All page links:\n";
foreach ($d['records'] as $r) {
    if ($r['type'] === 'pages') {
        echo "path: '".($r['path'] ?? 'null')."' | link: '".($r['link'] ?? 'null')."' | title: '".($r['title'] ?? '')."'\n";
    }
}
