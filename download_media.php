<?php

$content = file_get_contents(__DIR__.'/storage/generatordubai_full_data.json');
preg_match_all('#(/storage/media/[^"\'\s]+)#', $content, $m);
$images = array_unique($m[1]);

echo 'Found '.count($images)." media images.\n";

$ctx = stream_context_create([
    'http' => [
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n",
        'timeout' => 15,
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);

foreach ($images as $imgPath) {
    $fullUrl = 'https://generatordubai.com'.$imgPath;
    $targetFile = __DIR__.'/public'.$imgPath;
    $targetDir = dirname($targetFile);
    if (! is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (file_exists($targetFile) && filesize($targetFile) > 0) {
        echo "Exists: {$imgPath}\n";

        continue;
    }

    echo "Downloading {$fullUrl}... ";
    $data = @file_get_contents($fullUrl, false, $ctx);
    if ($data) {
        file_put_contents($targetFile, $data);
        echo 'OK ('.round(strlen($data) / 1024, 1)." KB)\n";
    } else {
        echo "FAILED\n";
    }
}

echo "Image download complete!\n";
