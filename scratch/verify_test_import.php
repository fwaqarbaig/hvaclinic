<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'hvac_import_test'");
echo "Tables in hvac_import_test: " . count($tables) . "\n";
foreach ($tables as $t) {
    $tableName = $t->TABLE_NAME ?? $t->table_name;
    $count = DB::selectOne("SELECT COUNT(*) as c FROM hvac_import_test.`$tableName`")->c;
    echo "  $tableName: $count rows\n";
}

// Clean up
DB::statement("DROP DATABASE IF EXISTS hvac_import_test");
echo "Temporary database dropped successfully.\n";
