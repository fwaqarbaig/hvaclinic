<?php

$dir = new RecursiveDirectoryIterator(__DIR__.'/../resources/views');
$ite = new RecursiveIteratorIterator($dir);

foreach ($ite as $file) {
    if (! $file->isFile()) {
        continue;
    }
    $content = file_get_contents($file->getPathname());
    if (stripos($content, 'Yoast SEO') !== false || stripos($content, 'FOCUS KEYPHRASE') !== false || stripos($content, 'Yoast Signals') !== false || stripos($content, 'Google Search Snippet Preview') !== false) {
        echo $file->getPathname()."\n";
    }
}
