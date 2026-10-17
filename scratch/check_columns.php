<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Schema;

echo "Pages columns:\n";
print_r(Schema::getColumnListing('pages'));

echo "\nPosts columns:\n";
print_r(Schema::getColumnListing('posts'));

echo "\nServices columns:\n";
print_r(Schema::getColumnListing('services'));

echo "\nRedirect Rules columns:\n";
print_r(Schema::getColumnListing('redirect_rules'));
