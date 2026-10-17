<?php

$cities = json_decode(file_get_contents(__DIR__.'/../storage/all_cities_data.json'), true);
foreach ($cities as $k => $c) {
    echo $k.' | Depot: '.($c['depot'] ?? 'N/A').' | Authority: '.($c['authority'] ?? 'N/A').' | SLA: '.($c['deliveryTime'] ?? 'N/A')."\n";
}
