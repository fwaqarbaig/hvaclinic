<?php

$data = json_decode(file_get_contents(__DIR__.'/../storage/generatordubai_full_data.json'), true);

function dumpPageInfo($key, $item)
{
    echo "====================================================\n";
    echo "KEY: $key\n";
    echo 'URL: '.($item['url'] ?? '')."\n";
    echo 'COMPONENT: '.($item['component'] ?? '')."\n";
    $props = $item['props'] ?? [];
    if (isset($props['page'])) {
        echo 'PAGE TITLE: '.($props['page']['title'] ?? '')."\n";
        echo 'META TITLE: '.($props['page']['meta_title'] ?? '')."\n";
        echo 'META DESC: '.($props['page']['meta_description'] ?? '')."\n";
        echo 'CONTENT LEN: '.strlen($props['page']['content'] ?? '')."\n";
    }
    foreach ($props as $pk => $pv) {
        if (! in_array($pk, ['errors', 'auth', 'site', 'primaryMenu', 'flash', 'ziggy', 'page'])) {
            echo "EXTRA PROP: $pk (type: ".gettype($pv).(is_array($pv) ? ', count: '.count($pv) : '').")\n";
        }
    }
}

foreach (['industries', 'used-refurbished-generators', 'locations', 'locations/dubai', 'services', 'services/power-plant', 'services/amc-generator', 'services/portacabin'] as $k) {
    if (isset($data[$k])) {
        dumpPageInfo($k, $data[$k]);
    }
}
