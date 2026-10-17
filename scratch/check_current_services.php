<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

foreach (Service::all() as $s) {
    echo "ID: {$s->id} | Slug: {$s->slug} | Title: {$s->title}\n";
}
