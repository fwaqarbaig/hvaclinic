<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

$request = Request::create('/', 'GET');
$response = $kernel->handle($request);
$html = $response->getContent();

preg_match_all('/<a[^>]+href=["\']([^"\']+)["\']/i', $html, $matches);
$links = array_unique($matches[1]);

echo "Found " . count($links) . " unique links on homepage.\n";

$internalLinks = [];
foreach ($links as $link) {
    if (str_starts_with($link, '#') || str_starts_with($link, 'tel:') || str_starts_with($link, 'mailto:') || str_starts_with($link, 'javascript:')) {
        continue;
    }
    $url = $link;
    if (str_starts_with($url, 'https://hvaclinic.com')) {
        $url = substr($url, strlen('https://hvaclinic.com'));
    } elseif (str_starts_with($url, 'http://localhost:8000')) {
        $url = substr($url, strlen('http://localhost:8000'));
    } elseif (str_starts_with($url, 'http://127.0.0.1:8000')) {
        $url = substr($url, strlen('http://127.0.0.1:8000'));
    }
    
    if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
        continue; // external
    }
    
    $internalLinks[] = $url ?: '/';
}

$internalLinks = array_unique($internalLinks);
echo "Checking " . count($internalLinks) . " internal links:\n\n";

$redirects = [];
$errors = [];
$okCount = 0;

foreach ($internalLinks as $path) {
    $subReq = Request::create($path, 'GET');
    $subRes = $kernel->handle($subReq);
    $status = $subRes->getStatusCode();
    
    if ($status >= 300 && $status < 400) {
        $target = $subRes->headers->get('Location');
        $redirects[] = "  $path -> $status -> $target";
    } elseif ($status >= 400) {
        $errors[] = "  $path -> $status";
    } else {
        $okCount++;
    }
}

echo "OK (200): $okCount\n";
if (!empty($redirects)) {
    echo "REDIRECTS (" . count($redirects) . "):\n" . implode("\n", $redirects) . "\n";
} else {
    echo "REDIRECTS: 0 (All direct!)\n";
}
if (!empty($errors)) {
    echo "ERRORS (" . count($errors) . "):\n" . implode("\n", $errors) . "\n";
} else {
    echo "ERRORS: 0\n";
}
