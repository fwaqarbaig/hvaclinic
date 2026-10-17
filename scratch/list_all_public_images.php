<?php

$dir = __DIR__.'/../public';
$ite = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$allImages = [];

foreach ($ite as $f) {
    if (! $f->isFile()) {
        continue;
    }
    $ext = strtolower($f->getExtension());
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'])) {
        $rel = str_replace('\\', '/', substr($f->getPathname(), strlen(realpath(__DIR__.'/../public')) + 1));
        $allImages[] = $rel;
    }
}

echo 'Total images in public folder: '.count($allImages).PHP_EOL;
foreach ($allImages as $im) {
    echo ' - '.$im.PHP_EOL;
}
