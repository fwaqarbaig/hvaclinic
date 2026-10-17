<?php

$d = json_decode(file_get_contents('database/data/hvaclinic-content.json'), true);
$services = [];
foreach ($d['records'] as $r) {
    if ($r['type'] === 'pages') {
        $p = trim($r['path'] ?? parse_url($r['link'], PHP_URL_PATH), '/');
        if (str_starts_with($p, 'services/')) {
            $services[] = [
                'path' => $p,
                'title' => $r['title'],
                'link' => $r['link'],
            ];
        }
    }
}
echo 'Total service pages found in JSON: '.count($services)."\n";
foreach (array_slice($services, 0, 15) as $s) {
    echo "- {$s['path']} => {$s['title']}\n";
}
