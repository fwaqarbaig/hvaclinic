<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = DB::select('SHOW TABLES');
echo "Total tables: " . count($tables) . "\n";
foreach ($tables as $t) {
    $name = array_values((array)$t)[0];
    $cnt = DB::table($name)->count();
    echo "  $name: $cnt rows\n";
}
