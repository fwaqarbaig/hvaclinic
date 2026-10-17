<?php

require 'vendor/autoload.php';

$jsonPath = 'database/data/hvaclinic-content.json';
$data = json_decode(file_get_contents($jsonPath), true);

$urls = [];
foreach ($data['records'] as $record) {
    $content = (string) ($record['content'] ?? '');
    preg_match_all('/https?:\/\/(?:www\.)?hvaclinic\.com\/wp-content\/uploads\/[^"\'\s<>\)]+/i', $content, $matches);
    foreach ($matches[0] as $url) {
        $url = rtrim($url, '.,;');
        $urls[$url] = true;
    }
    if (! empty($record['featured_image']) && str_contains($record['featured_image'], '/wp-content/uploads/')) {
        $urls[$record['featured_image']] = true;
    }
}
$urls['https://hvaclinic.com/wp-content/uploads/2026/03/hvac.gif'] = true;
$urls['https://hvaclinic.com/wp-content/uploads/2026/03/1.jpg'] = true;

$total = count($urls);
echo "Total URLs to download: $total\n";

$targetPrefix = __DIR__.'/../public/wp-content/uploads/';
$urlList = [];

foreach (array_keys($urls) as $url) {
    $path = parse_url($url, PHP_URL_PATH);
    $prefix = '/wp-content/uploads/';
    if (! is_string($path) || ! str_starts_with($path, $prefix)) {
        continue;
    }
    $relativePath = substr($path, strlen($prefix));
    $dest = $targetPrefix.$relativePath;
    if (! file_exists($dest)) {
        $urlList[] = ['url' => $url, 'dest' => $dest];
    }
}

echo 'Needed downloads: '.count($urlList)."\n";

// Multi-curl concurrent downloader (batch of 20)
$concurrency = 20;
$chunks = array_chunk($urlList, $concurrency);
$downloaded = 0;
$failed = 0;

foreach ($chunks as $chunkIndex => $chunk) {
    $mh = curl_multi_init();
    $handles = [];
    $fileHandles = [];

    foreach ($chunk as $item) {
        $dir = dirname($item['dest']);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $fp = fopen($item['dest'].'.tmp', 'w');
        if (! $fp) {
            continue;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $item['url']);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
        curl_multi_add_handle($mh, $ch);

        $handles[(int) $ch] = ['ch' => $ch, 'dest' => $item['dest'], 'fp' => $fp, 'url' => $item['url']];
    }

    $running = null;
    do {
        curl_multi_exec($mh, $running);
        curl_multi_select($mh, 0.5);
    } while ($running > 0);

    foreach ($handles as $h) {
        $ch = $h['ch'];
        $dest = $h['dest'];
        $fp = $h['fp'];
        $url = $h['url'];

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_multi_remove_handle($mh, $ch);
        curl_close($ch);
        fclose($fp);

        if ($httpCode >= 200 && $httpCode < 400 && filesize($dest.'.tmp') > 0) {
            rename($dest.'.tmp', $dest);
            $downloaded++;
        } else {
            @unlink($dest.'.tmp');
            $failed++;
        }
    }

    curl_multi_close($mh);
    echo 'Progress: '.($chunkIndex + 1) * $concurrency.' / '.count($urlList)." (Success: $downloaded, Failed: $failed)\n";
}

echo "Finished media download. Total downloaded: $downloaded, Failed: $failed\n";
