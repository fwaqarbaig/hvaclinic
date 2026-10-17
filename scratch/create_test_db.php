<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    DB::statement("DROP DATABASE IF EXISTS hvac_import_test");
    DB::statement("CREATE DATABASE hvac_import_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Created database hvac_import_test.\n";
} catch (\Exception $e) {
    die("Error creating db: " . $e->getMessage() . "\n");
}
