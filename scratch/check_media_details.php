<?php

use App\Models\Media;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$total = Media::count();
$recovery = Media::where('file_path', 'like', '%recoverydata%')->count();
$other = Media::where('file_path', 'not like', '%recoverydata%')->get();

echo "Total: $total\n";
echo "Recoverydata: $recovery\n";
echo 'Non-recoverydata count: '.$other->count()."\n";
foreach ($other as $m) {
    echo "ID: {$m->id} | Name: {$m->name} | Path: {$m->file_path} | URL: {$m->url}\n";
}
