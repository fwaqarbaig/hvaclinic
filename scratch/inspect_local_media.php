<?php

$dir = __DIR__.'/../public/storage/media';
$ite = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$files = [];

foreach ($ite as $f) {
    if (! $f->isFile()) {
        continue;
    }
    $ext = strtolower($f->getExtension());
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'svg'])) {
        $realPath = $f->getRealPath();
        $relPath = str_replace('\\', '/', substr($realPath, strlen(realpath(__DIR__.'/../public/storage')) + 1));
        $size = filesize($realPath);
        $imgInfo = @getimagesize($realPath);
        $dims = $imgInfo ? ($imgInfo[0].'x'.$imgInfo[1]) : '';
        $mime = $imgInfo['mime'] ?? ('image/'.($ext === 'jpg' ? 'jpeg' : $ext));

        $files[] = [
            'file_name' => $f->getFilename(),
            'file_path' => $relPath,
            'size' => $size,
            'dimensions' => $dims,
            'mime_type' => $mime,
        ];
    }
}

echo 'Found '.count($files)." local media files:\n";
print_r($files);
