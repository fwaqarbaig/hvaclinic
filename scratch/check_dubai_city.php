<?php

$cities = json_decode(file_get_contents(__DIR__.'/../storage/all_cities_data.json'), true);
print_r($cities['dubai']['districts'] ?? []);
print_r($cities['dubai']['services'] ?? []);
