<?php

$data = json_decode(file_get_contents(__DIR__.'/../storage/generatordubai_full_data.json'), true);

$pagesToCheck = [
    'industries',
    'used-refurbished-generators',
    'locations',
    'locations/dubai',
    'services',
    'services/power-plant',
    'fleet',
    'about-us',
    'contact-us',
];

foreach ($pagesToCheck as $p) {
    if (isset($data[$p])) {
        $props = $data[$p]['props'] ?? [];
        echo "=== PAGE: $p ===\n";
        echo 'Component: '.($data[$p]['component'] ?? 'N/A')."\n";
        echo 'Props keys: '.implode(', ', array_keys($props))."\n";
        if (isset($props['page'])) {
            echo 'page keys: '.implode(', ', array_keys($props['page']))."\n";
            echo 'page title: '.($props['page']['title'] ?? '')."\n";
        }
        if (isset($props['item'])) {
            echo 'item keys: '.implode(', ', array_keys($props['item']))."\n";
        }
        echo "\n";
    }
}
