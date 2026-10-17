<?php

$dir = new RecursiveDirectoryIterator(__DIR__.'/../resources/views/admin');
$ite = new RecursiveIteratorIterator($dir);

foreach ($ite as $f) {
    if (! $f->isFile()) {
        continue;
    }
    $lines = explode("\n", file_get_contents($f->getPathname()));
    foreach ($lines as $i => $line) {
        if (str_contains($line, "asset('storage/") || str_contains($line, 'asset("storage/')) {
            echo $f->getPathname().' line '.($i + 1).': '.trim($line)."\n";
        }
    }
}
