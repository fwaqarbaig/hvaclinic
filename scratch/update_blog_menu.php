<?php

use App\Models\MenuItem;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

MenuItem::where('id', 269)->update(['url' => '/blog/']);
echo 'Updated MenuItem 269 (Blogs) URL to /blog/'.PHP_EOL;
