<?php

function getWpEndpoint($endpoint)
{
    $url = 'https://www.hvaclinic.com/wp-json/wp/v2/'.$endpoint;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    $res = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headers = curl_getinfo($ch);
    curl_close($ch);

    return [$httpCode, $res];
}

[$code, $res] = getWpEndpoint('pages?per_page=100');
echo "Pages HTTP Code: $code, length: ".strlen($res)."\n";
if ($code == 200) {
    $pages = json_decode($res, true);
    echo 'Pages count on page 1: '.count($pages)."\n";
}

[$code, $res] = getWpEndpoint('posts?per_page=100');
echo "Posts HTTP Code: $code, length: ".strlen($res)."\n";
if ($code == 200) {
    $posts = json_decode($res, true);
    echo 'Posts count on page 1: '.count($posts)."\n";
}

[$code, $res] = getWpEndpoint('categories?per_page=100');
echo "Categories HTTP Code: $code, length: ".strlen($res)."\n";
if ($code == 200) {
    $cats = json_decode($res, true);
    echo 'Categories count: '.count($cats)."\n";
}
