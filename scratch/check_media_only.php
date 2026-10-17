<?php

use App\Models\Media;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$allMedia = Media::latest()->get();
echo 'Total Media: '.$allMedia->count()."\n";
foreach ($allMedia as $m) {
    $path = public_path('storage/'.ltrim(str_replace('storage/', '', $m->file_path), '/'));
    $status = file_exists($path) ? 'EXISTS' : "MISSING: $path";
    echo "ID {$m->id} | {$m->file_name} | {$m->url} | {$status}\n";
}
