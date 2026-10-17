<?php

$dir = __DIR__.'/../public/wp-content/uploads/2026/04';
if (! is_dir($dir)) {
    mkdir($dir, 0755, true);
}

$ch = curl_init('https://hvaclinic.com/wp-content/uploads/2026/04/fav.png');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
$data = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($code == 200 && strlen($data) > 0) {
    file_put_contents($dir.'/fav.png', $data);
    file_put_contents(__DIR__.'/../public/favicon.ico', $data);
    file_put_contents(__DIR__.'/../public/favicon.png', $data);
    echo 'Successfully downloaded fav.png (bytes: '.strlen($data).")\n";
} else {
    echo "Download failed with HTTP code $code\n";
}
