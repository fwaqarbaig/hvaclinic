<?php

$ind = json_decode(file_get_contents(__DIR__.'/../storage/industries.json'), true);
echo 'INDUSTRIES ('.count($ind)."):\n";
foreach ($ind as $item) {
    echo ' - '.($item['title'] ?? '').' | Slug: '.($item['id'] ?? '')."\n";
}

$loc = json_decode(file_get_contents(__DIR__.'/../storage/locations.json'), true);
echo "\nLOCATIONS (".count($loc)."):\n";
foreach ($loc as $item) {
    echo ' - '.($item['name'] ?? '').' | Hub: '.($item['hub'] ?? '')."\n";
}

$used = json_decode(file_get_contents(__DIR__.'/../storage/used_generators.json'), true);
echo "\nUSED GENERATORS & PORTACABINS (".count($used)."):\n";
foreach ($used as $item) {
    echo ' - '.($item['title'] ?? '').' | Category: '.($item['category'] ?? '')."\n";
}
