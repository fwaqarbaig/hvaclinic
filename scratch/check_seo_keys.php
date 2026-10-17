<?php

$d = json_decode(file_get_contents('database/data/hvaclinic-content.json'), true);
$seoKeys = [];
foreach ($d['records'] as $r) {
    if (! empty($r['seo'])) {
        foreach (array_keys($r['seo']) as $k) {
            $seoKeys[$k] = ($seoKeys[$k] ?? 0) + 1;
        }
    }
}
print_r($seoKeys);
