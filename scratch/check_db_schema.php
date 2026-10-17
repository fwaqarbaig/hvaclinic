<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Schema;

$tables = ['posts', 'pages', 'categories', 'services', 'products'];
$result = [];
foreach ($tables as $t) {
    $result[$t] = Schema::getColumnListing($t);
}

echo json_encode($result, JSON_PRETTY_PRINT);
