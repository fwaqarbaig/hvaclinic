<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

use App\Models\Page;

$p = Page::find(27);
if (!$p) {
    die("Page 27 not found!\n");
}

$p->schema_markup = null;
$p->og_description = 'Rental high-performance chiller in UAE with HVAC Clinic. Fast delivery, flexible terms, and reliable cooling solutions.';
$p->title = 'Home – HVAC Clinic – Rental Chiller – Rental Power';
$p->save();

echo "Page 27 updated successfully!\n";
echo "Title: " . $p->title . "\n";
echo "OG Desc: " . $p->og_description . "\n";
echo "Schema Markup: " . var_export($p->schema_markup, true) . "\n";
