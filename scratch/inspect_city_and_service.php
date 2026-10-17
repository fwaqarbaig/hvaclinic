<?php

$data = json_decode(file_get_contents(__DIR__.'/../storage/generatordubai_full_data.json'), true);

echo "=== ALL CITIES ===\n";
if (isset($data['locations/dubai']['props']['allCities'])) {
    foreach ($data['locations/dubai']['props']['allCities'] as $c) {
        echo '- '.($c['name'] ?? $c['title'] ?? '').' | Slug: '.($c['slug'] ?? '')."\n";
    }
}

echo "\n=== DUBAI CITY DATA ===\n";
if (isset($data['locations/dubai']['props']['city'])) {
    print_r($data['locations/dubai']['props']['city']);
}

echo "\n=== SERVICE: POWER PLANT ===\n";
if (isset($data['services/power-plant']['props']['service'])) {
    print_r($data['services/power-plant']['props']['service']);
}
