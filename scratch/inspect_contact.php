<?php

use App\Models\Page;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$p = Page::where('slug', 'contact')->first();
echo json_encode($p ? $p->toArray() : ['status' => 'not found'], JSON_PRETTY_PRINT);
