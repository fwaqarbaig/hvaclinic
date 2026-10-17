<?php

$d = json_decode(file_get_contents('database/data/hvaclinic-content.json'), true);
echo "First record:\n";
print_r(array_keys($d['records'][0]));
echo "First 5 records link/title:\n";
for ($i = 0; $i < min(10, count($d['records'])); $i++) {
    $r = $d['records'][$i];
    echo 'Type: '.($r['type'] ?? '').' | Link: '.($r['link'] ?? '').' | Title: '.($r['title'] ?? '')."\n";
}
