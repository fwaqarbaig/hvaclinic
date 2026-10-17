<?php

$dir = __DIR__.'/../public/storage/media';
$ite = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$files = [];

foreach ($ite as $f) {
    if (! $f->isFile()) {
        continue;
    }
    $ext = strtolower($f->getExtension());
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
        $files[] = str_replace('\\', '/', substr($f->getPathname(), strlen(realpath(__DIR__.'/../public/storage')) + 1));
    }
}

echo 'Total physical media images: '.count($files).PHP_EOL;
foreach (array_slice($files, 0, 15) as $file) {
    echo ' - '.$file.PHP_EOL;
}
