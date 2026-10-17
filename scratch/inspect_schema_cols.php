<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "POSTS COLUMNS:\n";
print_r(Schema::getColumnListing('posts'));

echo "\nPAGES COLUMNS:\n";
print_r(Schema::getColumnListing('pages'));

echo "\nSERVICES COLUMNS:\n";
print_r(Schema::getColumnListing('services'));

echo "\nMEDIA COUNT & SAMPLE:\n";
echo 'Count: '.DB::table('media')->count()."\n";
print_r(DB::table('media')->limit(5)->get()->toArray());
