<?php

$d = json_decode(file_get_contents('database/data/hvaclinic-content.json'), true);
foreach ($d['records'] as $r) {
    if (str_contains($r['link'], 'chiller-rental-dubai') || str_contains($r['path'] ?? '', 'chiller-rental-dubai')) {
        echo 'Link: '.$r['link'].' | Path: '.($r['path'] ?? '')."\n";
    }
}
