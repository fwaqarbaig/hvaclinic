<?php

$sitemapXml = file_get_contents('https://generatordubai.com/sitemap.xml');
if (! $sitemapXml) {
    exit("Failed to fetch sitemap\n");
}

$xml = simplexml_load_string($sitemapXml);
$urls = [];
foreach ($xml->url as $u) {
    $urls[] = (string) $u->loc;
}

echo 'Found '.count($urls)." URLs in sitemap.\n";

$data = [];
$ctx = stream_context_create([
    'http' => [
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\nAccept: text/html\r\n",
        'timeout' => 20,
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);

foreach ($urls as $i => $url) {
    $num = $i + 1;
    echo "[{$num}/".count($urls)."] Fetching: {$url}... ";
    $html = @file_get_contents($url, false, $ctx);
    if (! $html) {
        echo "FAILED\n";

        continue;
    }

    if (preg_match('/data-page="([^"]+)"/', $html, $matches)) {
        $decoded = html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $pageObj = json_decode($decoded, true);
        $path = trim(parse_url($url, PHP_URL_PATH) ?? '', '/');
        if (empty($path)) {
            $path = 'home';
        }

        $data[$path] = [
            'url' => $url,
            'component' => $pageObj['component'] ?? '',
            'props' => $pageObj['props'] ?? [],
        ];
        echo 'OK ('.($pageObj['component'] ?? 'no component').")\n";
    } else {
        echo "NO DATA-PAGE\n";
    }
}

if (! is_dir(__DIR__.'/storage/app')) {
    mkdir(__DIR__.'/storage/app', 0777, true);
}

$outPath = __DIR__.'/storage/generatordubai_full_data.json';
file_put_contents($outPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
echo "\nSaved ".count($data)." pages to {$outPath} (".round(filesize($outPath) / 1024, 2)." KB)\n";
