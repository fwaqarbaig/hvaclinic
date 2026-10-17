<?php

$data = json_decode(file_get_contents(__DIR__.'/../storage/generatordubai_full_data.json'), true);

$cities = ['dubai', 'abu-dhabi', 'sharjah', 'ajman', 'ras-al-khaimah', 'fujairah', 'umm-al-quwain', 'oman'];

$allCityData = [];

foreach ($cities as $c) {
    $key = "locations/$c";
    if (isset($data[$key]['props']['city'])) {
        $city = $data[$key]['props']['city'];
        echo 'Found city: '.($city['name'] ?? $c).' | Title: '.($city['hero']['title'] ?? '')."\n";
        $allCityData[$c] = $city;
    } else {
        echo "NOT FOUND for key: $key\n";
    }
}

file_put_contents(__DIR__.'/../storage/all_cities_data.json', JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ? json_encode($allCityData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : json_encode($allCityData));
echo "Saved all cities data to storage/all_cities_data.json\n";
