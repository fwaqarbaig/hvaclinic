<?php

use GuzzleHttp\Client;

$client = new Client(['verify' => false, 'timeout' => 15]);

echo "Checking WP REST API endpoints:\n";
try {
    $res = $client->get('https://hvaclinic.com/wp-json/wp/v2/types');
    $types = json_decode($res->getBody(), true);
    print_r(array_keys($types));
} catch (Exception $e) {
    echo 'Error fetching types: '.$e->getMessage()."\n";
}

$endpoints = ['posts', 'pages', 'categories', 'tags', 'media'];
foreach ($endpoints as $ep) {
    try {
        $res = $client->head("https://hvaclinic.com/wp-json/wp/v2/$ep?per_page=1");
        $total = $res->getHeaderLine('X-WP-Total');
        $pages = $res->getHeaderLine('X-WP-TotalPages');
        echo "$ep: Total = $total, Pages = $pages\n";
    } catch (Exception $e) {
        echo "$ep: Error ".$e->getMessage()."\n";
    }
}
