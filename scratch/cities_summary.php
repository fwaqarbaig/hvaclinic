<?php

$cities = json_decode(file_get_contents(__DIR__.'/../storage/all_cities_data.json'), true);
echo "=== CITIES SUMMARY ===\n";
foreach ($cities as $slug => $c) {
    echo "Slug: $slug | Name: ".($c['name'] ?? '').' | Hub: '.($c['hub'] ?? '').' | Response: '.($c['responseTime'] ?? '')."\n";
    echo 'Keys: '.implode(', ', array_keys($c))."\n\n";
}
