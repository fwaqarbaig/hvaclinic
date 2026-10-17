<?php

require __DIR__.'/../vendor/autoload.php';

$allMedia = [];
$dirsToSearch = ['public', 'storage'];
foreach ($dirsToSearch as $dir) {
    if (is_dir($dir)) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $ext = strtolower($file->getExtension());
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'])) {
                    $allMedia[] = str_replace(DIRECTORY_SEPARATOR, '/', $file->getPathname());
                }
            }
        }
    }
}

echo 'Found '.count($allMedia)." image files on disk:\n";
foreach ($allMedia as $m) {
    echo "  $m\n";
}
