<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Media;
use Illuminate\Contracts\Console\Kernel;

$media = Media::latest()->take(10)->get();
echo 'Media count: '.Media::count().PHP_EOL;
foreach ($media as $m) {
    echo "ID {$m->id}: file_path='{$m->file_path}', disk='{$m->disk}', url='{$m->url}'".PHP_EOL;
    $path = public_path(str_replace(url('/').'/', '', $m->url));
    echo '       exists on disk: '.(file_exists($path) ? 'YES' : 'NO ('.$path.')').PHP_EOL;
}
