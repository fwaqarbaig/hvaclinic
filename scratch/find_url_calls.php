<?php

$dir = new RecursiveDirectoryIterator('resources/views');
$iterator = new RecursiveIteratorIterator($dir);

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (preg_match_all('/url\([\'"][^\'"]*\/[\'"]\)/', $content, $m)) {
            foreach ($m[0] as $match) {
                if ($match !== "url('/')") {
                    echo $file->getPathname() . " -> " . $match . "\n";
                }
            }
        }
    }
}
