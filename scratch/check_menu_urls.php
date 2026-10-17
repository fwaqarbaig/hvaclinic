<?php

use App\Models\MenuItem;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "Menu items in DB:\n";
foreach (MenuItem::all() as $m) {
    echo "ID: {$m->id} | {$m->title} | URL: {$m->url} | Parent: ".($m->parent_id ?? 'None')."\n";
}
