<?php

function getHeaders($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

$pagesHeader = getHeaders('https://www.hvaclinic.com/wp-json/wp/v2/pages?per_page=100');
$postsHeader = getHeaders('https://www.hvaclinic.com/wp-json/wp/v2/posts?per_page=100');

preg_match('/x-wp-total:\s*(\d+)/i', $pagesHeader, $pTotal);
preg_match('/x-wp-totalpages:\s*(\d+)/i', $pagesHeader, $pPages);
preg_match('/x-wp-total:\s*(\d+)/i', $postsHeader, $bTotal);
preg_match('/x-wp-totalpages:\s*(\d+)/i', $postsHeader, $bPages);

echo 'Total WP Pages: '.($pTotal[1] ?? 'unknown').' across '.($pPages[1] ?? 'unknown')." pages\n";
echo 'Total WP Posts: '.($bTotal[1] ?? 'unknown').' across '.($bPages[1] ?? 'unknown')." pages\n";
