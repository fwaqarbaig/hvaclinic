<?php

$dir = new RecursiveDirectoryIterator(__DIR__.'/../resources/views');
$ite = new RecursiveIteratorIterator($dir);

foreach ($ite as $f) {
    if (! $f->isFile()) {
        continue;
    }
    $c = file_get_contents($f->getPathname());
    if (stripos($c, 'Select from Media') !== false) {
        echo $f->getPathname()."\n";
    }
}
