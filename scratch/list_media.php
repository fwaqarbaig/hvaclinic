<?php

use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$dir = public_path('storage/media');
$files = [];
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($iterator as $file) {
    if ($file->isFile() && preg_match('/\.(jpg|jpeg|png|webp)$/i', $file->getFilename())) {
        $files[] = str_replace(public_path(), '', $file->getPathname());
    }
}

echo 'Total images in public/storage/media: '.count($files)."\n";
foreach (array_slice($files, 0, 20) as $f) {
    echo str_replace('\\', '/', $f)."\n";
}
